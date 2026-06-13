#!/usr/bin/env python3
"""DataForSEO research helper for new-site keyword mapping.

Usage (run from the site workspace folder):
  python dfs-research.py volumes <location_code>          # reads keywords.txt -> keyword-volumes.json + table
  python dfs-research.py serp <location_code> "keyword"   # top-10 organic for one money term (who ranks)
  python dfs-research.py traffic <domain> [<domain> ...]  # organic visit estimate per competitor domain

Location codes: US 2840 · Florida 21142 · Ocala 1015141 (others: DataForSEO locations endpoint).
Auth: ~/.dataforseo-auth (Basic token).
"""
import sys, json, os, urllib.request

BASE = "https://api.dataforseo.com/v3/"
TOKEN = open(os.path.expanduser("~/.dataforseo-auth")).read().strip()

def call(path, payload):
    req = urllib.request.Request(BASE + path, data=json.dumps(payload).encode(),
        headers={"Authorization": "Basic " + TOKEN, "Content-Type": "application/json"})
    return json.load(urllib.request.urlopen(req))

def volumes(loc):
    kws = [l.strip() for l in open("keywords.txt") if l.strip()]
    if not kws:
        sys.exit("keywords.txt is empty — add seed keywords (one per line).")
    r = call("keywords_data/google_ads/search_volume/live",
             [{"keywords": kws, "location_code": int(loc), "language_code": "en"}])
    items = (r["tasks"][0].get("result") or [])
    rows = [{"kw": i.get("keyword"), "vol": i.get("search_volume") or 0,
             "comp": i.get("competition"), "cpc": i.get("cpc")} for i in items]
    rows.sort(key=lambda x: x["vol"] or 0, reverse=True)
    json.dump(rows, open("keyword-volumes.json", "w"), indent=2)
    print(f"{'VOL':>7}  {'COMP':<8} {'CPC':>6}  KEYWORD")
    for x in rows:
        print(f"{x['vol']:>7}  {str(x['comp'] or ''):<8} {str(x['cpc'] or ''):>6}  {x['kw']}")
    print(f"\n{len(rows)} keywords -> keyword-volumes.json")

def serp(loc, kw):
    r = call("serp/google/organic/live/regular",
             [{"keyword": kw, "location_code": int(loc), "language_code": "en", "depth": 20}])
    res = (r["tasks"][0].get("result") or [])
    items = (res[0].get("items") if res else []) or []
    print(f"SERP — \"{kw}\" (loc {loc})")
    n = 0
    for it in items:
        if it.get("type") != "organic":
            continue
        n += 1
        print(f"  {it.get('rank_group'):>2}. {it.get('domain'):<32} {(it.get('title') or '')[:60]}")
        if n >= 10:
            break

def traffic(domains):
    r = call("dataforseo_labs/google/bulk_traffic_estimation/live",
             [{"targets": list(domains), "location_code": 2840, "language_code": "en"}])
    res = (r["tasks"][0].get("result") or [])
    for it in (res[0].get("items") if res else []) or []:
        org = (it.get("metrics", {}) or {}).get("organic", {}) or {}
        print(f"  {it.get('target'):<34} ~{round(org.get('etv', 0)):>6} visits/mo · {org.get('count', 0)} kw")

if __name__ == "__main__":
    mode = sys.argv[1] if len(sys.argv) > 1 else ""
    if mode == "volumes":   volumes(sys.argv[2])
    elif mode == "serp":    serp(sys.argv[2], sys.argv[3])
    elif mode == "traffic": traffic(sys.argv[2:])
    else: sys.exit(__doc__)
