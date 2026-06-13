# Black Rock Mortgage — Project Status
*Read this first each session. Same workflow as JSC/Tire Express (git-bash + wp-env.sh, script-driven, rerun-idempotent).*

## Site facts
- Staging: LocalWP `black-rock-mortgage` (id `3wNWCt9Ba`), http://black-rock-mortgage.local, MySQL port 10017 (root/root, db `local`), prefix `wp_`
- Live: https://www.blackrockmortgage.com (Pressidium; dev copy at blackrckmtg.dev.onpressidium.com)
- Theme: Kadence + Kadence Pro/Blocks Pro. SEO: AIOSEO Pro. Forms: WPForms.
- Deliberately deactivated on staging: pixelyoursite (pixel pollution), wp-mail-smtp (real-email risk; Mailpit catches mail instead)
- DataForSEO auth: `dfs-auth.txt` (basic token), helper `dfs.ps1`, balance ~$50

## Status 2026-06-10 (end of session)
- Site restored manually from .wpress (AI1WM free paywalls restore — see memory note for gotchas)
- Full SEO audit complete → **SEO-AUDIT-AND-PLAN.md** (priorities P1-P5)
- Applied on staging: DSCR 301 redirect + 5 empty AIOSEO titles (quick-wins.php)
- **MAJOR FIND: 9 published URLs (2 pages, 7 posts) had Divi-era content that rendered EMPTY under Kadence — on live too.** Converted all 9 to clean HTML via divi-convert.php (originals in postmeta `_divi_original_content`). IDs: 830, 15780, 103, 623, 748, 792, 864, 15654, 17059
- /florida-usda-turn-times/ (623) rewritten + expanded (~900 words, FAQ, USDA cluster links) — expand-turn-times.php
- Homepage (38): pcard H3s + "Details" anchors now keyword-rich (backup postmeta `_brm_home_backup_20260610`) — homepage-anchors.php
- Internal links sitewide: 29 posts updated to skip 301 hops (22 pointed at old USDA slug) — fix-internal-links.php
- ⚠️ URGENT for Keith on LIVE: add 301 `/dscr-loans-florida-2/` → `/florida-dscr-loan/` (404s while ranking). The empty-content fix also can't wait long — push staging or run divi-convert on live.

## Session 2 (2026-06-11): backlinks + LLM + first articles
- Backlink audit done (trial APIs): 117 ref domains, only 4 quality; 56 competitor-link prospects → **BACKLINK-PLAYBOOK.md** (Keith executes Tier 1 next week)
- LLM citation audit: we + all FL broker competitors have 0 dataset mentions, BUT ChatGPT already cites us for "best mortgage brokers in Ocala" via GBP. Strategy in playbook. Re-test with pull-llm.ps1 (~$0.35)
- PUBLISHED on staging: `/cheapest-places-to-buy-a-house-in-florida/` (987515420), `/florida-first-time-home-buyer-grants/` (987515421) — ⚠️ price/program figures hedged "early 2026"; Keith should sanity-check before push
- robots.txt clean for AI bots, llms.txt live (AIOSEO) ✓

## Session 3 (2026-06-11): P3 complete
- **All 7 content-gap items done.** New posts: rent-to-own-homes-in-florida (987515422), requirements-to-buy-a-house-in-florida (987515423), florida-property-tax-exemptions (987515424) + earlier cheapest-places (987515420), fthb-grants (987515421)
- FHA requirements: did NOT write an article (Keith's /fha-home-mortgage-loan/ already covers it — avoided cannibalization). Instead: inserted "Requirements at a Glance" checklist section + requirements-focused AIOSEO title (backup `_brm_fha_backup_20260611`)
- FHA limits: covered by existing /loan-limits/ — ⚠️ Keith: both /loan-limits/ and the FHA page's limits table show **2025 figures**; drop in 2026 numbers when handy (I don't fabricate data)
- Note: DataForSEO main balance is paid (research budget OK); trial covers Backlinks + AI Optimization only, ~exp 06-24

## Session 4 (2026-06-11): local build-out + internal linking + calendar
- 3 city service-area pages: the-villages (987515425, VA/HECM angle), gainesville (987515426, FTHB/investor), belleview (987515427, USDA/mfg). All keyword-targeted, distinct angles, full internal links + FAQ.
- "Related Reading"/"Also Serving" cross-link blocks added to 6 money pages → new content (related-reading.php)
- Noindexed 2 thin/dead pages: /4743-se-35th-st.../ (listing), /covid-19-update.../ (noindex-thin.php)
- /ocala-mortgage-broker/ already has rich MortgageBroker+FAQ+Person schema — no schema work needed, just cross-links
- **EDITORIAL-CALENDAR.md created** — 90-day plan + recurring growth tasks (HARO, GBP posts, review velocity, monthly re-pulls)

## Session 5 (2026-06-11): lead forms on program pages
- Added VA-style `brm-prog-cta` lead form (iframe → /wp-content/uploads/forms/preapproval-form.html) to **16 loan program pages**. Script: add-lead-forms.php (idempotent, reversible via postmeta `_brm_formcta_backup_20260611`); police-officers via fix-police-form.php (classic-HTML page).
- Pages with form now: VA(template), USDA, FHA(replaced old iframe in-place), jumbo, condotel, bank-statement, fha-streamline, police-officers(Hometown Heroes), temp-buydown, DSCR, conventional, self-employed, non-QM, cash-out, refinance, HELOC.
- Per-program H2/lead copy; form inserted right before each page's final CTA heading = matches VA exactly (keeps existing CTA below). Provides the `#see-my-options` anchor the hero buttons target.
- EXCLUDED per Keith: reverse mortgage, ALL manufactured pages, new construction (florida-construction-loan) — these get their own custom forms with program-specific questions LATER. Also skipped tools (usda-eligibility, loan-finder, loan-limits) + loan-programs hub.
- Form template saved: va-form-block.txt / police-form-block.html (tokens {{H2}}/{{LEAD}}).

## ⏳ TODO NEXT: custom forms for excluded pages
Manufactured-home pages + new-construction page need their OWN lead form (different questions). When Keith provides the question set (or approves a draft), build a second form HTML file + embed the same brm-prog-cta way.

## Session 6 (2026-06-11): form rework + author-bio fix + menu
- Reworked brm-prog-cta form on all 16 pages (rework-form-blocks.php): DELETED redundant bottom CTA, added 104px space above gold portal button, added desktop phone button (.brm-prog-cta-call, hidden on mobile — sticky bar covers it). Backup postmeta `_brm_formcta_v2_backup_20260611`.
- ⚠️ GOTCHA fixed: police-officers is classic-HTML (Divi-converted) so the "last h2" anchor misfired — rework dropped 307 words of real body content. Restored from clean backup + appended form at END (fix-police-properly.php + police-form-v2.html). VERIFIED body+form intact.
- **AUTHOR BIO PHOTO FIX**: stale `/excelsior/wp-content/` path prefix (source server web-root leftover, not caught by domain search-replace) broke Keith's bio pic on 6 pages. fix-excelsior.php replaced →`/wp-content/` (file existed all along). The bio reusable block is post 987514146. Remaining 'excelsior' is just wpstg_staging_sites label (ignore).
- **MENU**: new city pages were NOT in nav (nor was /ocala-mortgage-broker/). Added "Areas We Serve" dropdown (items 987515428-432) after About: Ocala, The Villages, Gainesville, Belleview. add-locations-menu.php. Primary menu = "Main Page" (term 2), 50→55 items. Blog articles intentionally left in Blog, not nav.
- Mega-menu: NOT done — it's a Kadence Pro UI feature (per-item mega menu toggle), best configured in admin with Keith. Offered as next step.

