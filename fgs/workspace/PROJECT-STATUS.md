# PROJECT-STATUS.md — FGS (Florida Geotechnical Services)

> Source of truth for the FGS build-out. Script-driven workflow (numbered `fgs-*.php`, all idempotent,
> run via `wp eval-file`). See CLAUDE.md in this folder for conventions and the WP-CLI shell incantation.

Last updated: 2026-06-11 (first full working session — Phases 0–5 of the approved master plan executed)

## The strategy (approved by Keith 2026-06-11)

Relaunch on the SAME domain (floridageotechnicalservices.com — currently an Astro site, ranks #5 for
"geotechnical engineering florida"). Competition is weak/fragmented (no national firms in any top-10;
~810/mo addressable volume, "soil testing near me" 260/mo biggest). Location wheel = Ocala hub +
Gainesville, The Villages, Sumter, Citrus, Lake, Putnam (NOT Orlando/Tampa locally; statewide via pillars).
Design = live site's tokens: Urbanist font, #c63a3a red, #FBFBFB/#F3F3F3 off-whites, #f0e5e5 blush,
#2d2d2d charcoal. Full plan: `C:\Users\keith\.claude\plans\sunny-exploring-biscuit.md`.

## Done (2026-06-11) — verify with `.\verify-all.ps1`

- **Truth audit:** invented team members (Henderson/Chen/Carter/"New Person") stripped from About;
  duplicate starter-template team section removed; real privacy policy written + published (+H1);
  7 starter blog posts ("hello world", blogging tips) unpublished to draft.
  ⚠️ PE #58334 / "Dave Cappa" / FDOT+CMEC accreditations / experience-years REMAIN on 12 pages,
  UNVERIFIED — see `CLIENT-CONFIRMATION-CHECKLIST.md` (launch blockers). A real "Dave Cappa, Senior
  Engineer, Geo Technology Inc, Ocala" exists on LinkedIn, so likely legit — confirm before deploy.
  Softening script staged if client can't confirm: `fgs-01b-soften-claims.php` (dry-run default,
  FGS_APPLY=1 to write; covers 57 occurrences; does NOT yet cover AIOSEO descriptions on page 269/92/94).
- **Design tokens:** Kadence palette + 874 inline hex swaps + footer widget + Additional CSS swapped to
  live-site tokens; Urbanist heading+body (Perfmatters auto-localized the woff2s — verified serving);
  iOS Safari gradient fix CSS appended (marker-guarded); 1200×630 OG image generated (media ID 436,
  "From Soil to Structure" design) + wired as AIOSEO default + homepage og:image; theme-color #c63a3a
  via mu-plugin `wp-content/mu-plugins/fgs-head-meta.php`.
- **SEO foundation:** missing AIOSEO titles/descs filled (pillar 146 had NONE; also 98/96/99/6);
  Local Business fixed (zip 34471→34474 NAP mismatch, "AVe" typo, about/contact URLs, map center was
  Seattle→Ocala); llms.txt enabled + generated; sitemap OK; all pages verified self-canonical;
  `redirects.csv` = the one real redirect (/services/geotechnical-engineering → pillar) for launch.
- **Location wheel:** 6 pages created as **DRAFTS** (IDs 444–449) — Gainesville, The Villages, Sumter,
  Citrus (sinkhole-led), Lake, Putnam. Real geology per county, varied structure, FAQs, internal links,
  hero/trust/CTA in new tokens. Bodies in `location-pages/*.html`; insert/update via
  `fgs-05-location-pages.php` (re-runnable; preserves status). **KEITH: review + publish.**
