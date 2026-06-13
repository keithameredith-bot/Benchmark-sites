# Black Rock Mortgage — SEO Audit & Action Plan
*Data pulled 2026-06-10 via DataForSEO (cost: ~$0.36 of $50.58 balance). Raw JSON in `seo-data\`.*

## Where the site stands (US, Google organic)

- 999 tracked keywords; only **1 in top 3** and **3 in positions 4-10**. ~30 sit at 11-20, everything else is 21+.
- Estimated traffic value: ~$1,731/mo — almost all of it from the homepage.
- **641 of 999 keywords rank via the homepage** — the #1 structural problem. Generic "florida mortgage" terms (2,400/mo) rank 46-51 on the homepage instead of dedicated pages, and even "manufactured home loans florida" ranks via `/` (pos 11 in FL SERP) while `/florida-mobile-home-financing/` exists and is excellent.

### Florida-localized SERP baseline (checked live, 2026-06-10)
| Keyword | Pos | URL ranking |
|---|---|---|
| manufactured home loans florida | **11** | `/` (should be the mfg hub) |
| usda loan florida | **20** | `/florida-usda-mortgage/` |
| mobile home financing florida | **28** | `/` |
| fha loan florida | >30 | — |
| va loan florida | >30 | — |
| dscr loan florida | >30 | — |
| florida construction loan | >30 | — |
| florida first time home buyer programs | >30 | — |
| florida hometown heroes program | >30 | — |
| mortgage broker ocala fl | >30 | — |
| mortgage lender near me (Ocala) | >30 | — |

### Strengths to build on
- **USDA cluster** is the site's beachhead: "rural development loan florida" pos 7, "usda lenders florida" pos 15, "usda turn times" cluster pos 16-20 (1,600+2×390 vol) on a 741-word blog post.
- Strong, recently rebuilt page architecture with good AIOSEO titles on most money pages.
- Manufactured-home niche: huge national volume (14,800-vol cluster) where the site already registers pos 27-84.

## Fixes applied on staging (2026-06-10)
1. ✅ **301 added: `/dscr-loans-florida-2/` → `/florida-dscr-loan/`** — this URL ranks for "dscr loan florida" (1,300/mo) and **404s on live**. ⚠️ MUST be replicated on live ASAP (AIOSEO → Redirects), don't wait for the staging push.
2. ✅ Empty AIOSEO titles/descriptions filled on 5 ranking posts: florida-usda-turn-times, new-usda-income-limits, do-mortgage-lenders-use-fico-or-vantagescore, housing-prices-in-florida, saving-deals-with-the-mcc.

## Priority actions (not yet done)

### P1 — Fix homepage cannibalization (biggest lever)
The homepage outranks dedicated pages because internal links/anchors don't concentrate topical signals. For each money topic: descriptive internal anchors from homepage + related pages to the dedicated page ("Florida manufactured home financing" → mfg hub, not "Learn more"). Consider trimming deep program detail from the homepage so it stops competing.

### P2 — Striking-distance pushes (existing pages, weeks not months)
- `/florida-usda-turn-times/`: expand 741w → 1,500w+ (what affects turn times, current week table, FL office specifics, FAQ schema). Already pos 16-18 for 2,000+ combined vol.
- `/florida-usda-mortgage/`: pos 20 for "usda loan florida" (1,900) — content is there; needs internal links from every USDA-adjacent page + blog posts, FAQ schema, and the legacy redirect equity is already flowing.
- `/florida-mobile-home-financing/`: capture the pos-11 homepage ranking — anchor-rich links from homepage, posts, and the 4 subpages up to the hub.

### P3 — Content gaps (modeled on makefloridayourhome.com `/learn/` hub; 309 qualifying gap keywords found)
Create as blog/learn articles, each internally linked to the matching program page:
1. **"Cheapest places to buy a house in Florida"** — one article covers a ~50k combined-vol cluster (8,100×5 + 4,400×6 + 2,900×5 + …), KD 5-20. Their single page ranks top-10 for ~30 variants.
2. **"Florida first-time home buyer grants & programs"** — 8,100×2 + long tail; links to Hometown Heroes, MCC, DPA, conventional-FTHB pages.
3. **"FHA loan requirements in Florida"** — 1,900×4 cluster currently lost (we rank 61-70); separate from the FHA program page, like their eligibility article.
4. **"Florida FHA loan limits"** — 590×4 cluster; we already have `/loan-limits/` — either optimize it for FHA-limit phrasing or split an FHA-specific limits page.
5. **"Rent-to-own homes in Florida"** — 720-1,000×8 city variants, they rank 1-11; ours: nothing.
6. **"Requirements to buy a house in Florida"** — 1,300×2 + condo variants.
7. **"Florida property tax exemptions (incl. seniors)"** — 590-4,400 cluster; great E-E-A-T fit with closing-costs calculator.

### P4 — Local (Ocala)
- `/ocala-mortgage-broker/` not in top 30 for "mortgage broker ocala fl"; winners are thin sites (ocalamortgageloans.com pos 5) — beatable. Needs: LocalBusiness/MortgageBroker schema verification, GBP link parity, Ocala-specific content (testimonials, areas served), internal links from homepage footer/nav.
- Build out service-area pages: The Villages, Gainesville, Belleview, Dunnellon, Marion County (template off `/new-houses-in-ocala-florida/`).
- Off-site (Keith): GBP categories/posts, NAP-consistent citations, review velocity.

### P5 — Hygiene
- `/4743-se-35th-st-ocala-fl-34480/` — 81-word listing page: noindex or delete.
- Several pages still use default `#post_title` AIOSEO templates (jumbo, get-pre-approved, DPA, MCC, police-officers, VA construction, HECM guide) — craft proper titles during their content pass.

## Competitor watchlist (FL SERPs)
makefloridayourhome.com (content model to copy), thedocegroup.com, flamortgagefirm.com, capitalhomemortgage.com + 21stmortgage/triadfs/cascadeloans (mfg-home), ocalamortgageloans.com + floridahomeloans.org (local).

## Data files (`seo-data\`)
ranked-keywords.json (999 kws), domain-overview.json, competitors.json, relevant-pages.json, serps-fl-all.json (12 live FL/Ocala SERPs), competitor-mfyh.json (their FL kws), keyword-ideas-fl.json (mostly off-topic, ignore), site-inventory.json (73 pages/posts + AIOSEO meta).
