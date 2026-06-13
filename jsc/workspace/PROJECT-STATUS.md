# PROJECT-STATUS.md — JSC Contracting (jscfla.com) Divi → Kadence Migration

> **Read this first.** This is the live handoff for the JSC migration. It was started in a Hermes
> session and is being handed to Claude Code in the terminal to conserve API credits. Everything
> decided so far is below. Read the root `CLAUDE.md` (Benchmark conventions) too.

Last updated: 2026-06-10

> 🚀🚀 **LIVE AT jscfla.com — LAUNCHED 2026-06-12.** AI1WM direct restore → permalinks → licenses → cache →
> verify-live.sh **ALL CHECKS PASSED** + deep checks (org @id resolves on live domain, Service providers OK,
> EEAT author bio + alex-400 + our-team link survived search-replace, no noindex, delay-JS/RUCSS/preloads
> active, share bars live, sitemap 200). REST app password saved+tested: `C:\Users\keith\.jsc-rest-auth.txt`.
> **LAUNCH NIGHT TODO (Keith): GSC — submit sitemap.xml, request indexing: barndo page FIRST, then container,
> dock, used/new pages + all 5 posts. Then watch barndo rankings daily ×2 weeks.**
> Drafts on live: post 101393 = the recovered 2-paragraph FRAGMENT of the lost dock-builder-near-me article
> (its URL 301s to the dock page; fragment kept as raw material) + 3 stale draft pages (old privacy 8,
> pole-barn-gallery 101113, marine-gallery 100964 dupes — safe to delete anytime). NO pre-written content-plan
> drafts — the wheel topics live in CONTENT ROADMAP below; with REST creds the flow is: Claude drafts →
> pushes as DRAFT → Keith reviews/publishes.

## PERFORMANCE PRE-PASS (2026-06-12) — playbook applied BEFORE export (the TE lesson)

- Montage hero optimized in place 366→201KB (same filename, no content changes) + 50KB mobile variant;
  barndo hero already light (75KB) + 22KB mobile variant. Page-scoped mobile-hero overrides in child
  style.css (page-id selectors + !important beats inline bg; montage 8 pages + barndo).
- Perfmatters baseline merged locally (`apply-perfmatters-baseline.php`) → ships with the export:
  delay-all JS (**wpforms EXCLUDED — quote form verified interactive**), defer, RUCSS w/ Kadence
  exclusions, local fonts+swap, lazy w/ DOM monitoring, housekeeping. Preloads: montage desktop+mobile
  device-split, sitewide (Perfmatters `locations` field rejected our syntax — barndo pair dropped, its
  hero is light). local_ga OFF (MonsterInsights owns GA).
- Note: RUCSS first-hit per page is slow/can abort (generation) — after import on Pressidium, click
  through major pages once to warm it before judging anything.
- Final sweep ALL CHECKS PASSED post-changes; schema/stars/FAQ verified intact; final backup
  `backup-final-pre-launch-20260612.sql`.

## DOCK PRICING CONTENT (2026-06-11) — DONE, from Alex's answers

- **NEW: dock cost post** `/blog/dock-cost-central-florida-2026/` (102199, author Alex, cat Docks, featured 102073, FAQPage JSON-LD inline, `create-dock-cost-post.php`). Real numbers: **$40–60/sq ft** (flat, walkable, accessible); by waterway: Rainbow $35–45k (short walkways) · Lake Weir $75–85k w/ boathouse (~200ft docks, sand = fast pilings; Kerr similar) · Lake George $150–175k (shallow → ~800ft walkways; links the Lake George post) · Crystal River ~$200k (70ft boats, 28–38k lb lifts, rock/clay = slow piling work). No minimum job; 50% deposit + staged draws; **lifetime labor warranty** + 3-yr lift manufacturer warranty.
- **Dock page** (100394): FAQ cost answer now real numbers + links the post; NEW warranty FAQ. jsc-schema.php FAQ map mirrored (6 Qs).
- **Boat lift page** (101740): + warranty section (3-yr manufacturer + lifetime labor) + "How big a boat can you lift?" (28–38k lb class, 70ft boats at Crystal River).
- Home blog grid auto-shows the new post. verify-all.sh updated (4 posts now): **ALL CHECKS PASSED**.
- ⚠️ Alex left unanswered (extrapolated qualitatively, NO invented numbers): decking material price diffs, piling type costs, boathouse/roof add-on %, lift cost by capacity, add-on prices, permit costs. If Keith gets these later → enrich the post.
- **Content wheel ready to roll from this data:** lake-specific posts (Lake Weir dock costs, Crystal River boathouses, Rainbow River docks) — each links the cost post + dock page.

## BLOG ENRICHMENT PASS (2026-06-11) — ALL 5 POSTS DONE