- **Blog:** `BLOG-PLAN.md` — 12 topics, 2/mo, AI-citation formatting standards. No posts page set yet
  (deliberate — set Reading→Posts page when post #1 publishes).
- **Perf/cleanup:** All-in-One WP Migration ×2 deactivated. NOTE: do NOT deactivate Kadence Blocks free —
  Pro requires it as base (earlier audit note was wrong). Interim real-photo heroes swapped onto
  sinkhole/drilling/CMT/pavement/concrete/foundation pages.

## Design round 2 (Keith feedback, 2026-06-11 afternoon)

- Real-photo hero swaps REVERTED (`fgs-07`) — photos were mis-sized/mismatched. All service heroes back
  on correctly-sized 1200×500 placeholders in new palette (f0e5e5/a91513).
- Accent deepened to LOGO reds (`fgs-08`, applied): #c63a3a→#a91513, hover→#7c0e0d, across palette,
  content (425), footer widget, custom CSS. OG image + theme-color regenerated in #a91513 (attachment 490).
- **Black Rock-style hero "shine"** (`fgs-09`): deep logo-red gradient (180deg #a91513→#600000) + radial
  top-right glow + inset top highlight + lifted shadow + white/glassy hero buttons. Recipe extracted from
  black-rock-mortgage `.brm-hero`. Currently in **EXEMPLAR mode — page 269 (Foundation Engineering) ONLY**
  per Keith ("one page example before you do them all"). Review at
  http://fsg.local/foundation-engineering-florida/ — on approval run:
  `FGS_SCOPE=all wp eval-file fgs-09-hero-shine.php` (instant sitewide; CSS uses :has(h1), no content edits).
- verify-all.ps1: placeholder images now WARN (intentional until client photos); theme-color check → #a91513.
  Current status: ALL CHECKS PASSED.

## Design round 3 — body pattern exemplar (Keith feedback: gray/white banding "doesn't flow")

- Page 269 body rebuilt (`fgs-10-body-rework-269.php`, copy extracted+rewrapped verbatim, idempotent):
  all five full-width #f3f3f3 bands removed → one white canvas. New section system (classes in
  Additional CSS, marker `fgs-body-pattern`, reusable on other pages):
  lede intro → `fgs-why-grid` 5-card grid (maroon left edge) → existing Foundation Systems card grid
  (band removed) → `fgs-steps-panel` blush panel w/ numbered maroon steps → `fgs-split` two cards
  (res/com) → `fgs-tile-grid` 6 related-service link tiles → FAQ accordion on white → `fgs-author`
  blush card → `fgs-cta` deep-maroon shine panel. Hero gradient deepened per Keith:
  #7a0c0e→#4a0404→#2e0000 (fgs-09, still EXEMPLAR scope page 269).
- Rollout to remaining pages AFTER Keith approves 269: fgs-09 with FGS_SCOPE=all (hero CSS), and a
  generalized fgs-10-style pass per service page (same row surgery; each page's section mix varies).
- Gotcha for future scripts: `&#8212;` inside a `#`-delimited PHP regex ends the pattern — escape the hash.

## Design rollout — SITEWIDE (2026-06-12, Keith approved exemplar)

- Hero shine now SITEWIDE (`fgs-09` FGS_SCOPE=all): every page's H1 hero + #2d2d2d CTA groups
  (incl. the 6 location drafts + Contact's dark info card) render as deep-maroon shine panels.
- Body pattern rolled to 12 pages (`fgs-11-body-rollout.php`, dry-run reviewed then applied):
  ALL full-width gray bands removed sitewide; shape-based conversions — card grids on 146/202/205,
  link-tile grids ×7 (incl. pillar's 9-service list), blush author cards ×9, shine CTAs ×12;
  prose/RAWHTML/accordion rows de-banded. Contact's two-grid row handled in `fgs-11b` (its attrs
  lack "columns" — regex gotcha). `fgs-11b` also stripped 70+ legacy template authoring comments
  (`<p><!-- ==== SECTION ==== --></p>`) that rendered as empty paragraphs.
- Validation: 19 pages parse clean (no orphans, one H1 each, zero gray bands); verify-all
  ALL CHECKS PASSED (placeholder-image warnings expected until client photos).
- Backup before rollout: `backup-pre-rollout-2026-06-12.sql`.

## Polish round (2026-06-12 afternoon)

- `fgs-12-home-cards.php`: Kadence infoboxes (homepage 3 value props + 9-service grid + service-page
  infobox rows) restyled as cards — surface, blush icon chip, maroon hover lift (CSS, marker
  fgs-infobox-cards). New SECOND dark section on homepage: charcoal stats band (67 counties /
  5–7 day lab / one roof / 2023) inserted between services grid and Recent Projects — all claims
  truth-audit-safe. NOTE: Keith mentioned a screenshot in Downloads — never found (only yesterday's
  Tire Express PageSpeed shot); cards interpreted as the infobox rows. Confirm with him.
- `fgs-13-menu-style.php`: navbar restyled as the live Astro site's floating white pill (marker
  fgs-menu) — pill w/ border+shadow around logo/links/CTA, deeper shadow on Kadence-sticky
  `item-is-fixed`, animated maroon underline links, inverting maroon CTA, card dropdown for the
  Services menu, charcoal mobile drawer. Pure CSS — reversible by deleting the marker block.

## Design iteration log (2026-06-12, Keith live-driving) — scripts fgs-12..fgs-19

- Live-site treatments replicated: floating pill navbar (fgs-13, shrink OFF via theme mod
  header_sticky_shrink), interactive service list rows w/ hover photos (fgs-14, replaced homepage
  9-box grid), torn brush edges + construction sketch (fgs-15, assets lifted from client's live
  Astro site into uploads), infobox cards + dark stats band (fgs-12), full-bleed maroon hero
  behind transparent header w/ glass cards (fgs-17/18), testimonials flipped white-bg/gray-cards
  (fgs-16), founders section = dark torn band (fgs-19), footer rebuilt: letters logo on white chip,
  services links (jiggle hover), Get Directions, copyright row (fgs-19).
- HARD-WON GOTCHAS: (1) ::before pseudo-elements NEVER rendered in Keith's browser while ::after
  did — tears v2 (fgs-18) paints tears as multi-layer background-image stacks on the dark elements
  instead; pre-flipped asset fgs-edge-top-flipped.webp (GD imageflip) because transform:scaleY(-1)
  also failed. (2) #colophon carries footer_wrap_background=palette3 — dark bars above footer come
  from the WRAP, not the widget. (3) Kadence bgColorClass overrides bgColor attr edits. (4) background:
  shorthand wipes Kadence column background-image photos — use background-color longhand. (5) widget
  inline <style> loads after wp-custom-css — needs !important.

## Content round (2026-06-12 night)

- Free-quote funnel: /free-quote/ landing (ID 547, published) + 33 CTAs rewired + header outline
  button + mobile drawer button + callback-promise callout (also on /contact/). Contact rebuilt (94).
- Blog launched as DRAFTS: posts 586 (cost guide) + 587 (sinkhole signs), Blog page 588,
  Reviews page 589 (reuses homepage testimonial block + Google review CTA). Reading→Posts page
  NOT set yet — set when first post publishes. Bodies in blog-posts/*.html.
- Keith greenlit case-study posts ("project rundown" after completed jobs) — added to editorial
  approach; needs client project sign-off per post (checklist discipline applies).
- PENDING KEITH: pics/video folder path for gallery (match JSC gallery style — see
  Desktop\jsc-kadence-mockup for reference); text of the 4 GBP reviews + permission; staging push.

## Media round (2026-06-12 late) — fgs-28

- Client photo folder processed: C:\Users\keith\OneDrive\openclaw-workspace\pics\clients\FGS
  (36 named + phone pics in subfolder + 16 videos). Curated 30 imported (redundant soil-closeups
  + bland office shots excluded per Keith); 5 phone pics renamed descriptively; 1 video still
  extracted via ffmpeg (aerial earthwork; drill-rig video too low-res for stills).
- Gallery page (99) rebuilt in the JSC style: kadence/advancedgallery, land43 grid, 3-col,
  magnific lightbox, 29 photos, "REAL JOBS ONLY" note, fgs-cta band.
- Hero banners filled with MATCHED real photos on 10 pages (sinkhole->throat shot, lab->load
  frame, foundation->pile rig, etc.) + uniform 12:5 crop CSS (figure.size-large.has-custom-border).
  Services-list hover slots: 4 more filled (geotech aerial, lab, pavement, ESA). Remaining
  placeholders: GPR (no photo exists) + Cappa/Ryan headshots (240x240, client).
- Videos NOT yet used on-site (16 in folder incl. pile driving, coring, SPT rig) — candidates for
  case-study posts and service-page video embeds later.

## Blocked on Keith / client

1. `CLIENT-CONFIRMATION-CHECKLIST.md` → client (PE#, accreditations, years, projects, testimonials).
2. Photos: headshots (Dave/Ryan), lab + GPR + ESA + drilling-rig job photos, team/lab banner for
   homepage+About. 5 pages still fail verify-all on placeholder images until these land.
3. Review/publish the 6 location-page drafts (Pages → Drafts in wp-admin, or `location-pages/*.html`).
4. Decide: delete drafted starter posts + duplicate Privacy Policy draft (112) + `home ex`/`Contact Example`.
5. Deploy is Keith's call. At launch: AIOSEO redirects from `redirects.csv`, search-replace
   fsg.local→production domain, clear Pressidium cache, pre-warn Pressidium support (big-diff rollback gotcha).

## Where things live

- Local: `C:\Users\keith\Local Sites\fsg\app\public\` · `fsg.local` · LocalWP id tSVL6lQah · mysql :10023
- DB backup pre-changes: `backup-pre-truthaudit-2026-06-11.sql`
- Research highlights: DataForSEO 2026-06-11 — volumes/SERPs in plan file; live-site design tokens
  extracted from floridageotechnicalservices.com CSS (Tailwind/Astro build by "Thrasker").

## Cross-references

- JSC: paused pre-launch — `Desktop\jsc-kadence-mockup\PROJECT-STATUS.md`
- Tire Express: launch in flight — `Desktop\tire-express-workspace\PRE-LAUNCH-CHECKLIST.md`
