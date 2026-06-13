# Tire Express — Pre-Launch Checklist (local → Pressidium → live)

> Deploy is Keith's call. Work top to bottom; local passing ≠ staging passing — re-verify after every hop.
> Live site: tireexpressandservice.com (still old Divi build). Local: tire-express.local (full Kadence rebuild, 2026-06-10).

## Before export (local)

- [x] **Keith full visual click-through** ✅ APPROVED 2026-06-10
- [x] verify-all.ps1: ALL CHECKS PASSED (28 pages: 200, one H1, self-canonical, meta desc, images; 301 /our-testimonial/)
- [x] Service schema (mu-plugin `tire-express-custom.php`) on all 14 service pages; LocalBusiness = **TireShop**; NAP/hours/areaServed configured; no aggregateRating anywhere
- [ ] Keith's call: PHP version — confirm what Pressidium actually offers (it's NOT 7.0; pick 8.2 to match Local's 8.2.29). Do NOT downgrade Local.
- [x] Theme cleanup (2026-06-10): Divi + ignition-divi-child + twentytwentythree/four DELETED (kadence active, twentytwentyfive kept as fallback); et-cache removed; smoke test passed. Backup: `backup-post-cleanup-20260610.sql`
- [x] Final local backup: `backup-final-pre-export-20260610.sql`. Local state at export: WP core 7.0, PHP 8.2.29, home http://tire-express.local
- [ ] Second fleet pic whenever it surfaces (nice-to-have, not blocking)

## Migrate to staging/dev (Pressidium)

- [ ] All-in-One WP Migration export (local) → import on Pressidium dev/staging
- [ ] Search-replace `tire-express.local` → staging domain; verify `wp option get home`
- [ ] **Verify option-stored URLs survived:** footer widget links + Get Directions (widget_block), AIOSEO local business image, theme mods
- [ ] Re-activate licenses: AIOSEO Pro, Kadence Blocks Pro, Kadence Pro, Perfmatters, ShortPixel, WPForms
- [ ] ShortPixel bulk-optimize the new images
- [ ] Confirm mu-plugin survived the migration (AI1WM includes mu-plugins — verify /our-testimonial/ 301s + Service schema renders)

## Verify on staging — https://tireexpress.dev.onpressidium.com (imported 2026-06-10)

- [x] verify-all.ps1 -BASE staging: **ALL CHECKS PASSED** (28 pages, canonicals rewrote correctly, 301 works = mu-plugin survived)
- [x] Deep checks: Service schema renders + provider @id rewrote to staging domain; TireShop on home; Trustindex widget rendering; footer Get Directions + new service links survived (widget_block); contact map + GBP CID link intact
- [x] Staging protected from indexing: Pressidium sends `X-Robots-Tag: noindex, nofollow` server-side on dev (env-level — won't carry to production)
- [x] Licenses carried in DB: Kadence + AIOSEO show valid (Keith) — verify UPDATES work on each (per-domain activations can show green but fail update checks)
- [ ] Rich Results Test (staging is publicly fetchable): home → TireShop w/ hours; a service page → Service node
- [ ] PageSpeed Insights: home, new-tires, brake-jobs (mobile + desktop)
- [ ] Keith real-phone pass on staging: sticky header reveal, click-to-call, Tires flyout in mobile drawer, hero gradients (iOS Safari)
- [ ] AIOSEO sitemap on staging: demo pages absent; 14 service pages + info pages + 3 posts present

## 🚀 LAUNCHED 2026-06-11

Pressidium's staging→live deploy produced a FRANKENSTEIN (new content tables + OLD theme files/options — Divi header/footer wrapping new pages). Fix: **AI1WM full restore directly into production** (Keith's Unlimited license) — replaces DB + wp-content wholesale. Permalinks re-saved, licenses re-validated, Pressidium cache cleared, **verify-all.ps1 vs www.tireexpressandservice.com: ALL CHECKS PASSED** + deep checks (kadence active, no Divi, NO noindex, TireShop + Service schema w/ live-domain @ids, 301, sitemap 200). Cache primed by the sweep → speed tests now representative.
- [ ] Footer FB link on production (staging-only edit didn't carry — Keith re-adding via widget)
- [ ] GSC: submit sitemap.xml + request indexing (home, new-tires, used-tires, tire-repair, brake-jobs, 3 posts)
- [ ] Lesson for JSC deploy: skip Pressidium's deploy tool — AI1WM straight into the target environment.

## LAUNCH STATUS (2026-06-10 night — historical)

- Staging→live deploy ATTEMPTED via Pressidium — their automated post-deploy checks flagged it and AUTO-ROLLED-BACK production to the old site (no downtime; old site serving). During the live window, cache-busted checks confirmed the new build was serving correctly — **the build is fine**; the flag is almost certainly their URL/content-diff heuristic reacting to the intentional redesign (~20 removed demo URLs, new theme, 301).
- PHP is 8.2 + WP 7.0 on BOTH environments (Keith confirmed — earlier "PHP 7.0" was the WP version).
- ⚠️ ALSO: first live sweep initially showed the OLD site due to **Pressidium server cache** (41-hour-old cache HIT) — after any successful deploy, CLEAR PRESSIDIUM CACHE FIRST, then sweep.
- Facebook link added post-staging-import: footer (staging ✓ by Keith, local ✓ via add-facebook.php) + sameAs already in schema both sides.
- WAITING: Pressidium support reply re: which check failed → ask them to re-run deploy and let it proceed (intentional redesign).
- When live for real: re-run `verify-all.ps1 -BASE https://www.tireexpressandservice.com` + deep checks; THEN GSC sitemap + indexing requests.

## Launch (→ live)

- [ ] Lowest-risk window (shop hours are Mon–Fri 8–5; deploy evening)
- [ ] Push staging → live (Pressidium) or AI1WM to live
- [ ] Search-replace → `https://www.tireexpressandservice.com`; verify `wp option get home`
- [ ] Clear Pressidium cache; spot-check 5 pages + the 301 immediately
- [ ] **Old live URLs check:** the trashed demo pages (gallery-filter-*, blog-column-*, fuel-level, air-filter, itemised-bill, works, our-plan, sample-page) will 404 — fine. /our-testimonial/ 301s. Watch GSC for unexpected 404s with impressions.
- [ ] Google Search Console: submit sitemap; request indexing for home + new-tires + used-tires + tire-repair + brake-jobs + the 3 posts

## Post-launch (first weeks)

- [ ] **GBP with Ben (the local-pack prize):** review velocity push (5.0×26 beats the pack's 4.2/3.8/4.9 on quality — need volume), upload the new photo batch, fill services list, confirm hours match (Mon–Fri 8–5)
- [ ] Watch GSC: the 84 buried keywords (tire shops in ocala #53, ocala tire #42, oil change ocala #50) should climb as Google recrawls real content
- [ ] Content wheel: tire-repair + used-tires support posts; "lift kit install" page candidate; AC informational post already capturing how-to queries
- [ ] Set up the REST application password for the post-launch content workflow (same as JSC)