## Session 7 (2026-06-11): QUALITY RESET — form polish + article rebuild standard
- Keith called the v1 articles "low effort / AI crap." Correct. Studied his real voice (FHA page 56: first-person, concrete FL numbers, real borrower scenarios, plain-spoken) + design system (stat row, Kadence accordion FAQ, teal #049F82 / gold #F5A524).
- Form CTA v3 (rework-form-v3.php): tighter 54px gap, real "Call Keith" button paired w/ gold portal (like homepage hero), homepage final-CTA gap 80→48px.
- **Built reusable article design system**: article-css.html (.brm-article: stat row, callouts, Keith's-take w/ photo, styled table, takeaway, mid-CTA, <details> FAQ accordion + FAQPage schema).
- **REBUILT flagship** /cheapest-places-to-buy-a-house-in-florida/ (987515420) to new bar — Keith's voice, 1768 words, all visual elements. Backup `_brm_article_v1_backup`. THIS IS THE STANDARD.
- ⏳ TODO: apply same standard to the other 7 (fthb-grants, rent-to-own, requirements-to-buy, property-tax + 3 city pages). Pending Keith's thumbs-up on the flagship design.

## Session 8 (2026-06-11): full content rebuild + CTA polish + form fix
- Keith APPROVED cheapest-places as the standard. Rebuilt all remaining to it (article-css.html design system):
  - Articles: fthb-grants, rent-to-own, requirements-to-buy, property-tax — voice, stat rows, tables, Keith's-take w/ photo, FAQ accordion + FAQPage schema, mid-CTA. Backups `_brm_article_v1_backup`.
  - City pages: the-villages, gainesville, belleview — rebuilt to Ocala-page quality (stat row, "Why X is different" w/ real local specifics, programs, Keith's take, FAQ+schema). Backups `_brm_citypage_v1_backup`.
- Homepage final CTA: matched program pages (side-by-side gold portal + outline Call Keith, was stacked). Backup `_brm_home_cta_backup`.
- "Ready for a Full Application?" label added above gold portal button on all 16 form pages + homepage (add-ready-label.php).
- FORM FIX: preapproval-form.html option title/subtitle were smushed (inline spans). Set `.opt .t`/`.opt .d` to display:block. File: app/public/wp-content/uploads/forms/preapproval-form.html (static, hard-refresh to see).
- get-pre-approved page (74): ALREADY has it — "How It Works" (2-min check→Keith reaches out→verified pre-approval) + "Two Ways to Start" w/ "Apply Now — Full Application" portal button. No work needed; Keith's memory was right.

## Session 9 (2026-06-11): hero fix + CTA refinements
- **City pages had NO H1** (Kadence title bar off, content had no H1) — added a proper brm-hero (eyebrow + H1 + subhead + Get Pre-Approved/Call Keith) to all 3. Now exactly 1 H1 each. add-city-heroes.php. Keith was right to push — they were abrupt.
- CTA label gap 52→80px (was too close to form border); homepage label color var(--accent)→explicit #5dcaa5 (match program pages). cta-polish.php.
- Form smushed text: only ONE form file (preapproval-form.html, already fixed display:block). Persisted due to BROWSER CACHE — added `?v=2` cache-bust to all iframe srcs so the fix loads. 18 pages.
- get-pre-approved (74): added standardized "Ready for a Full Application?" + gold portal + Call Keith CTA right below the soft form (light-bg version), so full-app option isn't buried in "Two Ways to Start" lower down. getpre-fullapp.php. Backup `_brm_getpre_backup`.
- NOTE: articles (posts) have H1 from post title — fine. Only PAGES needed the hero. If bumping the form again, increment ?v=.

## Session 10 (2026-06-11): site-wide hero unification
- Approved VA proof, rolled out the clean teal rounded brm-hero everywhere. Builder: hero-fn.php / rollout-heroes.php / tools-heroes.php / finish-heroes.php. Backups `_brm_hero_backup` per page. CTA auto-detected (form pages → "See My Options"/#see-my-options; others → "Get Pre-Approved"/get-pre-approved). H1 auto-extracted from old hero.
- **24 loan-program pages**: teal hero + INLINE author byline (from reusable block 987515105, folded into hero so it travels). 
- **12 tool pages + Ocala + About(70) + Our Team(548)**: teal hero, NO byline. Guard: only replace 1st rowlayout if it contains <h1> (protects calculator layouts).
- **police-officers (15780)**: classic HTML, hero PREPENDED (byline).
- **homepage (38)**: photo hero KEPT, changed full-bleed → contained+rounded (max-width 1280, margin auto, border-radius 18px). Backup `_brm_home_hero_round_backup`. ⚠️ KEITH EYEBALL — brand centerpiece, only photo hero.
- Skipped (no Kadence hero): mortgage-glossary, mortgage-faq. About/OurTeam old heroes had NO image (confirmed) so nothing lost.
- Also this session: homepage label forced green (#5dcaa5 !important); get-pre-approved buttons rounded (border-radius 0→6px); get-pre-approved full-app CTA below form.
- All heroes now: 1 H1 each (was 0 on city pages), brand teal/gold, byline on money pages = E-E-A-T. To revert any: restore `_brm_hero_backup` postmeta.

## Session 11 (2026-06-11): physician page + polish
- Homepage hero REVERTED to full-width (Keith changed his mind — keep full-bleed). Rounding removed.
- **NEW PAGE: /florida-physician-loan/ (987515436)** — dedicated medical professional loan. DataForSEO: "physician mortgage/home loan" 5,400/mo, "doctor loan" 1,300, very high CPC ($10-22); FL-specific low vol but easy. Full treatment: teal hero+byline, stat row, guidelines table, professions list, future-income (150-day contract), Keith's voice, FAQ+schema, lead form. AIOSEO title "Florida Physician Loans — 100% Financing, No PMI for Doctors". Product = Non-QM medical pro (investor: Eleven Mortgage; written as Black Rock's, NOT branded Eleven). Added to menu under Loans (item 987515437). Gainesville highlight callout → physician page.
- "Ready for a Full Application?" gap 80→110px (17 pages) — was touching form border.
- Glossary (318) + FAQ (31) heroes added (prepend; glossary old H1 demoted to H2 to avoid dup).
- Author-bio reusable block (987514146) photo → border-radius 16px (rounded for conformity). Could go circle if Keith wants.
- get-pre-approved: LEFT as-is (has own full-width custom hero + H1; Keith was unsure / "maybe" — not worth overhauling a working page). Buttons already rounded.

## Session 12 (2026-06-11): FAQ hero fix + get-pre-approved full redesign
- FAQ hero (31): constrained to 820px (matches brm-blog content width, no longer full-width) + removed redundant subhead (brm-blog .post-subtitle below covers it).
- **GET-PRE-APPROVED (74) FULLY REDESIGNED** in new system (was old brm-pa 100vw custom skin, "out of touch"). redesign-getpre.php. Backup `_brm_getpre_redesign_backup`. New: teal hero (CTA "Start the 2-Minute Check"→#pa-form), form in clean white card, "Ready for a Full Application?" actions, 3-step "How It Works" numbered cards, credit-check trust callout, Keith's personal note w/ rounded photo, stat row (16yr/$100M+/5★), 3 testimonial cards w/ stars, FAQ accordion (6 Q, preserved) + FAQPage schema, final CTA. All original messaging preserved. 100vw full-width gone.

## Session 13 (2026-06-11): custom social share buttons
- Built on-brand share buttons replacing AddToAny. **mu-plugin**: `app/public/wp-content/mu-plugins/brm-social-share.php` (auto-loads, survives AI1WM push). FB, X, LinkedIn, Email, Copy Link — dark teal (#0f2e2d) rounded icon buttons, hover #049F82, "copied" state gold, "Share this" Rubik label.
- Appends via the_content (priority 50) on: all posts + pages EXCEPT exclusion list (get-pre-approved, about-us, our-team, contact, keith-meredith, privacy/terms/accessibility, get-a-quote, front page). So shows on loan-program/tool/service pages + articles; not on conversion/utility pages. Verified.
- Assets gated to eligible pages only (don't load CSS/JS where buttons don't show).
- AddToAny (add-to-any) DEACTIVATED. Leftover `.addtoany_list` CSS is dead rules in Perfmatters used-CSS cache — harmless, clears when Perfmatters regenerates (or clear Perfmatters cache in admin). No actual AddToAny buttons render.

## Session 14 (2026-06-11): glyph fix + gold share buttons
- "Meet Your Broker" (homepage) showed literal "201C" — CSS `content:"201C"` lost its backslash (should be `"\201C"` = decorative " mark). Migration artifact. Fixed. Also homepage `2192` (→ arrow).
- **GOTCHA recorded**: `wp_insert_post()` runs wp_unslash and STRIPS single backslashes in CSS `content:"\XXXX"`. The physician page (created via wp_insert_post) lost its FAQ accordion minus sign `\2212` → rendered "2212". Pages updated via `wpdb->update` keep backslashes. **Fix going forward: after any wp_insert_post with CSS glyph content, re-check / re-escape, OR use wpdb->update.**
- Scanned ALL pages for `content:"[4hex]"` (no backslash) — fixed homepage(38) + physician(987515436); 0 remaining.
- Social share buttons → GOLD accents: gold icons (#F5A524) on dark #0f2e2d, hover flips to gold fill + dark icon. mu-plugin updated.

## Session 26 (2026-06-11): PDF + HBG + stock cleanup + FEATURED IMAGES
- **PDF imported** (att 987515464) → /wp-content/uploads/2026/06/florida-home-buyers-survival-guide.pdf. 17-page guide reviewed — excellent. NOTE: PDF lists Keith DIRECT line 352-615-1613 (site uses 352-619-4959 office).
- **HBG page (771)**: download button was linking /department-details/ (stock Kadence!) → now the PDF. Fixed 6 broken slugs (va-home-mortgage-loan ×4, dscr-loans, one-time-close-construction-loan). Added "Florida Survival Essentials" section from PDF (inspection lineup w/ prices, insurance boss-level, WIRE FRAUD warning, after-the-keys 5 steps) before FAQ. Backup _brm_hbg_backup.
- **Stock Kadence DELETED**: pages 14 (About Us-2), 15 (Contact Us), 28 (Projects), 44 (Department Details), 987513796 (Departments) + demo menus 68/71/74/77/16. Kept Keith's real drafts (Work With Us 18179, Credit Repair, agent resources, etc.).
- **FEATURED IMAGES: 11 attached** (resized 1200px webp 101-174KB, SEO filenames + alt): 5 articles + 3 city pages + DPA + reviews (att 987515474) + physician (att 987515475). STILL NEEDED: states-we-are-licensed only.
- ~~REVIEWS COMPLIANCE FLAG~~ RESOLVED: Keith regenerated w/ REAL clients (Bailee/Christine/Amy); fake-testimonial attachment deleted (was 987515474), real one att 987515476. States image attached (att 987515477). **ALL 12 FEATURED IMAGES DONE.**
- Note: states featured image colors derive from the c2c map (3-tier) — on-page interactive map (NMLS-based, 2-tier) is the authority; image is social-card only, minor mismatch acceptable (e.g. NY shows blue on image but NMLS shows no NY license).
- **WORK WITH US — IN MOTION**: Perplexity brief received (Downloads\blackrock_recruitment_copy_brief.md — STRONG: $995 flat fee/file, 1099-or-W2 choice, own DBA model, UWM Platinum + Detroit trips, correspondent panel Freedom/PennyMac/NewRez June 2026, commission-based processors). PLAN AGREED: comp calculator (conversion weapon), "this website is the proof" angle, 3-col table (Retail/Typical Broker/Here), confidential multi-step recruiting form (source="LO recruiting"), states map as territory, Keith story, objection FAQ+schema. **AWAITING KEITH'S ANSWERS** (12 questions asked 2026-06-11): (1) is $995 the ONLY fee (2) who pays processors+how much (3) publishable comp bps range (4) compliance OK on public $995 (5) recruits join Keith's division vs corporate — funnel to Keith (6) DBA minimums/cost/keep-existing-brand (7) W2 benefit specifics (8) experience bar / take new LOs? (9) can LOs originate all 40+ states + who pays sponsorship (10) LO testimonial (11) publishable scale numbers (12) 90-sec hero video. Build at /work-with-us/ (existing draft 18179; footer already links it).

## 🧠 BACKLOG — Keith brain-dump 2026-06-11 (don't lose these)
1. ~~Home Buyers Guide~~ DONE (Session 26).
2. **Menus too large** — reorganize / consider Kadence mega menu (Kadence Pro feature, admin-UI per-item toggle). Reduce size, better grouping.
3. **Footer square button** → round + make footer match the look/feel (Keith: "be creative").
4. **404s to fix/build**:
   - States licensed in page (Keith finding a MAP) — build page, slot for map.
   - Work With Us page (draft 18179) — MAJOR dynamic page, Keith compiling info. Big think-piece.
   - Client reviews page — **Claude to build now** (have testimonials + Google reviews widget).
5. Gold social buttons = approved/keep.

## Session 15 (2026-06-11): HBG hero, Reviews page, menu, maps recon
- Home Buyers Guide (771): blue Kadence hero → teal brm-hero.
- **Client Reviews page built → /reviews/ (987515438)**: teal hero, 5★/65+/16yr stats, 3 featured testimonial cards, `[trustindex no-registration=google]` widget, CTA. Added to menu under About.
- Menu: added Client Reviews + short descriptions to 16 loan-program items (mega-menu ready). Structure already 3-level = maps to mega columns. **Mega menu = Kadence Pro toggle (Appearance→Menus→item→Kadence Menu Settings→Enable Mega Menu). Keith likes coast2coast's (multi-col, icon+title+desc).** Prep done; visual toggle is Keith's UI step (or guide him).
- **MAPS (coast2coastmortgage.com/location)**: states-licensed map. 4 categories: green=close ALL loan types (correspondent), blue=correspondent for Conv/FHA/VA/USDA/DSCR/Commercial, teal=broker only, +not-licensed. JS-rendered so WebFetch can't read it; map screenshot not legible enough for legal accuracy. **NEED FROM KEITH: exact state list per category.** Then build custom interactive SVG US map (teal/gold) at /states-we-are-licensed/ — for borrowers + RECRUITING. Possibly a 2nd map (office locations) too.
- Footer "jiggle" Keith likes: CSS hover animation = ~0 perf cost (GPU compositor, no JS/load weight). Will add to footer links. Footer square button + creative footer restyle still pending (button is in Kadence footer widgets).
- STILL PENDING: states map (need lists), Work With Us page (Keith compiling, MAJOR dynamic page), footer button/restyle + jiggle, HBG PDF rebuild, mega-menu toggle.

## Session 16 (2026-06-11): states page + Kadence mega diagnosis
- **States page → /states-we-are-licensed/ (987515440)**, added to menu under About ("Where We Lend"). From NMLS 376205 paste. **40 states + DC + USVI.** Categorized by license type: 31 CORRESPONDENT (lender/banker/lending/company/financing license), 9 states+DC+USVI BROKER (broker-only license). ⚠️ Keith to VERIFY split vs his coast2coast map (which had a 3-way: green=all/correspondent, blue=correspondent-specific-loans, teal=broker). Recruiting callout → /work-with-us/ (forward ref, page not built yet). Equal Housing disclaimer + verify note included.
- **NOT a geographic map yet** — built as legend + categorized chip grids (accurate). A true geo map needs an SVG source or a stylized tile-grid; offered to build tile-grid next OR Keith provides map graphic.
- **KADENCE MEGA MENU DIAGNOSIS**: kadence-pro ACTIVE but `kadence_pro_active_modules` EMPTY → Pro add-on modules not enabled → that's why "Kadence Menu Settings" missing from Appearance→Menus. FIX: Appearance→Kadence→Add-Ons, enable modules + confirm Pro license active. WORKAROUND offered: custom CSS mega menu (no Kadence dependency). Keith tabling mega menu for now.
- Lender states: AL AK AZ CA CO FL GA ID IL IN IA KS KY LA MD MN MS MO NE NV NM NC OH OR SC TN TX UT VA WA WV. Broker: AR CT DC ME MI MT NJ OK PA WI USVI.

## Session 17 (2026-06-11): FULL CONTENT QUALITY REVIEW (Fable 5 pass) — plan executed
- **Quick-answer boxes + datelines** ("Last updated June 11, 2026 · Written by Keith Meredith NMLS #303217") on 5 articles + turn-times. Extraction-optimized for AI Overviews/Perplexity.
- **ACCURACY FIX (critical)**: Hometown Heroes reverted to occupation-restricted July 2025 (healthcare/K-12/first responders/military; veterans exempt from FTHB rule; funds exhausted till July). Corrected stale "any full-time FL worker" claims on grants article, Gainesville (incl. UF nuance: UF Health clinical YES, univ faculty generally NO), Belleview, rent-to-own, cheapest-places + FAQ schemas. Source of truth: HH page 15715.
- **Schema**: WPCode snippet @webpage "dup" = INTENTIONAL merge design (documented in snippet) — not a bug. Extended $loan_map 6→19 pages (physician, DSCR, non-QM, self-emp, bank-stmt, condotel, cash-out, refi, HELOC, reverse, construction, streamline, HH). **GOTCHA: WPCode executes from `wpcode_snippets` option cache — DB edits require delete_option('wpcode_snippets') + wpcode()->cache->cache_all_loaded_snippets().**
- **PAA mining** (DataForSEO, 10 topics, FL): added 14 PAA-derived FAQs w/ schema across 6 pages (incl. "$10k grant", "$25k grant myth", "where NOT to buy", income-needed math, 70-yr-old mortgage, senior tax age, physician-vs-FHA).
- **AIOSEO dup-row GOTCHA fixed**: wp_insert_post triggers AIOSEO to create an EMPTY aioseo_posts row; my manual inserts made dupes AIOSEO ignored → crafted titles weren't rendering on 11 new pages. Merged (kept low id, copied title/desc, deleted dupe). All titles now render. **Future: UPDATE the auto-created row, don't insert.**
- Verified: titles live, all new pages in sitemap (CDATA), FAQs 8/8 w/ valid matching schema.
- ⏳ PAA items needing Kadence-accordion edits (deferred): FHA page "downside of FHA", USDA page "what disqualifies", mfg hub "Dave Ramsey" Q.
- ⏳ AWAITING KEITH (questionnaire delivered): current turn times, 2026 limits, HH client examples, Villages bond ballparks, real client scenarios, top first-call questions, local market color, "what competitors get wrong" per program.

## Session 18 (2026-06-11): KEITH'S ANSWERS WOVEN IN (the E-E-A-T payload)
- **USDA turn times**: dated current-as-of line on 623 (June 11: processing June 2 apps = ~9 business days). UPDATE THIS PERIODICALLY — it's the freshness/citation magnet.
- **2026 LIMITS LIVE**: FHA page table+prose → 2026 tiers (floor $541,287; Jax $580,750; Manatee/Sarasota $547,400; Martin/StLucie/Okaloosa/Walton $603,750; SE FL $667,000; Collier $764,750; Monroe $990,150). Conforming: $832,750 all counties exc Monroe $990,150. **Built interactive 67-county lookup tool** on /loan-limits/ (brm-limits-tool, type-to-filter, FHA+conforming). Titles 2025→2026.
- **HH funding**: $50M approved May 29 budget, funds July 1 2026 — on HH page + grants article.
- **4 real-closing stories placed**: Dunnellon $230k doublewide $0-down USDA (~$1,500 OOP, engineer paid at closing + insurance angle) → mfg hub; $800k Villages HECM 60% down RI relo → villages page; $550k $0-down new-physician → physician page; HH 5%+3% seller concession combo → HH page.
- **4 "What other lenders get wrong" sections**: VA singlewide myth + no-engineer-report (singlewide pg); VA allows once-moved mfg (moved pg); conventional 5yr SE = 1yr returns (self-emp pg); non-warrantable condo flood-policy save + cookie-cutter/false-hope philosophy (condotel pg).
- ~~PENDING~~ ROUND 2 WOVEN (Session 18b): Villages bond claims SOFTENED (Keith doesn't advise payoff; mortgage side = count it right in DTI; schema updated). Mfg neighborhoods box on hub (Rainbow Lake Estates Dunnellon, Silver Springs Manor Ocala-Belleview $150-250k, Ocala Estates, Falls of Ocala). FHA-condition reality-check box on FHA pg (realtor steering unwarranted; working order = no exposed wires/leaks/holes/chipping lead paint; outdated OK; same for VA). Engineer-report expectations box on mfg hub (conventional USUALLY requires it; steps-only exception; porches/decks/awnings trigger; new setups fail surprisingly often). Requirements article: work-history nuance + 2 new FAQs w/ schema (new-job OK incl offer letter; Credit Karma now partially YES — VS4 accepted Apr 2026, BRM runs on conventional+VA per post 987515335). Rent-to-own credit para aligned w/ VS4. Builders box on construction pg: JSC Construction (jscfla.com) + Shamrock Construction (shamrockconstruction.com). STILL OPEN: Keith's #6 remaining first-call questions if more come.

## Session 19 (2026-06-11): footer + accordion FAQs + INTERACTIVE US MAP
- **Footer**: EHL badge rounded 4→8px w/ subtle gold tint (footer_html_content theme mod); mobile sticky CTA brand-aligned (#0d8585→#049F82, radius 6px); **jiggle hover** on footer links w/ gold color + prefers-reduced-motion respect; gold top accent line on #colophon. All via Customizer Additional CSS ("/* BRM footer polish */" block) per CLAUDE.md conventions.
- **3 native Kadence accordion panes added** (generic brm_add_pane builder: clones pane, bumps paneCount): FHA(56) "downside of FHA" (honest MI tradeoffs); USDA(42) "what disqualifies" (household income!, geography, occupancy); mfg hub(607) "Dave Ramsey mobile home" (chattel-vs-land-package reality + Dunnellon tie-in). Their FAQPage schemas use a different generator — visible only, schema patch deferred.
- **INTERACTIVE US MAP live on /states-we-are-licensed/**: inline SVG (@svg-maps/usa, MIT, us-states.svg in workspace), teal=close/gold=broker/gray=not-licensed, hover tooltips w/ status, USVI note. Page now 159KB content (fine, gzips well).
- REMAINING QUEUE: Work With Us page (Keith's info), featured images (Keith), mega-menu visual config (Keith UI, now enabled), HBG PDF rebuild (Keith to send PDF), push to live.

## Session 20 (2026-06-11): footer round 2 + map polish
- **5 broken footer links fixed** in widget_blocks 11-13: /licensing/→/states-we-are-licensed/, /refinance/→/refinance-mortgage/, /mortgage-glossary/→/mortgage-tools/mortgage-glossary/, /documents-needed/→/documents-needed-for-a-mortgage/, /florida-home-buyers-survival-guide/→/home-buyers-survival-guide/. NOTE: /work-with-us/ footer link still 404 BY DESIGN (page pending Keith's info).
- Green footer "Get Pre-Approved →" (.footer-cta in widget_block[14]): rounded 6px at source + belt-and-braces customizer rule.
- EHL badge: display:inline-block + margin 14px/10px + bigger padding (was scrunched against NMLS line/divider).
- Map: hover now brightness(1.25)+saturate+dark stroke (was subtle opacity — Keith saw "no change"); legend upgraded to bold Rubik chips w/ 18px color swatches.
- Footer widget edits = update_option('widget_block') — widget content lives there, NOT in posts.

## Session 21 (2026-06-11): MAP V3 — attribute-baked
- Keith reported tooltip said "we close your loan" on every state + no hover color. Delivered JS/CSS were verifiably correct → rebuilt anyway as **V3: colors + status baked INTO each path as inline attributes** (fill=, data-hover=, data-status=, + native <title> children). map-v3.php fully replaced old block. JS now reads data-status off the hovered path (no list matching to break); hover swaps the fill attribute itself. Zero-JS fallback: states still colored + native browser tooltips.
- Verified: FL teal inline, NJ gold inline, HI gray, 41/41 licensed-state titles, old block removed.
- Brand map colors (if ever needed externally): teal #049F82, gold #F5A524, gray #dfe8e5, ink #0f2e2d, hover variants #06c9a4/#ffc14d/#c4d6d1.

## Session 22 (2026-06-11): custom forms + pre-launch checklist
- **PRE-LAUNCH-CHECKLIST.md created** — work through before push. TOP GOTCHA: reactivate PixelYourSite + WP-Mail-SMTP after import; test-fire a lead to FUB.
- **2 custom multi-step forms built** (build-custom-forms.ps1 clones preapproval-form.html, same CSS/machinery/n8n webhook/honeypot/Arrive button): manufactured-form.html (buy/refi → land → type → year → moved → credit → timeline → contact; source="Manufactured home form") + construction-form.html (land → plans → builder[generic, not pinned to JSC/Shamrock] → budget → program → break-ground → contact; source="Construction loan form"). n8n receives new field names per source — Keith may want to map them in the workflow.
- Embedded via brm-prog-cta on /florida-mobile-home-financing/ + /florida-construction-loan/ (were form-less; backup _brm_customform_backup). Both forms 200, iframes wired.
- **ENCODING FIX (Session 22b)**: v1 forms had mojibake (PS 5.1 read base file as ANSI → emoji/dashes corrupted, one rendered as a biology-looking glyph). Rebuilt via build-custom-forms2.ps1: explicit UTF-8 read/write + ALL non-ASCII as HTML entities (&#127968; etc). Iframes bumped ?v=2. Verified zero mojibake in served files. **GOTCHA for the log: PS 5.1 Get-Content -Raw on BOM-less UTF-8 = ANSI mojibake — always use [IO.File]::ReadAllText($p, [Text.Encoding]::UTF8).**

## Session 22c: mfg tail cleanup
- Mfg hub (607) had TWO CTAs (old "No-Hassle" + new custom form). Removed old CTA; reordered tail: content → Dunnellon story → Neighborhoods → Engineer box → Related Reading → custom form. Backup `_brm_tailclean_backup`.

## Session 23 (2026-06-11): forms everywhere + mega menu rescue
- **manufactured-form embedded on 4 mfg subpages** (singlewide, moved, refi-mfg, usda-mfg) w/ page-specific H2/leads; old "No-Hassle" CTAs auto-removed where present (backups _brm_customform_backup).
- **va-construction-form.html built** (derived from construction form, UTF-8 safe): NO program step (known VA), budget tiers Under$400k/$400-700k/$700k-$1M/**$1M+ VA jumbo**, payload sends program:'VA', source="VA construction form". Embedded on /florida-construction-loan/va-new-construction-loan/.
- **n8n note: va-construction-form adds yet another source value + same construction field names.**
- **Mega menu: FULL CSS TAKEOVER** (mega-css-rebuild.php). v1 polish failed silently — targeted `#main-menu` but Kadence's nav is **`#primary-menu`** (54 selectors fixed). Kadence's own mega rendering wasn't producing columns either (single skinny dropdown w/ flyouts) → built CSS-driven mega: li position:static, panel absolute under #masthead full-width, display:grid 4 cols, 2nd-level = column headers, 3rd-level inline (flyouts killed), gold top accent, hover pills, 51 emoji icons, ≥1025px only (mobile drawer untouched). Verified via headless Edge screenshot (force-open temp CSS, since removed). **Headless screenshot recipe**: msedge --headless=new --no-sandbox --user-data-dir=fresh --screenshot=FULL_PATH (TEMP, not Desktop) --virtual-time-budget=9000; don't kill mid-render.

## Session 24 (2026-06-11): dropdown treatment + launch-stagger decision
- Standard (non-mega) dropdowns: same rounded-card treatment (14px radius, shadow, gold inset accent, hover pills) — verified via headless shot (Areas We Serve). Mega refinements: hover bridge (::before fills gap so panel doesn't flicker shut), align-items:start, label wrap.
- Mega/mobile: desktop-only ≥1025px BY DESIGN; mobile keeps Kadence drawer (icons appear there, fine).
- Keith generating featured images via ChatGPT (saw property-tax one — on-brand, excellent).
- **CONTENT LAUNCH STRATEGY (advised)**: publish-all-at-once is FINE for the migration launch — Google treats site revamps normally, no spam signal from 8 quality pages w/ real dates. BUT staggering has real benefits: steady crawl invitations, GBP/social material weekly, fresh-content cadence. RECOMMENDED HYBRID: launch WITH the 3 city pages + physician + states + reviews (site pages, not "posts"); keep the 5 articles' current publish dates OR set 2/wk schedule — Keith's call. If staggering: WP native scheduled publish (set future dates pre-push; they auto-publish on live via WP cron).

## Session 25 (2026-06-11): mega menu finalized + article stagger
- Articles staggered (status:future, 2/wk 9AM): Jun 15 cheapest, Jun 18 grants, Jun 22 rent-to-own, Jun 25 requirements, Jun 29 prop-tax. Auto-publish wherever site lives; noted in PRE-LAUNCH-CHECKLIST.
- Mega → **3 columns**, then grid→**CSS columns** (columns:3 + break-inside:avoid) fixing the stranded-whitespace alignment Keith screenshotted; **icon specificity bug fixed** (base ::before rule outranked per-ID content — per-ID now .sub-menu-prefixed). Standard dropdowns: rounded card + gold inset + hover pills. Hover bridge added. Verified via headless shots. Mobile untouched by design.
- Keith generating featured images (ChatGPT) — property-tax one approved-quality.

## Session 27 (2026-06-11): Month-1 articles + tail fixes + statewide menu
- Double CTAs removed: usda-mfg ("Want to Buy a Manufactured Home...?"), va-construction ("Ready to Build..."), construction pg ("No Hassle Construction"). FAQ pre-form sections on other pages correctly kept.
- Areas We Serve: parent now → /states-we-are-licensed/, "All of Florida" (🌴, "Statewide — every Florida county") leads dropdown before the 4 cities.
- **2 NEW ARTICLES (full quality bar, ALL CHECKS PASS)**, continuing the 2/wk stagger:
  - Jul 2: /how-much-house-can-i-afford-in-florida/ (987515480, 1916w) — two-ratio math, income-by-price 2026 table ($150k-$500k), FL traps (tax reset/insurance/student loans), napkin formula, PDF money-math woven in, "approved ≠ spend" Keith take.
  - Jul 6: /fha-vs-usda-vs-va-vs-conventional-florida/ (987515481, 2006w) — 4-program 2026 table, crossover rules (VA-first, USDA-second, 680 FHA/conv rule), 4 personas, links comparison tool + all program pages.
  - **NEED FEATURED IMAGES** for both (add to Keith's ChatGPT queue).
- Full stagger now: Jun 15 cheapest / Jun 18 grants / Jun 22 rent-to-own / Jun 25 requirements / Jun 29 prop-tax / Jul 2 affordability / Jul 6 comparison.

## Session 27b: post-hero duplicate CTA sweep
- Keith screenshot (USDA pg): hero buttons + identical "Get Pre-Approved in 24 Hours / Call Keith" bar right below = double CTA. Pattern = original pages' hero-adjacent buttons that survived the hero swap. **Removed on 28 pages** (remove-posthero-buttons.php: only wp:buttons w/ get-pre-approved|tel links between hero-end and first h2; intro paragraphs/spacers/stats kept; backups _brm_postherocta_backup). Calculator tool pages correctly skipped (no buttons block). Verified rendered: 0 dup bars, 1 h1 on sampled pages.

## Session 28 (2026-06-12): About/Keith/Contact conformity + spam-proof contact form
- **contact-form.html built** (uploads/forms/): single-card form, brm styling, topic chips (buying/refi/client/partner/other), name/phone-optional/email/message, honeypot + 3s timing bot checks, n8n webhook (source="Contact form", fields topic+message), height sync, success panel. Replaces the bare Kadence form (= the spam faucet; zero bot defense).
- **Contact (987513017)**: black hero → teal brm-hero ("Send a Message" gold CTA → #send-message anchor); old form section (rowlayout 45e17c-fa) fully excised (NOTE: Kadence rowlayouts NEST — use balanced scan, strrpos-nearest-opener hit an inner wrapper first; also substr_count('brm-contact-wrap') counts CSS class+div = 2 per embed, count id="send-message" instead). Backup _brm_conform_backup.
- **Keith Meredith (164)**: black hero → teal brm-hero (eyebrow "Division President · NMLS #303217 · Ocala FL"); fixed leaked \$ escape (single-quoted PHP doesn't process \$ — don't escape $ there).
- **About (70)**: black Meet-Keith section (kb-row-layout-id70_461967-d8) → branded dark-teal rounded card via Customizer CSS + forced readable text colors (h2 white, p #cfe0de, links gold). Verified by screenshot.
- **n8n note: contact form adds source="Contact form" + topic + message fields.**
- GMB review link for /reviews/: Keith mentioned but LINK NOT YET PROVIDED — get it (g.page/r/... format) and add a "Leave us a review" CTA on reviews page.

## Session 29 (2026-06-12): WORK WITH US BUILT & PUBLISHED 🎯
- **Keith answered all 12 questions.** Facts locked: $995/file flat (1099 = only fee); W-2 = +10% share after $995 (funds benefits: CoAdvantage medical, MetLife dental 4-tier + vision, Empower 401k w/ Roth); $250 tech fee ONLY if 0 closings in 3mo; processing = own 3rd-party OR their network; comp commonly 2.75%, correspondent = no YSP disclosure, borrower-paid option; brand paths = own DBA (~2wk, "division of" line) / team "powered by C2C" 50/50 logo / join Black Rock; **LO owns brand + client list even if leaving**; co-broker any C2C state at 50/50 compliance split = nationwide; 343 LOs, $1B+/yr; self-gen lead model (leads purchasable), self-motivated emphasis, new LOs OK w/ Keith direct training; support = in-house UW experts, instant tech support, owner access (Keith Richardson), design/social resources; stack = Arrive POS (broker-paid — included SOFTLY on page as "your stack... full sheet in the conversation") + Leaf 360 CRM; testimonials Robert Swanson + Andy Gaab (verbatim quotes on page); Keith direct line 352-615-1613 on recruiting materials.
- **recruiting-form.html built** — 6-step confidential (role→volume→states→branding→timeline→contact), OWN webhook: `/webhook/brm-recruiting` (⚠️ KEITH MUST CREATE this n8n Catch Hook — fields: name/first/last/phone/email/role/volume/states/branding/timeline/message/source="LO recruiting"/page).
- **/work-with-us/ PUBLISHED (18179)**: hero "Stop Building Someone Else's Pipeline" + confidential badge; 4 stats; pain/3-cards; **interactive comp calculator** (closings × size × current-bps vs 2.75%−$995, W-2 toggle ×0.90, annual delta in gold); honest cost sheet (incl. W-2 10% + $250 inactivity — transparency as differentiator); 3-col table Retail/TypicalBroker/Here; 3 branding paths + own-your-brand callout + "this website is the proof"; support cards + Keith real-talk box (self-motivated, "how I started"); 2 testimonials; 6-FAQ; dark CTA w/ form. Backup _brm_wwu_backup. Share buttons excluded.
- **STILL INCOMING from Keith**: payroll-fee detail, benefits cost detail (PDFs in Downloads\recruitng info 2_files), C2C logo, other DBA logos (social proof wall — YES do it), Arrive + Leaf 360 logos, testimonial PICS (yes, want), 90-sec hero video, featured image for page.
- TODO when assets land: logo wall section, testimonial photos, video in hero, FAQPage schema for recruiting FAQ (held off pending final copy), ~~GMB review link~~ DONE: g.page/r/CeKWc2LdGGbuEBM/review wired into /reviews/ as gold five-stars CTA card after hero (brm-gmb-cta).

## Session 29b: WWU enrichment + blog taxonomy
- **WWU enriched (6/6)**: 40+ states stat now GOLD + linked to /states-we-are-licensed/ (map NOT embedded — bolder number won, Keith agreed direction); testimonial avatars (robert-swanson.webp, andy-gaab.webp); **DBA logo wall** (Black Rock + Printz + Hello My Mortgage + Cardenas + Empower Home + Nature Coast — static grid, NO slider by design); platform strip (C2C + ARIVE + Leaf 360); **Best of Florida 2025 award band** (blue gradient, badge image) before FAQ. Assets in /uploads/wwu/. BRM logo = /uploads/2026/05/cropped-Black-Rock-Mortgage-Logo-correct.webp.
- **Blog categorized** (19 posts, one cat each): Buying a Home (7: cheapest/rent-to-own/requirements/prop-tax/affordability/housing-prices/wait-for-rates), Loan Programs & Guidelines (3, renamed from Mortgage Guidelines), First-Time Buyer Help (2: grants/MCC, new), Manufactured Homes (1, casing fixed), Mortgage News (3: fico/fha-mip/covid), USDA Rural Development (2), Florida Homes For Sale (1 noindexed listing). Deleted 7 demo/empty cats (Departments, Housing, 100% USDA, Mortgage Rates, FHA Financing, Housing Prices, Mortgage Advice). Future posts' counts appear after publish.

## Session 29c: WWU polish round 2 (Keith feedback)
- FAQ "2212" numbers = stripped-backslash glyph (wp_update_post in initial build) → repaired via $wpdb->update (**rule: page edits ALWAYS via $wpdb->update, never wp_update_post, when content has CSS glyphs**).
- Broken onerror attr on BRM wall card (backslash-strip mangled quotes, spilled text) → removed.
- **Emoji icons → inline Lucide SVGs** (teal/gold stroke, no plugin): dollar/tag/briefcase/shield-check/zap/crown/mountain/phone + 3 new. Answer to "better icons?": inline SVG, free, done.
- **Stack strip rebuilt** (was stacking vertically — theme img CSS beat inline height; fix: class block w/ !important): kick heading "The Stack Behind You", 5 logos (C2C/ARIVE/Leaf360/+OSI Express/+More Than Ink), copy: "Still suffering through Encompass or Calyx? ARIVE is a first-class, intuitive LOS — like skipping a decade."
- **C2C prominence test**: hero sub names Coast 2 Coast; new white band under hero w/ wide C2C logo: "You'd be sponsored by Coast 2 Coast Mortgage Lending — NMLS #376205 · 343 LOs · $1B+ · Best of Florida 2025. Black Rock is one of its divisions; yours could be next." (Keith evaluating how it sells.)
- **WEEKLY PAY gold standout band** after calculator: "You get paid every week." + W-2 pre-tax expense reimbursement (meals/credit reports/travel/cell) + benefits chips.
- Support grid now 6 cards (+first-class onboarding [#1 industry pain point], +searchable lender database w/ AE contacts & products, +LOAs per-file). Cost sheet: +LOA row, W-2 row now incl weekly pay + reimbursements.

## Session 29d: WWU conversion layer + clients-win + brand card
- Weekly band toned down (cream card, gold left border). 4th branding card "Operate as Coast 2 Coast" (w/ logo, 2x2 grid). "You earn more. Your clients pay less." section (Keith's $10,662 HMDA image, flywheel pitch, objection-first copy) after weekly band.
- **2 mid CTAs** → #talk ("Numbers make sense?" after cost sheet; "Picturing your name on the door?" before support). FAQ stays BEFORE form (objection-killer placement — confirmed to Keith).
- **Call-Keith box under form**: pic + "Rather just talk it out? Call/text direct cell 352-615-1613... two originators talking about joining the Coast 2 Coast family." img id=wwuKeithPic — SWAP when Keith provides friendlier/casual photo (current = formal bio shot).
- Featured image attached (att 987515485, "Great People. Stronger Together." ChatGPT image).
- Video talking points delivered to Keith (see response log).

## Session 29e: UWM Platinum + program menu
- **UWM PLATINUM section** (dark band after comparison table): UWM logo on white chip + gold "Platinum Status" pill; 6 perk cards: free 1% 1-yr buydowns, appraisal credits + refi incentives (everyday no promo), **no doc stamps on UWM→UWM FL refis**, VantageScore + FREE credit reports, Detroit trainings on UWM's dime, Platinum-tier service/concierge. UWM logo also in stack strip. UWM added to correspondent FAQ answer.
- **"Everything you can originate here" menu** (3 cols, check-bullets): Agency/gov (conv, FHA+203k, VA+IRRRL+jumbo, USDA, jumbo, DPA/HH, MCC) | Non-QM (bank stmt, P&L/1099-only, DSCR+STR, asset depletion, ITIN/foreign national, recent credit event, physician, IO/40yr, condotel) | Construction/equity/commercial (OTC construction, HomeStyle/ChoiceReno, manufactured+singlewides, HELOC/HELOAN/seconds, reverse HECM+jumbo, fix-flip/bridge, **SBA 7a/504, commercial multifamily/mixed/hotels**, land/lot). Closer: "Every no your bank made you give is a commission you didn't earn." **KEITH TO PRUNE anything C2C doesn't actually offer.**

## Session 29f: MCC DEFUNCT (Keith) + menu rework + UWM strip removal
- **FACT: Florida MCC program is DISCONTINUED.** Actions: discontinued banners (gold callout → HH/DPA alternatives) on MCC page 830 + MCC post 864 (kept for SEO, NOT deleted — captures "florida MCC" searches, redirects to live programs); **grants article (pub Jun 18) had MCC-as-available in 3 spots — section rewritten as "Still seeing the MCC advertised? It's gone." competitor-correction (E-E-A-T play), Keith's-take stack now FHA+HH+seller concessions, FAQ same**; MCC removed from WWU menu; closing-costs match was false positive (brmCcInit).
- WWU program menu REFORMATTED: 3 uneven cards → 6 balanced groups (Agency/Gov, Self-Emp & Non-QM, Specialty Property & Borrower, Construction & Reno, Equity & Reverse, Investor & Commercial) in CSS columns w/ break-inside:avoid — no ragged card bottoms. UWM logo removed from stack strip (Keith pref; stays in Platinum section). UWM promo card reframed: 1% buydown = example of rotating promos; doc-stamps keeps "every day, no promotion required."

## Session 30 (2026-06-12): SPEC CONSTRUCTION PAGE + non-QM backlog
- Form tweaks: branding option merged ("Coast 2 Coast branding — straight or team-name powered-by"), NMLS # REQUIRED field (placeholder allows "applying"), payload +nmls, iframe v=2. Hard money group added to menu (network/bring-your-own). Investor&Commercial moved under Agency+Gov w/ hotels + apartment buildings. Leaf 360 copy: automated SMS/email/lead nurture/post-closing follow-up.
- **NEW PAGE: /spec-construction-loans/ (987515486)** — builders/investors, from Keith's BFI Construction Loan Matrix PDF + builderfinance.com FAQ mining. DFS: targets cluster "spec home financing" (210) + "construction loans for builders" (170) + "spec construction loans" (70), all MED comp, weak SERP (BFI/credit-union blogs/Reddit). Content: 0% pay rate hero angle ($0/mo PAA answer!), simplified experience-tier LTC table (70→90%, 100% w/ land sub), terms table, honest qualifications (LLC-only, 2+ sold floor, 3k pop/3mi), **lifecycle broker angle (spec loan + DSCR/bridge exit + buyer mortgages = nobody else has)**, 6 PAA-driven FAQs + schema. Menu: child of New Construction (item 987515487, 🏗 icon). NOT in loan finder (consumer quiz — too niche, deliberate).
- **NON-QM BACKLOG logged in EDITORIAL-CALENDAR** (DFS-validated): ITIN (880/LOW!), asset depletion (590/LOW), foreign national (590/LOW), non-warrantable condo (390), bank-stmt HELOC (verify product first), fix-and-flip FL, mortgage-after-foreclosure. Co-work hunting unique lender products in parallel.
- Disclaimers on spec page: business-purpose only, terms per Jan 2026 matrix, subject to change.

## Session 31 (2026-06-12): LENDER NICHE CONTENT PLAN
- Co-work's 224-lender master list analyzed × DFS data → **CONTENT-PLAN-LENDER-NICHES.md** (workspace). Tier 1: 7 new program pages (ITIN 880/LOW, foreign national, asset depletion, non-warrantable condo, inv-property HELOC, after-foreclosure, fix&flip). Tier 2 sleepers: **HORSE FARM FINANCING (Farmer Mac, Ocala = horse capital!)**, chattel MH, Airbnb DSCR, CDFI no-doc, Geo-Corp EEP rent-to-own section (add to existing article ASAP), church loans. Tier 3: 8 enrichments of existing pages (VA 500-FICO/no-cap, FHA 550 manual, jumbo reverse $4M, physician 12-mo SE, DSCR no-ratio/STR, jumbo pledged-asset, 1-month bank stmt, KVOE).
- **Anti-mill rules documented in plan** (cadence cap 2/wk, primary-source requirement, no city doorways, full interlinking, Keith gate, prefer enrichment). Schedule continues 2/wk cadence Jul 6–Aug 17 (~9 pages + 8 enrichments).
- WWU anchor-scroll fix (hash polluting URL on refresh — replaceState now), Work With Us added to About menu (🤝).
- Lender-list hygiene flagged: 6 defunct lenders to remove, several Verify rows; UWM 0%-down DPA + Bilt = possible WWU adds if Keith verifies.

## Session 31b: mobile form fix + wild-stuff band
- **MOBILE FORM BUG**: recruiting iframe blank on mobile = `loading="lazy"` on an iframe ~17,000px deep (mobile browsers defer aggressively). FIX: eager + bg:#fff + v=3. **RULE: never lazy-load the conversion form.** Form itself verified rendering in iframe at 390px (minimal test page). Also added overflow guards (min-width:0, overflow-x:hidden) to recruiting-form.html. KEITH TO CONFIRM on his phone post-hard-refresh; next suspect if still broken = Perfmatters iframe lazyload on live.
- **Menu upgrade (anti-overload approach)**: 7 groups kept tight, 5 lines sharpened w/ master-list ammo (1-month bank stmts, 1-day-out-of-BK, 100% purchase+rehab flips, chattel, negative-cash-flow DSCR) + new dark **"Deals you didn't know had a lender"** chip band (13 chips: horse farms, church \$35M, CDFI no-doc owner-occ, cannabis income, crypto-backed, \$30M pledged-asset jumbo, sweep mortgage, container/tiny, EEP rent-to-own, funeral homes/daycares, foreclosure bailout/DIP, faith-based, Puerto Rico) + closer "200+ deep... you can originate it."

## Session 31c: PERFMATTERS = the real mobile-form culprit + empire-builder section
- **ROOT CAUSE of all mobile form failures: Perfmatters iframe lazyload** (active on staging all along) — rewrote every form iframe to class=perfmatters-lazy + data-src; its restore JS failed/late on mobile. FIX: lazyload.lazy_loading_exclusions (ARRAY key, not 'lazyload_exclusions') += uploads/forms/, brmPreapproval, brmRecruit, brmContact. Verified real src on homepage/VA/contact/mfg/WWU. Setting lives in DB = travels with push (pre-fixes live's same bug). RULE: conversion forms excluded from every optimizer BY NAME; re-export perfmatters baseline json to include this.
- **WWU empire-builders section** (before support): branch managers design own comp plan (feed leads/charge higher per-file/1.5% structure/50-50 profit) + recruiter override ($200/file recruits close, for as long as they're with company). Honesty note upgraded to Keith's voice ("we've been on both sides — that's why we invested in our own company"). HELOC comp row = placeholder (Keith getting details — UPDATE when they land).
## Session 31d: mobile saga part 2 — absolute .local iframe srcs
- Homepage form STILL blank on Keith's phone after Perfmatters fix. Cause #2: 26 pages had ABSOLUTE iframe srcs (http://black-rock-mortgage.local/...) — phone can't resolve .local, so iframes died on LAN/LiveLink while relative-src pages worked. fix-absolute-iframe-src.php → all /wp-content/uploads/forms/ srcs now relative. RULE: iframe/file srcs in content are ALWAYS relative (phone testing + push safety).
- Callback bars (pulsing dot, same-business-day promise) on 27 consumer form locations (home/24 prog/contact/GPA); recruiting form deliberately skipped (has confidential strip). Mobile drawer gold 'Apply Now — Full Application' menu item (987515491) → my1003app portal; hidden on desktop nav.

## 🔴 OPEN LOOPS (carry forward every session)
- **⚠️ N8N FIELD MAPPING (Keith, before/at launch):** the two new forms send NEW field names the n8n workflow doesn't map yet — manufactured-form: `land, hometype, year, moved` (+purpose/credit/timeline) source="Manufactured home form"; construction-form: `land, plans, builder, budget, program, ground` source="Construction loan form". Update the n8n workflow (benchmarkwebd.app.n8n.cloud, brm-preapproval webhook) so these flow into Follow Up Boss/Telegram notes. Until then: name/phone/email/source still arrive fine.
- **FEATURED IMAGES**: all 8 new posts/pages + rebuilt usda-turn-times need featured images. Keith generates in ChatGPT, will batch-add. REMIND each session until done.
- 2025→2026 figures: /loan-limits/ + FHA page limits table (need Keith's real numbers)
- Keith on LIVE: DSCR 301 redirect; empty-Divi-content fix; verify $ figures in new articles
- Push staging→live via AI1WM (pixelyoursite/wp-mail-smtp stay OFF on staging only)

## Next up (in priority order)
1. Featured images (Keith) — see open loops
2. Month-1 editorial calendar items (affordability, FL rates, loan-program comparison, Lady Lake/Spring Hill cities)
3. Keith: Tier 1 backlinks (BACKLINK-PLAYBOOK.md)
4. FAQ schema audit on USDA/program pages; quality pass on remaining thin converted posts (log cabin 288w, housing-prices 49w)

## Conventions
- All DB work via `wp eval-file` (wp db query broken on Windows)
- For wp-cli args with spaces: call the phar via php directly, not `wp` (wp.bat mangles them)
- Scripts in this folder are rerun-idempotent; DataForSEO pulls cached in seo-data\