- Dock cost post: comparison table, 3 inline real photos w/ captions, +3 sections (wood vs composite / permits & timeline / repair vs replace), 7th FAQ (visible + JSON-LD), Lake George post links it (`enrich-dock-cost-post.php`).
- Barndo cost: **new featured image 102075 (Alachua build, Keith's pick)** + build-level table ($/sqft × 2,000 sqft examples from its own numbers).
- Fence post: 4-material comparison table (its own $/lf figures) + four-board horse-fence photo.
- Seawall checklist: "7 signs at a glance" recap table (sign / meaning / urgency).
- Lake George: "at a glance" table (2nd-largest lake, ~800ft docks, $150–175k → links cost guide) + 2 inline dock photos.
- All via `enrich-remaining-posts.php` + `fix-lg-photo.php` (lesson: idempotency guards must check a UNIQUE string, not a generic prefix). Every post now: 1 table + 3-4 real photos + FAQ LD. verify-all: ALL CHECKS PASSED.

---

## Where things live

- **Local WP site (LocalWP):** `C:\Users\keith\Local Sites\jsc\app\public\` — still running **Divi** (et-cache present). Imported via All-in-One WP Migration from the Pressidium staging export.
- **Live site:** https://jscfla.com (Divi, production)
- **Staging:** Pressidium dashboard (separate environment)
- **Migration artifacts / deliverables:** `C:\Users\keith\Desktop\jsc-kadence-mockup\`
  - `barndominium-mockup.html` — approved design template (the styling reference for ALL service pages)
  - `bwd-review-shortcodes.php` — review stars snippet (review data already filled in)
  - `docs\alex-license-CRC1332267-exp2026.pdf` — Alex's contractor license

## The job (what Keith wants)

Modernize JSC the same way Tire Express and Black Rock were modernized — re-skin in Kadence
without losing rankings. **The barndominium page already ranks #1-#2 for its terms; protecting it
is the top priority.** Keith is fine delivering layout as custom HTML in a Kadence Custom HTML
block, but prefers Kadence-native blocks where equivalent (esp. galleries).

## Hard rules for this migration (ranking protection)

Priority order of what MUST be preserved per page:
1. **URL/slug identical** — e.g. `/barndominium-builders-in-florida/` stays byte-for-byte. 301 anything that must change.
2. **Body copy substantially the same** — keep word count and keyword-rich paragraphs. (Spelling fixes are fine — see below.)
3. **Title tag**, then **H1**, then **self-canonical**, then **internal links**.
4. Each page stays **self-canonical**. ⚠️ Spokes/galleries do NOT canonicalize to siblings or home. Flag any canonical work to Keith explicitly (he's not deep on canonicals).

## DESIGN — locked (mockup approved)

`barndominium-mockup.html` is the approved template. Decisions:
- **Palette:** blue `#2166D3` (primary, from existing site buttons), blue-dark `#174FA8`, gold `#F2A93B` accent, ink `#16191D`. **Approved.**
- **Fonts:** Fira Sans (headings) + Nunito Sans (body) — already the site's fonts.
- **Header:** top bar removed; header CTA is **click-to-call** (`tel:3526872030`) with phone icon.
- **CTA standardization (approved + APPLIED 2026-06-09):** primary CTA everywhere = **"Get a Free Quote"**, every instance links **directly to `/contact/`** (no #anchor hop). Secondary = phone click-to-call. Kill "Make an Appointment"/"Get Started Today" except on the contact page. (Same playbook as Black Rock's "See My Options"/"Apply Now".) Repeating the CTA down the body is fine/expected on long pages.
- **Hero:** per-page hero photo behind a gradient overlay (dark left → transparent right) so the white H1 stays legible. Keith is supplying text-free montage images (ChatGPT made one; the text/logo version is kept for OG/social cards only).
  - ⚠️ **iOS Safari gradient paint bug:** build the hero overlay with the `::after` pseudo-element pattern from day one (NOT Kadence's native overlay). CSS fix is in root CLAUDE.md; mockup already uses the pattern.
- **Photo strip → grid:** old Divi sidebar strip becomes a 3-up gallery placed right AFTER the intro copy (so it's high on the page on mobile, not dumped at the bottom). Use a **Kadence Advanced Gallery block**, not hand-coded `<img>` — gets ShortPixel WebP + Perfmatters lazyload + editable alt text. Real JSC photos only; keep the "Every photo on this page is a real JSC job — no stock photos" line.
- Numbered step circles (1, 2) on the process sections.

## COPY — keep verbatim EXCEPT these fixes (already applied in mockup)

The live barndominium page has misspelled keywords **in heading tags**. Fixing = pure SEO upside, zero risk:
- H2 "Bardominium" → **Barndominium**
- H2 "Barndomimium" → **Barndominium**
- Body: barndomium, barnodminium, barndominim → barndominium
- "one our architects" → "one of our architects"
- "not quite want you want" → "not quite what you want"
- "it easy for us" → "it's easy for us"
- "slogan as JSC" → "slogan at JSC"
- **Kill the empty `<h2></h2>`** Divi left behind.
- ⚠️ **WRONG-CLIENT BUG on live page:** the final CTA on the live barndominium page says "make an appointment for a **plumbing** service" — that's pasted from another site. Replace with a barndominium quote CTA (done in mockup).

On OTHER pages that need ranking *improvement* (not just protection), Keith may request deeper copy work later. Default = preserve.

## Reviews — DONE in artifacts

- **25 Google reviews, 5.0 rating.** Review link: `https://g.page/r/CU_afPuU9LllEAE/review`
- `bwd-review-shortcodes.php` has these values baked in. Shortcodes: `[bwd_stars]` (full badge, linked), `[bwd_review_count]`, `[bwd_rating]`.
- ⚠️ **TODO BEFORE GO-LIVE (Keith asked to be reminded):** actually install `bwd-review-shortcodes.php` into the child theme `functions.php` or snippet plugin, and confirm the shortcode names match the Tire Express implementation (I couldn't retrieve the TE version — verify and reconcile naming so all sites match).
- ⚠️ **Do NOT add `aggregateRating` schema** to service pages. Visible star badge = fine and converts. Self-serving aggregateRating pulled from Google violates Google's guidelines → manual action risk. Display only.

## License — DONE

- **Alex (John Alexander Scanlan), JSC CONTRACTING INC. — CRC1332267**, issued 09/10/2024, **expires Aug 31, 2026.**
- It's a **Certified RESIDENTIAL Contractor** license (Ch. 489), NOT a general contractor license. On-site wording: "Florida Certified Residential Contractor — Lic. CRC1332267" (in mockup hero trust strip + footer).
- ⚠️ Expires in <3 months — nudge Alex to renew so the site isn't advertising a lapsed number.

## SCHEMA — architecture decided (build at END of migration)

- **Custom WP code** (child theme/snippet) injects **`Service`** (per service page) + **`FAQPage`**.
- **AIOSEO** owns **`LocalBusiness`/`GeneralContractor`** + **Organization** + `BreadcrumbList`.
- ⚠️ **Critical (this bit Black Rock):** custom code must NEVER redefine the org. Reference AIOSEO's node by `@id`, e.g. `"provider": { "@id": "https://jscfla.com/#organization" }`. First step when writing the snippet: dump AIOSEO's actual `@graph` on staging to confirm its real `@id` format before referencing.
- `GeneralContractor` is the right schema `@type` (LocalBusiness subtype); `hasCredential` must state **Residential** contractor, not GC.
- Service page schema target: `Service` (serviceType "Barndominium Construction", areaServed Florida, provider → org @id) + `FAQPage` + `BreadcrumbList`.

## FAQ — draft approved (needs Alex's real numbers)

FAQ section approved for the barndominium page (5 Qs in mockup).
- **Cost range** — ✅ DONE 2026-06-09: Keith supplied **$100,000–$800,000**; answer written (size+finishes levers, cheaper-than-traditional framing, links the 2026 cost post). Live on the page.
- **Build timeline** — Q removed from the live page until Alex gives a real range; when he does, re-add to the FAQ: "How long does a barndominium build take?" / "Most builds run X–Y months depending on size, site prep and material lead times."
- All visible DRAFT markers removed from the page 2026-06-09 (the gold pill element Keith liked is now the reusable `.jsc-tag` class — currently used as "REAL JOBS ONLY" on the photo-grid note).
- **Hero images (DECIDED 2026-06-09):** Keith's montage (`uploads/2026/06/jsc-contracting-hero.webp`, attachment 102056, 1672×941) = **HOME page hero** when home is rebuilt. It's temporarily standing in on the barndominium page until Keith finds a better full-res barndo exterior shot (existing barndo photos are 500×500 — too small for heroes). Swap is one line in `barndo-kadence-content.html` + re-run apply script.
The other 3 (build statewide / own floor plan / financing 5% down) are answered from existing copy.

## Internal linking (additive, low-risk)

- From the photo grid: link to **Barndominium Gallery** page ("see more of our completed builds →"). It ranks #1 for gallery query — feed it.
- From the FAQ cost answer: link to the **2026 cost blog post**.
- Keep existing "preferred lenders" → blackrockmortgage.com link (legit cross-client).
- ⚠️ Gallery and this page each stay self-canonical — related = internal link, never canonical.

## NEXT STEPS (in order)

1. ~~**Lock page inventory**~~ ✅ DONE 2026-06-09 — see `jsc-page-inventory-baseline.md` (33 URLs, all self-canonical, 6 issues flagged).
2. ~~**Build the barndominium page in Kadence**~~ ✅ DONE 2026-06-09 (v1, local) — page 100717 rebuilt; verified: title/canonical/meta-description preserved, single corrected H1, 6-photo Kadence Advanced Gallery, FAQ drafts, CTA standard applied. **Outstanding on this page:** hero montage image (Keith supplying — current `barndo-outside-2.webp` is a low-res placeholder), FAQ real numbers from Alex.
3. ~~**Build the Kadence header/footer**~~ ✅ DONE 2026-06-09 (v1, local, via `apply-header-footer.php`) — header: JSC-Wide.png logo + nav + click-to-call button (desktop & mobile, no top bar); footer: dark 3-col (contact / services links / service area) + CONQUER values band + license/copyright fine print. Review visually + polish as needed.
4. ~~**Templatize service pages**~~ ✅ DONE 2026-06-09 — all 8 remaining service pages rebuilt in Kadence via `build-service-page.php` + `specs/<slug>.php` (edit spec → rerun to tweak). All verified: titles/canonicals/meta preserved, single H1 each, zero broken images. Per-page notes:
   - **dock builder**: typo fix "Give is a call"→"Give us a call".
   - **boathouse**: FIXED WRONG LINK — "seawall" anchor pointed at the dock page, now points to the seawall page. Typos: "bring to the life"→"bring to life", "boats interior"→"boat's interior".
   - **seawall**: typo fixes ("has been been", "galvanized steal"→steel, "with exert"→"will exert", "pilons"→"pilings", slogan line normalized). **Wrote missing AIOSEO meta description** (baseline issue #5).
   - **boat lift**: stripped leftover AI-editor CSS classes (font-claude-response-body) + tailwind hr classes from live copy.
   - **pole barn**: ALT FIX — small-poll-barn-500.webp had alt "central florida fence builder" → "Small pole barn built by JSC".
   - **remodeling**: typos ("found akitchen sink", "house as 2 bathrooms"→has, "need use"→"need to use").
   - **new construction**: typos ("we are great at we do"→"at what we do", "comprising"→"compromising", "That's not case"→"That's not the case").
   - **fence**: typos ("Hight tensile/Hight fence"→High, "pilons"→pilings). **SLUG CHANGED + 301** (see below). ⚠️ H1 deviation: baseline (live) H1 was "Central Florida's Best Fence Builder"; rebuilt page uses "Central Florida Fence Builder" as H1 (matches title/slug/query exactly) with "Central Florida's Best Fence Builder" as the intro H2 — **flag to Keith, can flip in spec if he wants the baseline H1.**
   - Hero sub-lines under each H1 are new template microcopy (one line each) — Keith should skim them.
   - **Photo refresh + captions (2026-06-09 evening):** Keith's 8 new photos (from `OneDrive\...\Updated Pics for JSC\`) resized to 1200px WebP via ffmpeg, imported with SEO filenames + alts (IDs 102071–102078), slotted into: dock (3 new), seawall (Lake Weir + cracked/washout repair pics now illustrate the repair section), pole barn, remodeling (Bushnell addition), boat lift (boathouse+lift combo), barndo gallery (Alachua build). **Visible captions now on every service-page gallery** (Keith liked them on barndo; builder supports `caption` per image). Keith does NOT need to resize photos himself — drop originals anywhere and ask.
   - Galleries link to their matching gallery pages (dock→dock-gallery, etc.) — internal-link spokes per plan.

4b. **Fence URL fixed + 301 (Keith requested, 2026-06-09):** the clean slug was held by an image attachment (renamed to `central-florida-fence-builder-image`); page is now `/central-florida-fence-builder/` with a **301 from `/central-florida-fence-builder-2/`** in the child theme `functions.php` redirect map (deploys with the theme — add future slug changes there). All 38 internal references to the old slug search-replaced (dry-run first). Footer services list now includes Fencing. ⚠️ Remember: redirect must be re-tested on staging/live after deploy.
⚠️ OPEN DECISION (Keith undecided 2026-06-09): `/marine-construction-gallery/` — redundant (all photos duplicated from dock/boathouse/seawall galleries, not in nav). Options: keep as-is (harmless) or 301 → `/galleries/`. A future "marine construction central florida" ranking play gets its own service hub page regardless.

4c. ~~**Gallery pages**~~ ✅ DONE 2026-06-09 — all 8 service galleries rebuilt via `build-gallery-page.php` (image lists in editable `specs/gallery-<slug>.json`; edit JSON → rerun slug to curate). Grids use 768px sizes, **lightbox to full size**, empty alts backfilled, each gallery links back to its service page (reciprocal internal links). **dock-gallery H1 FIXED** ("Boathouse Gallery" → "Dock Gallery", baseline issue #1). New photos added: dock +3, seawall +1 (was 2 pics, now 3 — still thin, ask client for more), pole barn +1, barndo +2, marine +1. STILL TODO: `/galleries/` index page, info pages (services, about-us, our-team, core-values, our-reviews, contact, thank-you, privacy), home page.

5. ~~Install `bwd-review-shortcodes.php`~~ ✅ DONE 2026-06-09 — lives in the Kadence child theme (`wp-content/themes/kadence-child/`), `[bwd_stars]` live in the barndominium hero. Still TODO: reconcile shortcode names with the Tire Express implementation.
6. ~~**Schema snippet**~~ ✅ DONE 2026-06-09 — `kadence-child/jsc-schema.php`: Service schema on all 10 service pages (serviceType + areaServed counties/statewide, provider → AIOSEO org by @id `{home}/#organization`, verified against rendered @graph) + FAQPage on barndo page only (blog posts keep their own). Verified: no duplicate org/FAQ nodes. ⚠️ AIOSEO Local SEO still needs configuring to emit GeneralContractor (currently plain Organization) — on the checklist.
7. ~~Pre-launch checklist~~ ✅ WRITTEN 2026-06-09 → `PRE-LAUNCH-CHECKLIST.md`. Deploy is Keith's call.

## HOME EDITS ROUND 2 + HERO ROLLOUT (2026-06-09 late) — DONE

- New golden-hour montage hero (`jsc-home-hero-montage.webp`, att 102131, 1983×793) on: home, services, about-us, core-values, our-team, galleries index, contact, our-reviews — with the lighter `jsc-hero-warm` gradient variant. Thank-you keeps the fence hero. Service pages keep their per-service heroes.
- Home blog cards FIXED (latest-posts needed `postLayout:grid`) — 3-up cards, uniform 3:2 images, gold title accent. Blog slider idea parked until 6+ posts exist (Keith agreed grid is right for now).
- Perfmatters LCP preload FIXED — was preloading the dead Divi hero (`jsc-fla2.webp`) on every page; now preloads the montage.
- **`/blog/` FIXED** — `page_for_posts` was 0 and the page held dead Divi content, so no posts listed. Now a real posts page (archive via Kadence), dead content cleared, meta description written. Title preserved ("Blog - JSC Contracting Inc").
- Alex photo vertically centered against copy on home + about-us.
- Full sweep re-run after all of it: **ALL CHECKS PASSED**.
- NEXT: contact page changes — Keith has things he wants to discuss.

## ⭐ TOMORROW'S AGENDA (set 2026-06-09 night — work this list in order)

1. ~~**AIOSEO Organization + Local SEO data**~~ ✅ DONE 2026-06-10 — Keith filled NAP/hours/areaServed in the UI; patched via script (`patch-businesstype.php`, `patch-hours.php`): businessType **GeneralContractor**, about/contact entity URLs, **Sat/Sun marked closed** (UI defaults had weekends open 9–5, contradicting the visible "By Appointment" copy — watch for this on other sites). License credential added as `hasCredential` (Certified RESIDENTIAL Contractor CRC1332267, recognizedBy FL DBPR) on the `#localbusiness` node via `aioseo_schema_output` filter in `jsc-schema.php` — additive, no @id redefined.
2. ~~**Featured images audit**~~ ✅ DONE 2026-06-10 — `audit-featured.php` + `set-featured.php`/`set-featured2.php` (idempotent). Keith's brand cover ("Quality Craftsmanship. Built to Last." montage) center-cropped to 1200×630 (`jsc-og-cover.jpg`, att 102187) → featured on all 11 info/utility pages (home, about, contact, core-values, our-team, services, galleries, quote, thank-you, privacy, blog). Real job photos → all service + gallery pages (was: 12 pages with NONE, several 300–500px squares). og:image verified flowing from featured images. **Remaining smalls (no larger source exists in library):** boathouse-gallery, new-construction page, fencing gallery, new-home gallery (500px) + the 3 blog posts (left as-is, cards approved) — upgrade when client sends bigger photos. Container page uses temp video frame — swap with real pics when they arrive.
3. ~~**Schema re-validation**~~ ✅ DONE 2026-06-10 — `schema-audit.ps1` (in this folder) sweeps 7 page types: org node stable at `{home}/#organization` everywhere, all 10 Service provider refs resolve, FAQPage on barndo only (+ blog posts' own, intentional), Person/author wired on posts, zero aggregateRating. Home page has BOTH `#organization` (sitewide) and `#localbusiness` (GeneralContractor w/ hours+credential) — **this is AIOSEO's standard two-node architecture, distinct @ids, NOT the Black Rock collision; leave it alone.** verify-all.sh: ALL CHECKS PASSED.
4. ~~**Titles + meta descriptions full review**~~ ✅ DONE 2026-06-10 — `audit-meta.php` (sweep) + `fix-meta.php` (fixes, length-asserted). All 33 published pages/posts have titles + descriptions. Fixed: thank-you NO-DESC (written), 4 over-160 descriptions trimmed, 2 thin gallery descriptions expanded, privacy "as JSC"/pole-barn-gallery "JSC construction" typos, 3 blog post titles cut from 85–128 chars to 61–63 (front-loaded, suffix dropped). Service-page titles untouched (preservation rule). Blog titles intentionally 61–64 chars — fine by pixel width. verify-all: ALL CHECKS PASSED. Note for item 5: if DataForSEO says the dock/fence pages should target different queries, titles are one-field edits in `wp_aioseo_posts`.
5. ~~**DataForSEO hookup + dock page push**~~ ✅ DONE 2026-06-10 — credentials at `C:\Users\keith\.dataforseo-auth` (base64, Basic auth; OUTSIDE the project folder, never deploy/commit). Balance ~$51; raw pulls saved as `dfs-ranked-keywords.json` / `dfs-serp-dock.json`.
   **Findings:** "dock builder central florida" = ZERO volume; real market: "dock builder(s) near me" 1300/mo FL, "dock repair near me" 320/mo @$25 CPC, "seawall contractors near me" 390/mo. Live site ranks for ~nothing dock-related; barndo page also #29 US for "barndominium builders near me" (14,800/mo). Ocala SERP: local pack first (Type1/AMC/Legacy — JSC absent), winners use plural "Dock Builders" + repair pairing; PAA = all cost questions.
   **Applied (Keith approved):** dock H1/title pluralized + repair added (title "Central Florida Dock Builders — Custom Docks & Dock Repair", 58c), new Dock Repair section, 5-Q visible FAQ + FAQPage schema (jsc-schema.php map), meta description rewritten. verify-all baseline H1 updated for the deliberate change. ALL CHECKS PASSED.
   **Still on this play:** (a) dock cost blog post — NEEDS ALEX'S NUMBERS (same playbook as barndo cost post; "dock builders near me prices" + PAA all cost Qs); (b) FAQ cost answer gets real range when Alex provides; (c) GBP work is the local-pack prize (dock photos, services, review velocity) — Keith/Alex task; (d) seawall page deserves same treatment ("seawall contractors near me" 390/mo @$25).
6. ~~**Contact page: add a map**~~ ✅ DONE 2026-06-10 — static-image-link pattern (zero JS): 880×560 WebP (att 102185, ~70KB) below the hours in the contact sidebar. Image = **Keith's screenshot of the actual Google listing map** (pin is out E Hwy 40 by the forest — the coords I'd scraped from the listing page were wrong; Census geocode was right). `crop-map.ps1` in this folder re-crops a fresh screenshot around the red pin → same filename, just rerun + copy over the upload + `wp media regenerate 102185`. Image + "Get Directions →" both link to the listing (`maps.google.com/?cid=7330158789233793615` — verified correct by Keith). Perfmatters lazyloads it. CSS: `.jsc-map` in child style.css.
7. Button up remaining items → **GO LIVE** (follow PRE-LAUNCH-CHECKLIST.md — updated 2026-06-10: local side fully launch-ready, sitemap verified 33 URLs).

## SERP TWEAKS ALL SERVICE PAGES + SOCIALS (2026-06-10, Keith approved) — DONE

- **DataForSEO sweep of every vertical** (`apply-serp-tweaks.php`): 🔥 **"fence builders/companies near me" = 18,100/mo FL — the site's biggest market, bigger than barndo.** Applied (H1 + post_title synced, slugs untouched): fence → "Central Florida Fence Builders" (plural), new construction → **"Custom Home Builders in Central Florida"** (2,400/mo + 6,600/mo "new construction homes near me"), pole barn → "Pole Barn Builders…", boat lift → "…Installation & Repair" (repair 320/mo beats install; repair FAQ already on page), boathouse → plural. Remodeling title += "Remodeling Contractors" (1,900/mo); container title += "Shipping Container Homes" (210/mo). Seawall already aligned; barndo untouched (protected).
- Gotcha fixed: pole-barn + boathouse had stale CUSTOM AIOSEO titles (pole barn doubled to "…in Central Florida in Central Florida") — cleared to default (`clear-stale-titles.php`). Reminder: `wp db query` broken on Windows — eval-file only.
- **Socials added** (from live site): Facebook /JSCContractingInc, Instagram /jsc_contracting_inc, TikTok @jsccontractinginc → AIOSEO social profiles (sameAs verified in org schema) + visible footer icons (`.jsc-social` in style.css, icons in `apply-header-footer.php` jsc3 widget).
- verify-all baselines updated for the 7 approved H1/title changes (boat lift H1 renders `&#038;`). **ALL CHECKS PASSED.**
- **Future fence play (the 18k market):** fence page deserves the full dock treatment — FAQ, SERP analysis, maybe a fence cost post. Post-launch with the content wheel.

Also pending whenever: Keith's new quote form ID (swap in build-quote-page.php), Alex's FAQ timeline answer, container home pics/pricing, footer/header social links if wanted.

## AUTHOR / E-E-A-T: Alex Scanlan (2026-06-10) — DONE

- **All posts (5, incl. 1 draft) + all 32 pages reassigned to user `alex` (ID 12)** — display name "Alex Scanlan", Author role, license-bearing bio. Keith created the user + filled the AIOSEO E-E-A-T author tab (jobTitle Owner, bio, authorImage alex-400.webp att 100841). Script: `set-author.sh` (idempotent).
- **One author box only:** AIOSEO E-E-A-T's compact bio box on posts (Kadence's own author box off — keep it off). Byline "By Alex Scanlan" renders in entry meta.
- **"See Full Bio" → `/our-team/`** (EEAT authorCustomUrl) instead of the thin author archive. Script: `author-aioseo-tweaks.php`.
- **Author archives noindexed** (single author → archive duplicates /blog/). ⚠️ The AIOSEO setting (Archives→Author→robotsMeta noindex, also set) silently never applies on this site — with the posts page at /blog/, AIOSEO's Robots::meta() takes the post branch before the is_author() branch. Enforced via `aioseo_robots_meta` filter in `kadence-child/functions.php` instead. Verified: archive noindex, posts/home unaffected.
- **Avatar filter** in `kadence-child/functions.php`: `pre_get_avatar_data` serves alex-400.webp for Alex everywhere get_avatar() is used (no Gravatar account).
- ⚠️ **PRE-LAUNCH:** EEAT user meta stores absolute `http://jsc.local` URLs (authorImage, authorCustomUrl — serialized user meta). The standard deploy search-replace handles serialized data — verify both post-deploy on the live post bio box.
- Side effect: post_modified bumped to 2026-06-10 on all posts by the reassignment ("Updated June 10" shows on posts + dateModified schema). Harmless pre-launch.
- Also today: Keith filled AIOSEO Local SEO (NAP, GeneralContractor type, Mon–Fri 8–4 hours) — schema re-validation (agenda item 3) still pending.
- verify-all.sh after all of it: **ALL CHECKS PASSED**.

## QUOTE FUNNEL SPLIT (2026-06-09 late) — DONE

- **NEW `/get-a-free-quote/` landing page (102146)** — every "GET A FREE QUOTE" button sitewide now points here (was /contact/; zero stale links verified). Built to convert: form-in-card beside the headline (above the fold), 3-step "how it works", review stars + client pull-quote, objection FAQ ("really free?" / response time / "not sure what I want"), phone fallback band. **Form is WPForms 101491 placeholder — Keith building a prettier quote form; swap `$JSC_QUOTE_FORM_ID` in `build-quote-page.php` + rerun.** Copy claims to confirm with Keith/Alex: "quote most projects on site", "respond within one business day".
- **Contact page is now a true contact page** — new simple form (WPForms 102170, Keith-built, live), copy tuned to questions, prominent link to the quote page for price-seekers.
- Gallery heroes now match their service-page heroes (barndo/pole barn/fence/new-home updated; dock/boathouse/seawall already shared the marine banner — flagged: those 3 service pages could each use a distinct hero when photos arrive).
- verify-all.sh updated (landing page in sweep): **ALL CHECKS PASSED**.

## BUILD COMPLETE (2026-06-09) — full verification

`verify-all.sh` (in this folder): **ALL CHECKS PASSED** — 27 pages + 3 posts (H1s, canonicals, meta descriptions, images) + 3 redirects (fence slug, dock-near-me→dock page, marine-gallery→galleries). Also done this session: home page rebuilt (montage hero, double-comma meta fixed), services page (10 cards), SEO consolidations per approved plan. **Home page edits pending — Keith reviewing.**

## Local build infrastructure (added 2026-06-09)

- **WP-CLI env:** `source ~/Desktop/jsc-kadence-mockup/wp-env.sh` in git-bash (JSC must be running in LocalWP). `wp db query` is broken on Windows paths — use `wp eval-file` for SQL.
- **Themes/plugins installed locally:** Kadence 1.5.0 + child theme `kadence-child` (ACTIVE — all custom code goes here), Kadence Blocks 3.7.5, Kadence Blocks Pro 2.8.16, Kadence Pro (theme addon) — both Pro plugins **licensed + validated** 2026-06-09 (key in Keith's Kadence account; stored in WP options via StellarWP Uplink). DB backup before all this: `backup-pre-kadence-20260609-1728.sql` in site root.
- **Page rebuild workflow:** edit `barndo-kadence-content.html` (block markup) → `wp eval-file apply-barndo-page.php` (idempotent: content + Kadence page meta + alts + palette). Same pattern to be reused per page.
- **Approved palette is live** in Kadence global palette (palette1 #2166D3, 2 #174FA8, 3 #16191D, 4 #3C434B); fonts (Fira Sans/Nunito Sans) enqueued by the child theme.
- AIOSEO titles/descriptions are directly writable in the `wp_aioseo_posts` table (verified) — no clipboard pasting needed.

## BLOG — ⚠️ MAJOR LIVE-SITE BUG FOUND + RECOVERED (2026-06-09)

**On the LIVE site, every blog post renders the SAME article** (the Lake George dock article). Cause: articles were pasted into the Divi Theme Builder "All Posts Body Layout" (post 91300), each overwriting the last — posts' own content was an empty Divi section. Confirmed live: the cost post and fence post both serve Lake George copy. **Until the migration ships, live blog posts are serving duplicate/wrong content** (bad for the rankings these posts were written to win).

**Recovered locally:** the real articles survived in revisions of 91300. `restore-blog-posts.php` wrote each article into its own post_content (clean HTML block): cost post (rev 101884), fence (101898), seawall checklist (101849), Lake George (102019). Cleanups: in-content H1 removed (Kadence renders title as H1), hero figure removed (featured image covers it), Article JSON-LD dropped (AIOSEO emits it — kept the FAQPage JSON-LD), links made relative, dead `/meet-the-team` link → `/our-team/`. All four verified rendering their own articles locally.

**UNRECOVERABLE: `/blog/dock-builder-near-me/`** — its article was in a Divi code module that was emptied 2026-03-23; only a 2-paragraph intro fragment survives (revision 101408); no Wayback snapshot. Needs Keith's call: redraft it (fragment + dock service page as source), or retire/301 it to the dock service page.

## Service pages to migrate (from nav + sitemap)

barndominium-builders-in-florida (PRIORITY/ranking), barndominium-gallery, docks, boathouses,
seawall-construction-and-repair, boat-lift-installation, pole-barns, home-remodeling-central-florida,
new-construction, about-us, reviews, blog, contact. (Confirm full list against sitemap in step 1.)

## NEW: Container Homes page (2026-06-09, DRAFT — Alex must review copy)

- `/container-home-builders-in-florida/` (page 102114) — new service page, slug mirrors the proven barndo pattern. H1 "Container Home Builders in Florida". **NO pricing in copy** (Keith hasn't discussed numbers with Alex). Copy drafted by Claude — angle: steel expertise (barndo/marine) → container credibility; spray foam insulation (from Alex's own build video); hurricane strength; statewide.
- Wired in: nav menu (under Services), footer services list, new-construction "We build" list link. Gallery link → new-home-gallery for now.
- Photos are TEMPORARY video frames (IDs 102111–102113) — swap when client sends real container pics. Keith asking client for more.
- LATER: cost blog post ("what does a container home cost in Florida") once Alex provides numbers — same playbook as the barndo cost post.

## VIDEOS (2026-06-09) — 6 raw .MOVs in `OneDrive\...\Updated Pics for JSC\`

30x48 Pole Barn · Custom Barndominium interior (registers covered) · Seawall build in Crystal River · new horse barn · container home ×2 (all portrait phone video, 720×1280, 8–19MB). **Plan: upload to a JSC YouTube channel** (Keith to create), embed on matching pages via Perfmatters YouTube facade (lazy), AIOSEO video sitemap addon already active. Transcripts: set up local Whisper so Claude can transcribe → paste transcript under each embed (SEO win). TODO: install whisper (e.g. whisper.cpp or faster-whisper) next session.

## CONTENT ROADMAP (post-build) — sketch, refine with Keith

- **Local content wheel:** rotating county/lake-specific posts feeding service pages — e.g. "Building a dock on [Lake X]" (Lake George post is the template — it's good), seawall inspections by waterway, barndo builds by county. Each post: local terms + photos from that job + links to its service page + GBP post.
- **Marine cluster build-up:** docks/boathouses/seawalls/boat lifts each get supporting posts (Crystal River seawall video → post candidate), cross-linked; goal = own "marine construction central florida".
- **Barndominium reinforcement:** it ranks — keep feeding it (cost post refresh cadence, container-vs-barndo comparison post, build timeline post once Alex gives numbers, YouTube walkthroughs).
- **Container homes:** new page → pics → video embeds → cost post → maybe gallery page once 3+ projects.
- **DataForSEO:** Keith has an account — get credentials configured so keyword research is data-driven (volumes/difficulty) instead of judgment calls.

## Client facts

- JSC Contracting Inc, 16455 E Hwy 40 Unit 1, Silver Springs FL 34488 · 352.687.2030 · info@jscfla.com
- Owner: Alex Scanlan. Tagline "You dream it. We build it." 25+ yrs. CONQUER values acronym.
- GBP primary category: Dock builder. Service area: Marion, Lake, Sumter, Citrus, Alachua, Putnam + statewide for barndominiums.

## 2026-06-12 — mobile drawer CTA (FGS pattern)
- Quote menu item (102184, class `jsc-menu-quote`) now renders as a full-width gold button inside the
  mobile drawer with a pulsing green availability dot (also shows on the desktop button).
- Local: rules appended to kadence-child/style.css. PROD: theme CSS not REST-editable, so the same
  rules ride in a `<style>` block appended to footer widget **block-90** via REST /wp/v2/widgets
  (later-declared beats the stylesheet on !important ties). If/when a full AI1WM redeploy happens,
  the child CSS carries the rules natively — the widget block is then redundant but harmless.
- Verified live: pulse CSS + class render on jscfla.com, footer logo/review link intact.
- STILL ON KEITH (prod Perfmatters UI): add `jquery` to Delay JS exclusions; change mobile preload
  URL to jsc-home-hero-montage-mobile-hd.webp; purge caches after.

## 2026-06-12 (later) — quote page v2 + form fix
- Pulse dot REMOVED from menu buttons (Keith: dot belongs above the form, not in the nav). Drawer
  gold button stays (local child CSS + prod footer widget block-90 style block).
- Quote page form section rebuilt: "Tell Us About Your Project" + FGS-style callback bar
  (pulsing green dot, "call back the same business day") + selling sidebar (.jsc-form-aside:
  why-JSC checklist, quote-not-a-guess card, call card; sticky on desktop, stacks <880px).
  Styles ride inside page content so prod push is self-contained.
- WPForms broken on prod (jquery type=pmdelayedscript while wpforms scripts defer). No REST route
  to perfmatters_options -> shipped self-disabling shim in page content: script tag id
  "wpforms-jquery-fallback" (the id matches the existing wpforms delay-exclusion so Perfmatters
  leaves it alone) document.writes jquery ONLY if window.jQuery is missing. Once Keith adds
  `jquery` to prod delay exclusions the shim no-ops; can be removed on a later push.
- GOTCHA RECONFIRMED: build-quote-page.php needed wp_slash() once content contained <\/script>.
- Verified live: shim not delayed, backslash intact, callback bar/aside/dot render, menu pulse gone.

## 2026-06-12 (night) — SFTP deploys: jquery fix permanent, stopgaps removed
- Pressidium SFTP live (creds: ~\.pressidium-sftp.txt, user jscfla-prod-claude). Pushed:
  (1) NEW mu-plugin wp-content/mu-plugins/jsc-perfmatters.php — filter perfmatters_delay_js_exclusions
  adds `jquery` (WPForms fix, permanent, code-versioned). VERIFIED live: jquery-core-js no longer
  pmdelayedscript. Keith UI flip no longer needed for jquery — ONLY remaining flip: Perfmatters
  mobile preload URL -> jsc-home-hero-montage-mobile-hd.webp.
  (2) kadence-child/style.css — prod now matches local (drawer button CSS native).
- Removed both stopgaps: footer widget block-90 <style> hack (REST) and the quote-page
  wpforms-jquery-fallback shim (rebuilt + pushed). All verified live; form renders.
- KEITH: purge Pressidium cache (cached pages still serve old HTML until then).

## 2026-06-13 — Facebook share button mobile fix
- FB sharer.php dead-ends in the mobile FB app. Added a wp_footer document-level click listener
  (is_singular) that, where navigator.share exists, opens the native share sheet instead; targets
  the FB link by href (class-agnostic). Desktop unchanged. functions.php pushed via SFTP, verified
  on prod. KEITH: purge Pressidium cache, then test on a phone.
