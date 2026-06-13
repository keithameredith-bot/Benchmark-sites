---
name: prospect-pitch
description: Audit a prospect's existing website (one you don't run) and build a redesign mockup to win the business. Use when the user wants to pitch a web-redesign to a prospect, "scalp"/analyze a competitor or prospect site, or prep a sales mockup. Produces a data-backed audit (architecture, content inventory, DataForSEO rankings + gaps, design teardown) and a homepage mockup. Pitch artifact only — never publish the prospect's content/images on a live site without rights.
---

# Prospect Pitch — audit + redesign mockup to win the deal

Three stages: **audit → mockup → (if won) migrate.** The prospect's site is public, so analyzing and
screenshotting it for a pitch is fine. Do NOT push their copyrighted content or licensed/stock images
onto a live site you control before you have the rights — keep the mockup as a pitch artifact (local +
screenshots).

## Step 1 — Identity & recon
Fetch the homepage; determine: business name, niche, **location/service area**, platform (look for
`wp-content`=WordPress, theme e.g. `themes/Divi`, or Shopify/Squarespace/Wix), and the nav/page list.
A Divi/Wix/old-WordPress site = strong redesign+migration angle (slow, dated). Note the award/USP.

## Step 2 — Capture & architecture
- Page list from `sitemap_index.xml` / `wp-sitemap.xml` + homepage nav.
- Optional full mirror for offline content reference: `wget --mirror -p --convert-links -e robots=off
  --wait=1 <url>` or HTTrack (throttle; be polite).
- Content inventory per key page: title, H1, rough word count, meta, schema → flags thin vs solid.

## Step 3 — DataForSEO audit (the edge — this wins pitches)
Run `prospect-audit.py <domain> [location_code]` (auth `~/.dataforseo-auth`; US 2840, FL 21142,
Ocala 1015141). It pulls the prospect's ranked keywords → **top pages** (where is their traffic
concentrated? often one page = an opportunity), **low-hanging fruit** (pos 4–20 they nearly rank for),
**top keywords**, and total organic estimate. Then `prospect-audit.py serp <loc> "<money term>"` for the
local money terms to see who's beating them. The story usually writes itself: "you rank #N for <high-
value term> — a redesign with a dedicated page + on-page SEO pushes it to top 3."

## Step 4 — Design teardown
Pull colors/fonts from the homepage CSS (grep `font-family:` and `#hexes`). Note brand colors worth
keeping vs dated/default theme styling to fix (e.g. Divi's default blue `#2ea3f2` bleeding through).

## Step 5 — Scaffold the pitch workspace
`Desktop\<slug>-pitch\` with `AUDIT.md` (templates/AUDIT.md.tmpl — the sales document) and
`PITCH-STATUS.md`. A pitch workspace, not a client workspace — keep it OUT of the client repo until won.
Make a `Claude - <Name> Pitch` desktop shortcut (wt -d <dir> cmd /k claude.exe).

## Step 6 — The mockup
Build a redesigned **homepage** as a self-contained HTML file (`mockup/index.html`) using the Benchmark
design system (reuse hero/band/card/footer patterns from `benchmark-sites/fgs` + `black-rock`), adapted
to the prospect's brand colors. Use their REAL content (headlines, services, USP, award) so they see
*their* business reimagined. Render a screenshot with headless Edge for the pitch
(`msedge --headless=new --screenshot=...`). Keep their images as placeholders unless you have rights.

## Step 7 — Pitch framing & (if won) migrate
Deliverable to the prospect = AUDIT.md highlights + the mockup screenshot: "here's what you rank for,
here's what you're leaving on the table, here's the redesign that captures it." If they sign:
spin up a real client workspace via the migration approach — **preserve the ranking URLs/titles/content
the audit flagged**, rebuild on Kadence, fix the thin pages, fill the keyword gaps. Add to Mission
Control + repo then (not before).
