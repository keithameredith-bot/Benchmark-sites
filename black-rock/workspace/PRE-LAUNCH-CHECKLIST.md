# Black Rock Mortgage — Staging → Live Pre-Launch Checklist
*Created 2026-06-11. Work through in order. The push carries EVERYTHING from staging, including things deliberately turned off.*

## ⚠️ THE TWO BIG GOTCHAS
1. **PixelYourSite + WP Mail SMTP are DEACTIVATED on staging** (on purpose — pixel pollution & email safety). The push will carry that deactivated state to live, killing your Facebook pixel and SMTP email. **IMMEDIATELY after import: Plugins → activate both.**
2. **The mobile-bar / forms / map were edited under the .local domain.** All-in-One WP Migration rewrites URLs automatically on import — verify (spot-check the pre-approval form iframe loads on live, the map renders, menus work).

## Scheduled content (set 2026-06-11)
The 5 new articles are SCHEDULED (status: future), 2/week at 9 AM:
- Jun 15: Cheapest Places · Jun 18: FTHB Grants · Jun 22: Rent-to-Own · Jun 25: Requirements · Jun 29: Property Tax
They auto-publish wherever the site lives (staging or live) when each date hits — push timing doesn't matter. After launch, verify the next pending one shows "Scheduled" in Posts. Each publish day = share it as a GBP post + social.
Note: a few internal links point at not-yet-published articles until their date — brief and harmless.

## Before export (on staging)
- [ ] Keith final review pass: the 8 new posts/pages, physician page, reviews page, states map page, get-pre-approved redesign
- [ ] Verify $ figures one last time (program amounts, 2026 limits — already entered from your data)
- [ ] Featured images set on new posts/pages (or accept launching without; can add after)
- [ ] Mega menu configured in Kadence (or accept current dropdowns; can do after)
- [ ] Optional: switch any articles you're not ready to publish → Draft

## Export / Import
- [ ] All-in-One WP Migration → Export on staging (file will be ~1.5GB)
- [ ] **Back up live first**: AI1WM export of LIVE (or Pressidium backup point) — this is the rollback
- [ ] Import on live (needs Unlimited extension on live for >restore, or Pressidium staging-push path)
- [ ] Log back in with staging credentials (DB now from staging)

## Immediately after import (on live, in order)
- [ ] **Activate PixelYourSite + WP Mail SMTP** ← do not skip
- [ ] Settings → Permalinks → Save (flush rewrites)
- [ ] Clear Pressidium server cache (dashboard) — the usual "changes don't show" culprit
- [ ] Clear Perfmatters cache/used-CSS
- [ ] Spot-check: homepage, /florida-usda-mortgage/, /florida-physician-loan/, /states-we-are-licensed/ (map hover), /get-pre-approved/ (form loads + submits to n8n/FUB!), /reviews/, one article
- [ ] **Submit a TEST lead through the form** → confirm it hits Follow Up Boss + Telegram (n8n webhook still pointed correctly)
- [ ] Check robots.txt + sitemap.xml render; AIOSEO → regenerate sitemap if needed
- [ ] Verify the DSCR redirect now works on live: /dscr-loans-florida-2/ → 301
- [ ] Verify old USDA slug 301s: /0-down-usda-rural-development-mortgage/

## Within 24-48h after launch
- [ ] Google Search Console: submit sitemap, request indexing on the 9 new/rebuilt money URLs (physician, states, reviews, 5 articles, turn-times)
- [ ] Watch GSC coverage for the formerly-empty Divi pages (they now have content — expect recrawl gains)
- [ ] Confirm GBP website link & UTM still right
- [ ] Re-run rank pulls (ranked-keywords baseline exists in seo-data\) — this is Day 0 for measuring the climb
- [ ] Start BACKLINK-PLAYBOOK Tier 1 (lendersa, old-domain 301s, floridahousing.org listings, BBB, chamber, realtor partners)

## Known leftovers that are FINE to launch with
- /work-with-us/ footer link 404s (page in progress — or unlink until ready)
- Glossary/FAQ pages have no loan schema (not loan pages)
- Featured images missing if you skip that step (cosmetic, fix after)
