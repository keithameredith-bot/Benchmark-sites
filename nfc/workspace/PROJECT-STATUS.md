# PROJECT-STATUS.md — North Florida Container & Truck Repair (from-scratch build)

> Source of truth. Same script-driven workflow as the other Benchmark sites (idempotent eval-file
> scripts, verify before/after, Keith approves copy, no deploys without his go-ahead).

Last updated: 2026-06-13 (workspace created, research done, architecture approved)

## The job
Brand-new Kadence website for North Florida Container & Truck Repair (dumpster / container & truck
repair), Ocala FL. From scratch — research first, then architecture, then build. Goal: rank + convert
across Central & North Florida. Channel reality: very low search volume — **GBP + Maps + direct
outreach to haulers/cities/property managers is the real engine**; the site converts and captures the
high-intent "near me" trickle where there's zero local competition.

## Where things live
- Workspace: `C:\Users\keith\Desktop\north-fl-container-workspace\`
- LocalWP: (create site → record path/id/mysql port here, then write wp-env.sh)
- Domain: floridadumpsterrepair.com (registered & owned)
- Mission Control id: `nfc` · repo folder `benchmark-sites/nfc/workspace`

## Confirmed services (truth-audited — build only these)
1. **In-shop dumpster & roll-off container repair + refurbishment** (welding, rust/floor, repaint, doors, hinges) — the core
2. **Commercial compactor repair** — drop-off / in-shop only
3. **Garbage / roll-off (refuse) truck repair & refurbishment** — yes, they do the trucks
4. **Mobile / on-site repair** — available, but SECONDARY (not the headline)
- NOT offered: units for sale, parts sales. Don't build those clusters.

## Keyword research
See `KEYWORD-RESEARCH.md`. Headline: near-zero-volume, low-competition niche. FL volumes are single/
low-double digits across the board; `trash compactor repair` (1000 US) is a home-appliance DIY TRAP —
ignore. `commercial compactor repair` is the high-$ term (CPC $11–$40). Repair + truck SERPs are small
specialty shops/welders with no national authority — attainable now. `containerservicesunlimited` ranks
for BOTH containers and trucks, validating NFCTR's combined positioning.

## Site architecture (APPROVED 2026-06-13)
Every page self-canonical; location spokes NEVER canonicalized to a pillar (internal links only).
Narrative leads with the in-shop drop-off model; mobile is the secondary "we can also come to you" angle.

```
/                              Home — "Florida Dumpster, Roll-Off Container & Truck Repair"
/dumpster-repair/              PILLAR A — in-shop dumpster & roll-off container repair + refurbishment
  /commercial-compactor-repair/   spoke — in-shop / drop-off commercial compactor repair
  /mobile-container-repair/       spoke — secondary on-site / we-come-to-you repair
/garbage-truck-repair/         PILLAR B — garbage / roll-off / refuse truck repair & refurbishment
/service-area/                 Central & North FL overview + map → location wheel
  /dumpster-repair-ocala/         (home base)
  /dumpster-repair-gainesville/
  /dumpster-repair-orlando/
  /dumpster-repair-jacksonville/
  /dumpster-repair-lakeland/      (+ Tampa, The Villages, Leesburg, Daytona later)
/gallery/                      Before/after refurb photos (containers + trucks) — ⚠️ real client photos only
/about/                        Shop story, drop-off-and-return model, mobile coverage, repair-vs-replace
/contact/                      Address, phone, hours, quote form (n8n later)
/reviews/                      From GBP once it exists — ⚠️ real reviews + permission
/blog/                         Supporting/informational, 1–2/mo
```
- Internal mesh: Home ↔ both pillars ↔ spokes ↔ location wheel; each location page links Pillar A + both spokes; Pillars A↔B cross-link (same customers).
- Build first (attainable-now): both pillars + compactor + mobile, Ocala/Gainesville/Orlando/Jax location pages, gallery, core pages.
- Later (aspirational): broader location wheel, a truck-repair location page (Orlando ranks for truck terms), blog cadence.

## Flags
- Domain is dumpster-led; trucks carried by the homepage + Pillar B. GBP primary category = dumpster/
  container repair (most volume); truck refurb listed as additional service. "& Truck Repair" name is accurate.
- ⚠️ Need real before/after photos (containers + trucks) and real reviews before those pages go live.

## Next
- [ ] Keith creates LocalWP site → record path/port → write wp-env.sh
- [ ] Build design tokens from FGS/Black-Rock, then pages (pillars → spokes → locations → core)
- [ ] GBP setup (day one — fastest early traffic for this niche)
