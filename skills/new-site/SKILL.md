---
name: new-site
description: Spin up a brand-new from-scratch website build (NOT a migration) for a Benchmark Web Development client on WordPress + Kadence. Use when the user says they're starting a new site/client from scratch, mapping a site from keyword research, or "new build." Scaffolds the workspace, runs DataForSEO keyword + market research, maps the site architecture from the data, and wires it into Mission Control + the git repo. Do NOT use for migrations of existing sites (those preserve URLs/rankings).
---

# New Site — from scratch (Kadence, research-first)

A from-scratch build is the INVERSE of a migration: there are no existing URLs or rankings to
preserve, and no domain authority to lean on. So **keyword research drives the architecture**, not
just the content. Work in this order and don't skip ahead — don't build pages until the keyword map
and the architecture are approved by Keith.

Shared conventions auto-load from `~/.claude/CLAUDE.md` (WP+Kadence stack, truth-audit, `wp_slash()`,
`wp eval-file`, self-canonical rules, design system). This skill is the from-scratch front end to them.

## Step 1 — Gather the essentials (ask if not given)
- Business name · industry/what they do · primary location + service area (these are FL local
  businesses) · domain (chosen or TBD) · any existing presence (old site / GBP / social / nothing).
Pick a short slug (e.g. "acme-roofing") for the folder/ids.

## Step 2 — Scaffold the workspace
Create `C:\Users\keith\Desktop\<slug>-workspace\` with:
- `CLAUDE.md` — copy `templates/CLAUDE.md.tmpl` from this skill and fill the placeholders.
- `PROJECT-STATUS.md` — copy `templates/PROJECT-STATUS.md.tmpl`; this is the live handoff.
- `KEYWORD-RESEARCH.md` — created in Step 3 from the research.
- `keywords.txt` — the seed keyword list you research (one per line).
Then a desktop shortcut (PowerShell, WScript.Shell): target `wt.exe`, args
`-d "<workspace>" cmd /k "C:\Users\keith\.local\bin\claude.exe"`, name `Claude - <Name>.lnk` on the Desktop.
(LocalWP site + `wp-env.sh` come later, when Keith creates the Local site — don't fake it.)

## Step 3 — DataForSEO research (the foundation)
Auth: `~/.dataforseo-auth` (Basic token). Helper: run `dfs-research.py` in this skill folder.
Location codes: US `2840` · Florida `21142` · Ocala `1015141` (look up others via the DataForSEO
locations endpoint if the city differs).

Build the seed list from the niche: head terms, "<service> near me", each service, city-modified
("<service> <city>"), and question/long-tail. Then:
1. **Search volumes** — `keywords_data/google_ads/search_volume/live` (batch up to 1000 in one call).
2. **SERP + competitors** — `serp/google/organic/live/regular` for the top 3-5 money terms at the
   local `location_code`; record who ranks (national firms vs local vs directories) and whether their
   titles even target the term.
3. **Competitor strength** — `dataforseo_labs/google/bulk_traffic_estimation/live` (one call, all
   competitor domains) for organic visits; `ranked_keywords/live` (ONE target per call) on the top
   1-2 competitors to see what's winning them traffic.

Write `KEYWORD-RESEARCH.md`: a volume table sorted by volume; the SERP landscape per money term; a
competitor strength table; and a **keyword map grouped by intent** (service / local / informational)
with each cluster tagged **attainable-now** (low competition, long-tail, "near me", city terms) vs
**aspirational-later** (head terms needing authority). New domains have zero authority — the early
content plan targets attainable-now first and builds a moat; flag head terms as later goals.

## Step 4 — Site architecture FROM the map
Design the full URL/page tree before building (this is the from-scratch advantage — ideal structure,
no legacy baggage):
- Home · service **pillars** · individual **service pages** (one per high-intent service term) ·
  **location wheel** (city/area pages for the service-area towns) · About / Contact / Reviews /
  Gallery · Blog (supporting/informational terms → posts, on a cadence).
- Every page self-canonical; location spokes NEVER canonicalized to pillars. Plan the internal-link
  mesh (pillars ↔ services ↔ locations). Put the map in PROJECT-STATUS.md and get Keith's approval.

## Step 5 — Wire it into the system
- Add a site object to Mission Control: `benchmark-sites/mission-control/data/<id>.js` (copy an
  existing one's shape: id, name, color, site, stage "Pre-launch — in build", cadence "2 posts/month"
  default, gbp "2 GBP posts/week + 1 per blog", traffic from the research, items from the architecture
  as a build queue). Add `<id>` to `pull-performance.py`'s domains dict once a domain exists.
- Add the workspace to `benchmark-sites/sync-to-repo.ps1` (a `robocopy ... <slug>\workspace` line) so
  it's versioned. Commit + push (pull --rebase first; one writer per file).

## Step 6 — Build (ongoing, per global conventions)
Reuse the design system from `benchmark-sites/fgs/` + `black-rock/` (hero/band/footer/card patterns).
Truth-audit everything — never fabricate credentials, licenses, reviews, or projects (ask the client).
`wp_slash()` on all content writes; `wp eval-file` not inline eval; DB backup before DB changes;
self-canonical sweep; AIOSEO LocalBusiness schema for the niche; OG image + theme-color; llms.txt.
GBP from day one — for a new local brand it's the fastest early traffic.
