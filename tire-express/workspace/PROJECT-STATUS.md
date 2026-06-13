# PROJECT-STATUS.md — Tire Express (working doc)

> Source of truth for the Tire Express update. Same workflow as JSC: direct WP-CLI access against the
> LocalWP copy, idempotent eval-file scripts in this folder, verify before/after, Keith approves copy
> changes. Read `C:\Users\keith\Downloads\CLAUDE.md` for the shared Benchmark conventions.

Last updated: 2026-06-10

## Where things live

- **Local WP site (LocalWP):** `C:\Users\keith\Local Sites\tire-express\app\public\` — domain `tire-express.local` (site id 1FkoTj42H; must be STARTED in Local for WP-CLI; mysql port 10005)
- **Imported from:** Pressidium dev backup `tireexpress-dev-onpressidium-com-20260608-...wpress` (Downloads, 2026-06-08)
- **WP-CLI env:** `source ~/Desktop/tire-express-workspace/wp-env.sh` in git-bash
- **Graphics:** `OneDrive\Documents\Graphics\Tire Express\` (logos, service photos, featured images — fresh AC Recharge + Brake Jobs images 2026-06-08)
- **Theme:** `ignition-divi-child` (DiviCoded "Ignition" auto-repair theme on Divi — NOT Kadence; this is an update job, not a migration). Kadence is installed but inactive.
- **DB backup before any change** (project convention): `wp db export backup-<thing>-<date>.sql`

## The job (2026-06-10, from Keith)

- Prior sessions (Opus 4.8 era, copy-paste workflow) were doing "basically the same thing as JSC" —
  service page updates. Keith has **updated PRICE INFO for the service pages** to apply (pending — he's
  providing it).
- Continue the JSC-style workflow: recon → audit → Keith provides prices → apply via scripts → verify.

## Status

- [x] Workspace + WP-CLI env created (2026-06-10)
- [x] Recon DONE 2026-06-10:
  - **Active theme: plain `kadence` 1.5.0** (no child theme yet — unlike JSC; Divi + ignition-divi-child are INACTIVE leftovers). Kadence Blocks/Pro + AIOSEO Pro + Local Business addon + Perfmatters + ShortPixel + WPForms + wp-reviews (Trustindex) active. Front page = page 7.
  - **Service pages (block content, ~26–39KB each):** 226001 car-air-conditioning-recharge, 226003 tire-balancing-and-rotation, 226004 brake-jobs-in-ocala, 226005 oil-change-in-ocala, 226006 new-tires-in-ocala, 226007 tune-ups-in-ocala. **Only oil-change shows prices today ($79.95 / $129.95).**
  - Suspect demo leftovers: 226008 fuel-level / 226009 air-filter / 226010 itemised-bill (near-identical ~39KB) + a pile of "Gallery Filter N Column"/"Blog Column N" demo pages from one-click-demo-import → cleanup candidate (audit before deleting).
  - ⚠️ Brake jobs page rendered without a detectable H1 — check H1s across service pages (possible Kadence title setting issue).
  - `recon-services.php` in this folder re-runs the service-page state check.
- [x] **SERVICE PAGES REBUILT (2026-06-10)** — the big find: AC / brakes / tune-up / balancing still held OLD DIVI content that rendered as BLANK pages on the active Kadence theme (Divi inactive). All 4 rebuilt in the `te-np` hand-coded template (same one as oil-change/new-tires): body HTML in `page-<slug>.html` + shared `te-np.css`, applied by `apply-te-pages.php` (edit file → rerun; sets Kadence page meta + AIOSEO title/desc too). Copy recovered from the old Divi JSON (`divi-copy-*.txt`), typos fixed, honest voice kept. DB backup first: `backup-pre-prices-20260610.sql`.
- [x] **Keith's prices applied:** brakes from **$350/axle** (pads & rotors; ⚠️ Keith's "$400 per side" still needs clarifying before staging push — only the $350 claim is published), A/C vacuum & recharge from **$139.95**, coolant flush **$89.95** (placed on tune-ups page per Keith). Titles follow the oil-change house style (price in title): "Brake Jobs in Ocala, FL | Pads & Rotors From $350 Per Axle" / "Car A/C Recharge in Ocala, FL | From $139.95" / "Tune Ups in Ocala, FL | Honest Diagnostics & $89.95 Coolant Flush" / "Tire Balancing & Rotation in Ocala, FL | Up to 37\" Tires". Verified: 1 H1 each, prices render, images OK, 9-page smoke test all 200.
- [x] **Demo filler purged (2026-06-10):** 20 pages TRASHED (recoverable 30 days) — sample-page, fuel-level, air-filter, itemised-bill, all Gallery/Blog layout demos, works, our-plan. KEPT `our-testimonial` (226144) — it's in a nav menu; ask Keith if intentional.
- [x] **2026-06-10 (later):** Testimonials page renamed ("Our Testimonial"/our-testimonial → "Testimonials"/testimonials, menu label fixed, `_wp_old_slug` set — ⚠️ WP old-slug redirect not firing for pages locally; add /our-testimonial/ → /testimonials/ to a redirect map before launch). Brake pricing CONFIRMED by Keith: $350/axle is the claim, "$400 per side" dropped.
- [x] **Photo batch placed:** Keith's 12 new real pics (OneDrive Graphics\Tire Express\New Tire Express pics) → resized 1600px WebP (`processed-pics/`), imported w/ alts (227911–227922, `import-new-pics.php`). Placed: crew-balancing shot → balancing page, coil replacement → tune-ups, F-250 w/ new tires → new-tires lifted slot (`swap-newtires-photo.php`). Unplaced (for future pages/rebuilds): air filter, battery, strut, engine rebuild, heads+intake, Ben at desk, Toyo tires, wheels close-up, tire-balancing-in-ocala.
- [x] **Render bug fixed:** new pages looked different from oil-change — a BOM in `te-np.css` (PowerShell UTF8 export) broke the @import → brand fonts didn't load. Stripped + apply script now guards against it. (Keith to confirm visually.)
- [x] new-tires placeholders: already filled in a prior session (stale comment) — hero store-front.jpg, lifted now F-250 pic.

## ⚠️ REAL PROJECT SCOPE (discovered 2026-06-10)

This is a **mid-flight Divi→Kadence migration**, not just an update. The LIVE site (tireexpressandservice.com) is still Divi/Ignition and fine. The local/dev copy has Kadence active with only the 6 service pages rebuilt (oil + tires in the prior sessions, the other 4 today). **Still Divi content = rendering BLANK locally: home (7), about-us (226138), contact-us (18), services (15), our-faqs (858), our-team (711), testimonials (226144), blogs (226141), our-gallery (533).** All need rebuilding before this copy can ever deploy. JSC ranking-protection rules apply (slugs/titles/copy preserved unless data says otherwise).

## 2026-06-10 (evening): FAQ bug, DataForSEO audit, battery + fleet pages, nav

- [x] **FAQ "2212" bug** (Keith's screenshot): wp_update_post strips backslashes → CSS `content:"\2212"` (minus sign) lost its escape. Fixed with `wp_slash()` in apply-te-pages.php — REMEMBER THIS for all content scripts on every site.
- [x] **DataForSEO Ocala/FL audit (full):** tire shop near me **165,000/mo** · mechanic near me 49,500 · auto repair near me 33,100 · **tire repair near me 27,100 (NO PAGE — top candidate)** · car ac repair near me **12,100** (vs ac recharge 590 — A/C page title broadened to "Car A/C Repair & Recharge…") · wheel alignment near me 6,600 (do they do alignments? ask) · tune up 1,300 · battery replacement 1,000 + car battery 720 · auto repair ocala fl 1,300 · tire shop ocala fl 880 · used tires ocala fl 480 (do they sell used? ask) · fleet repair 140 but $20–27 CPC (B2B sales page).
- [x] **Battery page built** (227931, /battery-replacement-in-ocala/, te-np template, battery pic) — title "Car & Truck Battery Replacement in Ocala, FL | Tested First". Angle: FL heat kills batteries ~3yrs, test-before-sell (battery vs alternator), full shop can fix what the test finds. ⚠️ avoided claiming "free" testing — confirm w/ Ben if testing is free + any price.
- [x] **Fleet accounts page built** (227932, /fleet-maintenance-in-ocala/, te-np, sun-kool fleet pic) — title "Fleet Maintenance & Repair in Ocala, FL | Fleet Accounts". ⚠️ copy claims to confirm w/ Ben: consolidated billing, scheduling promises, "no minimum vehicles". Keith owes a 2nd fleet pic (only "fleet accounts sun kool.jpg" found).
- [x] **Nav gotcha:** site header uses menu **'Primary' (91)** — `main_menu` (77) is an UNUSED Divi-era menu (first nav adds + the Testimonials label fix hit it before this was caught). Battery + Fleet now live in Primary under Services. ⚠️ Testimonials is NOT in the active Primary nav — add under About Us once that page is rebuilt (it's still Divi-blank).
- [x] Map pin screenshot imported (att 227934, `tire-express-map-pin.png`) — for the CONTACT PAGE REBUILD: JSC-style static map image linked to the GBP listing (zero JS).

## 2026-06-10 (night): 3 more pages, footer, final 2212 fix

- [x] new-tires page 2212 fixed (`fix-2212-newtires.php` — direct $wpdb update, no slash mangling). All pages now render +/− correctly.
- [x] **FOOTER DISCOVERY:** prior session's footer (in `widget_block` option, index 11) already links the full planned page set — used tires, lifted-truck/off-road tires, tire installation (buy online), wheel alignment, **CV axles**, accessibility — most 404'd. Slugs for new pages taken FROM the footer.
- [x] **3 pages built** (te-np, in Primary nav under Services + footer): `/used-tires-ocala/` 227941 ("used tires near me" **49,500/mo FL!** — inspected/mounted/balanced angle, stock-changes-daily, call-with-your-size), `/tire-repair-ocala/` 227942 (27,100/mo — patch-plug-done-right vs rope plugs, repairable-or-not honesty, slow leaks), `/wheel-alignment-ocala/` 227943 (12,100+6,600/mo — pulling/crooked-wheel/uneven-wear signs, pairs-with-new-tires, suspension checked). Keith confirmed: they sell used tires, do repairs/patches, and alignments.
- [x] Footer updated (`patch-footer.php`): + Tire Repair (after Used Tires), + Battery Replacement & Fleet Accounts (after A/C Recharge).
- [x] All verified: H1s, images, minus-escape, footer + nav links live.

## 2026-06-10 (late night): final 4 planned pages + confirmations applied

- [x] Keith confirmed: **free battery testing** (added to battery page hero/bar/FAQ + title now "| Free Testing"), fleet billing wording OK, used-tires out-the-door pricing OK.
- [x] **4 pages built — every footer link now resolves:** `/tire-installation-ocala/` 227950 (1,900/mo; buy-online-install, TPMS, "we sell tires too" honesty), `/lifted-truck-tires-ocala/` 227951 (niche/brand page; MT-vs-AT honest advice + **LIFT KIT INSTALLATION — confirmed by Keith**, in title/hero/FAQ), `/cv-axle-replacement-ocala/` 227952 ("cv axle replacement cost" 2,400/mo — cost-question angle, diagnose-first), `/accessibility/` 227953 (plain WCAG 2.1 AA statement; ⚠️ create-script ordering bug left it empty at first — `fix-a11y-h1.php` sets content; theme hides page titles globally so every page needs its own H1 in content).
- [x] Nav decision: the 3 new service pages are footer-only — Services dropdown already has 11 items; adding more hurts UX. Keith can re-curate the dropdown later if wanted.
- [x] **GRADIENT FINAL (Keith picked round 1 after testing 3 variants):** hero right side lightened — stops `.62→.38, .42→.18`, left side untouched. Locked into `te-np.css`, applied to all 11 te-np pages + oil-change/new-tires embedded CSS (`patch-old-page-gradients.php`). Use these values on the 9 page rebuilds too.
- [x] **Lifted page "bigger than 37s" messaging (Keith: "a lot of people want bigger"):** balancing maxes at 37" (kept accurate) but mounting/installing larger is welcomed — hero trust now "37\"+ Welcome", lede + FAQ "How big of a tire will you put on?" make it explicit.
- [ ] Lift kits: candidate for its own page later ("lift kit installation" volumes unchecked) + blog post material

## NEXT
- [x] **HOME PAGE REBUILT (2026-06-10)** — `page-home.html`, applied via apply-te-pages (id 7). Title "Tire Express | Tire Shop & Auto Repair in Ocala, FL" (both money queries). Visible text 1,231 (blank) → 10,147 chars. Sections: hero (50+ yrs/free brake checks/37"+ trust), Affirm financing + towing + 24/7 lot in Why-Us (all from recovered Divi copy), 15-link services grid, no-job-too-big dark section (semis! F-250 pic), 3 real client testimonials (incl. JSC Construction) + **[trustindex] Google reviews widget — shortcode renders inside wp:html**, 4-step process, 8-Q FAQ from the old page. DB backup first: `backup-pre-home-20260610.sql`.
- [x] **CONTACT PAGE REBUILT (2026-06-10)** — `page-contact-us.html` (id 18). Call/email-first (no form exists yet — **slot marked in the file; Keith to build a WPForms form → drop `[wpforms id=X]` in**). Static map (optimized webp att 227979, 105KB vs the old JS iframe embed) linked to the real Google listing — CID 14203459939532349517 extracted from Trustindex options (place 0x88e62d200c402acf:0xc51cd38fd551204d, pin 29.1866403,-82.1148337). Fleet band ("We love serving fleets" — from old copy), logistics FAQ (overnight/towing/quotes).
- [x] **38" + icon fixes (Keith):** balancer max is 38" not 37 — updated lifted/balancing/installation/home (hero trusts, FAQs, stats, copy); "mounted beyond 38" kept. Box-truck SVG next to "Lifted Trucks Welcome" on lifted page → mountain/off-road icon.
- [x] **ALL REMAINING PAGES REBUILT (2026-06-10 night) — ZERO Divi-blank content left on the site:**
  - about-us 226138 ("no corporate vibe" story verbatim, 6 value cards, Ben section w/ ben-at-desk pic)
  - our-team 711 (Ben w/ Ben-Bishop.webp, crew cards — only Ben named in old content, kept honest)
  - testimonials 226144 (4 quotes w/ recovered names: Meigan Sardinia/Black Sheep, Paul Facundas/semi driver, Heath Eng., JSC Construction + [trustindex] + leave-a-review CTA → Google listing)
  - our-faqs 858 (full old FAQ, typos fixed, split Shop/Scheduling vs Parts/Tires, interlinked to service pages)
  - services 15 (hub: tires group + maintenance group, all 15 links, prices shown where they exist)
  - our-gallery 533 (old content was DEMO LOREM — built fresh: 15 real photos grid, responsive, no JS)
  - blogs 226141 → **set as page_for_posts** (Kadence archive renders the 3 post cards; dead Divi cleared)
  - **3 blog posts RESTORED** (`restore-blog-posts.php`): heat/tires 227830 (excellent long piece), AC 227099, rotation 227048 — all were Divi-blank; articles recovered from the Divi JSON, cleaned (tailwind/editor classes stripped, in-content titles removed — theme renders H1 — links made relative), each verified 1 H1 + full text.
- [x] **2026-06-10 (final round):** Sticky header enabled — `header_sticky=top_main` + `header_reveal_scroll_up=true` theme mods (Kadence native; header w/ phone number reveals on scroll-up only, Keith's idea). Blog archive H1 enabled (`post_archive_title=true` → renders "Blogs"). Ben's team photo crop pinned top (`object-position:top`). **"Get Directions →" rolled out site-wide:** linked address + directions link in every page's NAP block (all 20 page files, PowerShell batch) + site footer (patch-footer.php) — all point at the GBP listing (CID link). Contact form SCRATCHED by Keith (no SEO value; call-first shop) — slot comment stays in page-contact-us.html if ever wanted.
- [x] **Photo batch 2 placed (2026-06-10):** pest-control fleet truck (front-of-shop banner shot) → fleet page lifted slot; lifted Jeep on MTs → lifted page; **Toyo pic + "we love Toyo / Open Country" line → lifted page (Keith: "they love toyos")**; rotated tire-stack pic → used-tires page; gallery now 20 images (added jeep, 2 pest trucks, flatbed, tire stack). All verified, 0 broken.
- [x] **DataForSEO live-site audit (the "why it doesn't rank" answer):** 84 ranked keywords, nearly ALL at positions 40–100. Money terms buried: "tire shops in ocala fl" (1,000/mo) #53, "ocala tire" (880) #42, "oil change ocala fl" (480) #50. A/C page has freak national rankings (recharge how-to terms up to 60,500/mo at #34–90 — informational, low value, but shows page equity). SERP "tire shop ocala fl": local pack = Florida Tires 4.2 / Mr Tire 3.8 / Affordable 4.9 (TE's 5.0×26 beats on quality, needs review VOLUME); organic = chains + local indies whose titles match our new pattern (Bob's Tire #8, Advanced #10, A1 #12). TE absent from top 30.
- **CONCLUSION: the dev rebuild fixes the root cause (Google was ranking blank Divi pages). The single biggest ranking lever now is DEPLOYING this build.** Post-deploy: GSC submit, review-velocity push w/ Ben (pack is winnable at 5.0), then the content wheel.

- [x] **Primary menu REBUILT deterministically** (`rebuild-nav.php` — first attempt with item-updates scrambled the tree; full delete+recreate is the reliable way, script is re-runnable): Services → **Tires flyout** (Used / Repair / Installation / Balancing & Rotation / Lifted & Off-Road) + Wheel Alignment / Oil / Brakes / Battery / Tune Ups / A/C / CV Axles / Fleet at level 2; **Testimonials added under About Us** (was missing from live nav). No more stranded pages — every service page is in nav AND footer. Toyo img on lifted page resized 680→380px (Keith).

## PRE-LAUNCH PREP (2026-06-10, late) — LOCAL SIDE DONE

- [x] **Schema completed:** mu-plugin `wp-content/mu-plugins/tire-express-custom.php` — Service schema on all 14 service pages (serviceType + areaServed Ocala/Marion towns, provider → AIOSEO org by @id, verified rendering) + the 301 redirect map (/our-testimonial/ → /testimonials/, verified). businessType **LocalBusiness → TireShop**. No FAQPage schema by design (Google restricted FAQ rich results to gov/health sites Aug 2023 — no SERP benefit; visible FAQs stay). No aggregateRating (guidelines).
- [x] **Privacy policy was the last Divi-blank page** (id 8, missed in the sweep list) — real policy (Oct 2025) recovered FROM THE LIVE SITE and restored, 1 H1, ~30K chars.
- [x] `verify-all.ps1` written (28 pages + redirects; PS 5.1 gotchas: needs BOM, no em dashes, @(,@()) for pair arrays): **ALL CHECKS PASSED**.
- [x] `PRE-LAUNCH-CHECKLIST.md` written — Keith's visual click-through is the next gate, then AI1WM → Pressidium staging.
- PHP note: Pressidium is NOT capped at 7.0 (Keith misread) — pick 8.2 there to match Local's 8.2.29; don't touch Local.

## NEXT
- [ ] Pre-launch checklist (adapt JSC's): final visual review by Keith → AI1WM export → Pressidium staging → search-replace verify (serialized URLs: EEAT n/a here, but widget_block footer + map links) → schema/AIOSEO audit → ShortPixel bulk → staging → live → GSC
- [ ] GBP work w/ Ben: review velocity, photos (use the new batch), services list, products
- [ ] Redirect map (incl. /our-testimonial/ → /testimonials/) — mu-plugin (no child theme on TE)
- [ ] Check review-stars implementation (bwd shortcode reconciliation TODO from JSC)
- [ ] Confirm w/ Ben: free battery testing? fleet billing wording? used-tire pricing approach OK?
- [ ] Eventually: same pre-launch checklist treatment as JSC (deploys to Pressidium)

## Context from JSC project (cross-references)

- JSC is PAUSED pre-export waiting on Alex's price info — see `Desktop\jsc-kadence-mockup\PROJECT-STATUS.md`
- Long-standing TODO from JSC: reconcile `bwd-review-shortcodes.php` (Google review stars) naming with the
  Tire Express implementation — check how TE renders review stars during recon.

## 2026-06-12 — share buttons on blog posts (JSC pattern)
- tire-express-custom.php mu-plugin: the_content filter (priority 0) appends Facebook / X (icon-only)
  / Email / Copy Link bar to single posts. No child theme -> styles ship inline in the bar (.te-share,
  TE blue hover #1248d7). PHP lint clean. Local copy + workspace copy (mu-plugins\) both updated.
- TE local site was NOT running (502) — visual check pending next time Local starts it.
- DEPLOY: mu-plugins are files, NOT pushable via REST. Keith uploads workspace copy to prod
  wp-content/mu-plugins/tire-express-custom.php via Pressidium SFTP/file manager (or give Claude
  SFTP creds — Windows has a built-in sftp client). Then purge Pressidium cache, check a post.

## 2026-06-12 (night) — share buttons LIVE on prod
- tire-express-custom.php pushed via SFTP (creds: ~\.pressidium-sftp.txt, user
  tireexpress-prod-claude, docroot behind tireexpress-www symlink). Verified live:
  te-share bar renders on the heat-warning post. KEITH: purge Pressidium cache so all
  cached posts pick it up.

## 2026-06-13 — blog flare + Ben Bishop author (FGS pattern), LIVE on prod
- All 3 posts enriched (enrich-te-posts.php, idempotent): TLDR answer box (te-blog-tldr) up top,
  scannable table (te-blog-table), mid-post CTA band (te-blog-cta, call/drive-in), FAQ section.
  Rotation post mileage claim aligned to 5,000-7,500 (was 3,000-8,000).
- Ben Bishop = author (make-ben-author.php): local user 9, PROD user 11 (created via REST).
  mu-plugin additions: hand-rolled author box (te-author-box, Ben-Bishop.webp pic), avatar filter
  (pre_get_avatar_data), author-archive noindex (aioseo_robots_meta). Styles all inline in mu-plugin.
- Deployed: mu-plugin via SFTP, content+author via REST. Verified live: all elements on all 3 posts.
- KEITH: purge Pressidium cache (TE + JSC) so cached pages pick up tonight's changes.

## 2026-06-13 — Perfmatters aligned to JSC (the 82->97 fix)
- Root cause of TE 82 vs JSC 97: NOT the theme (both Kadence). TE was loading 4 render-blocking
  Kadence stylesheets (~122KB) because RUCSS was OFF; JSC's RUCSS collapses them to ~0.
- Applied JSC's gold-standard perfmatters_options to TE PROD (verified persisted in DB via
  object-cache-busted read): remove_unused_css=1 + 9 Kadence protect-selectors, delay_js_exclusions
  [wpforms,jquery] (was EMPTY -> also fixes TE WPForms jQuery bug), delay inclusion [trustindex],
  lazy_loading=1 (store-front-hero desktop+mobile excluded), local fonts, critical_images=2,
  jquery-migrate removed, emoji/dashicon/embed/xmlrpc/heartbeat disables.
- Method: temp gated mu-plugin via SFTP (REST/SFTP can't reach perfmatters_options as data).
  Fought Pressidium opcache (validate_timestamps off -> fresh filename per edit) + object cache
  (wp_cache_delete to verify). Temp plugins deleted; opcache may serve the inert gated route until purge.
- KEITH TO DO: (1) Pressidium Clear Cache (page+object) — REQUIRED, object cache is masking the new
  config from real visitors right now. (2) Click through home/service/blog/mobile-menu/footer/contact
  form — RUCSS can strip a style; if anything looks unstyled tell me the selector. (3) PageSpeed x2-3
  (first run regenerates Used CSS). Expect a jump toward the 90s.

## 2026-06-13 — branded blog hero (matches Black Rock pattern)
- New mu-plugin tire-express-blog-hero.php (port of brm-blog-hero.php): gradient hero band on
  /blog/ + category archives via kadence_archive hook (priority 5), hides the default "Blogs"
  title band. TE colors: deep navy-blue gradient + blue glow, Space Grotesk, eyebrow #7fa8ff,
  orange #ff5a3c active chip. Eyebrow "The Tire Express Blog", H1 "Tire & Auto Advice for Ocala
  Drivers", category chips (hide_empty, Uncategorized excluded).
- Pushed to prod via SFTP; verified live (cache-buster) on /blog/ and /category/maintenance/.
  Only "Maintenance" chip shows for now (thin content) — fills in as posts get categorized.
- KEITH: purge Pressidium cache so all visitors see it (currently only cache-buster requests do).

## 2026-06-13 — Facebook share button mobile fix
- Same fix as JSC: wp_footer navigator.share handler in tire-express-custom.php (mu-plugin), FB
  link targeted by href. Pushed via SFTP, verified on prod. KEITH: purge cache, test on phone.
