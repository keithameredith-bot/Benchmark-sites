#!/usr/bin/env python3
"""Prospect SEO audit via DataForSEO — the data that wins redesign pitches.

Usage:
  python prospect-audit.py <domain> [location_code]      # ranked kw -> top pages, fruit, top kw, traffic
  python prospect-audit.py serp <location_code> "term"   # who ranks for a local money term
Auth: ~/.dataforseo-auth.  Location codes: US 2840 · Florida 21142 · Ocala 1015141.
Writes audit-data.json in the cwd.
"""
import sys, json, os, urllib.request
T = open(os.path.expanduser("~/.dataforseo-auth")).read().strip()
def call(p, b):
    r = urllib.request.Request("https://api.dataforseo.com/v3/" + p, data=json.dumps(b).encode(),
        headers={"Authorization": "Basic " + T, "Content-Type": "application/json"})
    return json.load(urllib.request.urlopen(r))

def audit(domain, loc):
    r = call("dataforseo_labs/google/ranked_keywords/live",
             [{"target": domain, "location_code": int(loc), "language_code": "en", "limit": 600}])
    res = (r["tasks"][0].get("result") or []); items = (res[0].get("items") if res else []) or []
    pages = {}; fruit = []; total = 0; allkw = []
    for it in items:
        kd = it.get("keyword_data", {}); ki = kd.get("keyword_info", {}) or {}
        kw = kd.get("keyword", ""); vol = ki.get("search_volume") or 0
        se = (it.get("ranked_serp_element") or {}).get("serp_item", {}) or {}
        url = (se.get("url") or "").replace("https://", "").replace("http://", "")
        pos = se.get("rank_group") or 999; etv = se.get("etv") or 0
        total += etv
        if url: p = pages.setdefault(url, {"etv": 0, "kw": 0}); p["etv"] += etv; p["kw"] += 1
        allkw.append({"kw": kw, "vol": vol, "pos": pos, "etv": etv})
        if 4 <= pos <= 20 and vol >= 20: fruit.append({"kw": kw, "vol": vol, "pos": pos})
    top_pages = sorted(({"url": u, **d} for u, d in pages.items()), key=lambda x: x["etv"], reverse=True)[:8]
    top_kw = sorted(allkw, key=lambda x: x["etv"], reverse=True)[:12]
    fruit = sorted(fruit, key=lambda x: x["vol"], reverse=True)[:12]
    out = {"domain": domain, "total_kw": len(items), "est_visits": round(total),
           "top_pages": [{"url": p["url"], "etv": round(p["etv"]), "kw": p["kw"]} for p in top_pages],
           "top_keywords": top_kw, "fruit": fruit}
    json.dump(out, open("audit-data.json", "w"), indent=2)
    print(f"{domain}: {out['total_kw']} ranked kw · ~{out['est_visits']} organic visits/mo")
    print("\nTOP PAGES (traffic concentration):")
    for p in out["top_pages"]: print(f"  {p['etv']:>5} v/mo  {p['kw']:>2}kw  {p['url'][:60]}")
    print("\nLOW-HANGING FRUIT (pos 4-20 — push to top 3):")
    for f in fruit: print(f"  #{f['pos']:<3} {f['vol']:>5}/mo  {f['kw']}")
    print("\n-> audit-data.json")

def serp(loc, kw):
    r = call("serp/google/organic/live/regular",
             [{"keyword": kw, "location_code": int(loc), "language_code": "en", "depth": 20}])
    res = (r["tasks"][0].get("result") or []); items = (res[0].get("items") if res else []) or []
    print(f'SERP "{kw}" (loc {loc}):')
    n = 0
    for it in items:
        if it.get("type") != "organic": continue
        n += 1; print(f"  {it.get('rank_group'):>2}. {it.get('domain'):<34}{(it.get('title') or '')[:55]}")
        if n >= 10: break

if __name__ == "__main__":
    a = sys.argv
    if len(a) >= 2 and a[1] == "serp": serp(a[2], a[3])
    elif len(a) >= 2: audit(a[1], a[2] if len(a) > 2 else "2840")
    else: sys.exit(__doc__)
