# CLAUDE.md — North Florida Container & Truck Repair (dumpster / container & truck repair)

**START HERE: read `PROJECT-STATUS.md`** — the live handoff. Shared Benchmark conventions
(WP+Kadence stack, truth-audit, wp_slash, eval-file, self-canonical, design system) auto-load from
the global `~/.claude/CLAUDE.md`.

> This is a FROM-SCRATCH build (not a migration). Research → architecture → build, in that order.
> No existing rankings to protect; no domain authority yet — keyword research drives the structure.

## Quick facts
- **Business:** North Florida Container & Truck Repair — in-shop repair & refurbishment of dumpsters, roll-off containers, commercial compactors, and garbage/roll-off (refuse) trucks; mobile on-site repair available as a secondary offering.
- **Primary model:** drop-off / in-shop. Cities & waste companies drop off roll-offs/dumpsters at the Ocala shop → repaired & refurbished → returned. Most of the business.
- **Location / service area:** Ocala, FL (4240 SE 95th St, 34480 · 352-307-2535) / Central & North Florida
- **Domain:** floridadumpsterrepair.com (registered & owned by Keith — exact-match, statewide)
- **Existing presence:** none — no prior site, no GBP, no social (true greenfield)
- **Local WP (LocalWP):** TBD — Keith creates the Local site, then wire `wp-env.sh`.
- **WP-CLI:** `& "C:\Users\keith\.hermes\git\bin\bash.exe" -c 'source ~/Desktop/north-fl-container-workspace/wp-env.sh && wp ...'`
- **DataForSEO:** `~/.dataforseo-auth` · research in `KEYWORD-RESEARCH.md`
- **Backup before any DB change:** `wp db export backup-<thing>-<date>.sql`

## Phase status
- [x] Keyword & market research (DataForSEO) → KEYWORD-RESEARCH.md
- [x] Site architecture mapped + approved by Keith (page/URL tree, location wheel, internal links)
- [ ] LocalWP site created + wp-env.sh wired
- [ ] Design tokens (reuse FGS/Black Rock patterns)
- [ ] Pages built (pillars → services → locations → core) · truth-audited copy
- [ ] SEO foundation (AIOSEO LocalBusiness schema, titles from research, sitemap, llms.txt, OG, canonicals)
- [ ] Blog launched + GBP cadence
- [x] Mission Control + repo sync wired

## Keith's working style
- Direct, technically precise, no hedging. Minimal scoped changes; show the plan before non-trivial copy.
- Flag canonical/SEO-cluster decisions. Don't fabricate facts/credentials/photos/reviews — ask. Don't deploy — Keith's call.
