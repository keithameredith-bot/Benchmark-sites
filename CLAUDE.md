# CLAUDE.md — Benchmark Web Development / WordPress Sites

This file is the ground truth for working on these sites locally. Read it before touching anything. Keep it lean — every line here loads into context at the start of each session.

## What this directory is

Local working copies of client WordPress sites managed by Benchmark Web Development (Keith Meredith, Ocala FL). Each client lives in its own subfolder, all on **WordPress + Kadence theme**.

## Who I'm working with / how to respond

- Give **direct, technically precise** answers. No diplomatic softening, no filler, no hedging.
- When two sources/tools conflict (e.g. schema advice), **do not synthesize a middle ground** — identify which one is correct and explain *why*.
- I am **not deeply familiar with canonical tags**. Whenever cluster/SEO work touches canonicalization, **flag it explicitly** (see SEO rules below).
- Make **minimal, scoped changes**. Don't refactor unrelated code. Don't add excessive comments.
- When unsure between two approaches, explain both and let me choose.

## Tech stack (shared across all WP sites)

- **WordPress** + **Kadence** theme (block-based, Row Layouts)
- **AIOSEO** (AIOSEO Pro on some sites — handles schema, `llms.txt`, sitemaps)
- **Perfmatters** (performance: lazy load, script management, local Google Fonts, fetchpriority)
- **ShortPixel** (image optimization, WebP pipeline)
- **Pressidium** — managed WordPress host **and CDN**. Has its own server-side page cache and staging environments (separate from WP/Perfmatters caching). Deploy/staging-to-production goes through the Pressidium dashboard.
- **Cloudflare** — **DNS only** (not CDN, not caching).
- Automation lives in **n8n** at `benchmarkwebd.app.n8n.cloud` (not in this repo)

## Local development — EDIT THIS TO MATCH YOUR SETUP

> Assumed: **LocalWP (Local by Flywheel)**. If you use DDEV / wp-env / Docker, replace this section.

- Sites run under LocalWP; site root is `app/public/` inside each Local site folder.
- WP-CLI (works regardless of local tool):
  - `wp plugin list` / `wp theme list`
  - `wp search-replace 'oldurl' 'newurl' --dry-run` (always dry-run first)
  - `wp cache flush`
  - `wp db export backup.sql` before any DB-touching change
- **Never** run `search-replace` or DB imports against anything but the local copy.

## What IS and ISN'T version controlled

**In git:** the child theme, any custom plugins/snippets, `mu-plugins`, this CLAUDE.md.

**NOT in git (gitignore these):** WordPress core, the Kadence parent theme, `/wp-content/uploads/`, `wp-config.php`, any `.sql` dump, `.env`, plugin folders we didn't author.

Never commit secrets, API keys, or DB credentials.

## Where customizations actually live (IMPORTANT — read before editing CSS/config)

A lot of these sites are configured in the **database and admin UI, not in theme files**. Before assuming CSS or behavior lives in a file, know that:

- **Custom CSS** is usually in **Appearance → Customize → Additional CSS**, not in the theme stylesheet.
- **Performance config** (script delay, lazy-load exclusions, font loading) is in **Perfmatters settings**, not in code.
- **Schema, meta, redirects** are mostly managed by **AIOSEO**, not hardcoded — **except on Black Rock**, where some schema is injected via **custom WP code** (theme/functions/snippet). On the mortgage site, schema lives in *both* places, so check AIOSEO **and** the custom code before adding or editing any schema.
- Layout is built with **Kadence blocks** stored in post content (DB), not template files.

So: if you can't find a style/rule in the files, it's almost certainly in the Customizer, Perfmatters, or AIOSEO — say so rather than recreating it in a theme file.

## Coding conventions

- All custom PHP/CSS/JS goes in the **child theme** or a **custom snippet plugin** — never edit core, the parent theme, or third-party plugins (overwritten on update).
- Follow WordPress coding standards. Enqueue scripts/styles properly; don't inline.
- Prefer Kadence-native blocks/settings over custom code when the result is equivalent.

## Git / commits

- One logical change per commit. No 40-file monster commits.
- Clear messages: `client: short imperative summary`.
- Don't auto-push. Show me the diff/plan for anything beyond trivial.

## SEO & schema rules (apply to every site)

### Canonical tags — FLAG THESE FOR ME
- Every page in a content cluster is **self-canonical** (canonical points to itself).
- **Never** canonicalize a local/spoke page (e.g. `/ocala-usda-loans/`) to the statewide pillar (e.g. `/florida-usda-loans/`) — it kills the spoke's ability to rank.
- Mental model: **canonical = "this is the same page"**, **internal link = "this is a related page."**
- Any time we build pillar-and-spoke clusters, remind me to verify each page is self-canonical.

### Schema stack (mortgage/local-business sites)
- Loan/product pages: `FinancialProduct` / `LoanOrCredit`
- Sitewide: `MortgageBroker` / `LocalBusiness`
- Where applicable: `FAQPage`
- All inner pages: `BreadcrumbList`
- Watch for **`@id` collisions** between custom schema blocks and AIOSEO's auto-generated Organization block — this has bitten Black Rock before.

## Performance playbook (run at EVERY launch — proven on Tire Express, 64→82 mobile in one pass)

1. **Fonts: never `@import` in CSS.** Use parallel `<link rel=preconnect>` + stylesheet link with `display=swap`,
   then let Perfmatters Local Google Fonts self-host them. (@import = serial render-blocking chain, the #1 LCP killer.)
2. **Hero images: two sizes + preload.** Desktop ~1920w WebP (~180KB) and a mobile ~768w variant (~30KB),
   served via CSS media query; preload both with `device`-targeted priority-high entries in Perfmatters.
3. **Lazy-load every below-fold content image** (`loading="lazy" decoding="async"` in the markup — don't rely
   solely on Perfmatters' exclude-leading heuristic; a 400KB eager image below the fold steals hero bandwidth).
4. **Perfmatters: import the baseline** at `C:\Users\keith\.perfmatters-baseline.json` (exported from Black Rock,
   the reference config) and adapt per site: swap the two preload URLs + lazy-exclusion URLs to the site's heroes;
   empty/adjust `delay_js_exclusions` (BRM's excludes its mortgage form). ⚠️ Sites with WPForms (or any
   jQuery-dependent form) must exclude BOTH `wpforms` AND `jquery` — excluding only the form script leaves
   it waiting on delayed jQuery (admin-only WPForms JS warning; late-binding validation for first-tap users).
   The Kadence RUCSS exclusions are stack-generic — keep them. After import: purge Pressidium cache, CLICK THROUGH the site (footer, mobile menu,
   blog cards — RUCSS can strip styles; add selectors to exclusions if anything breaks), then PageSpeed ×2-3.
5. **Target: 80+ mobile.** That wins locally; past that is diminishing returns — ship content instead.

## Known gotchas

### Caching layers (when a change doesn't show on the live site)
Changes can be masked by multiple caches. Clear in this order: **Pressidium server-side cache** (via Pressidium dashboard — this is the usual culprit on production), then **Perfmatters/WP cache**, then browser/mobile (close the tab fully). Cloudflare is DNS only, so it won't cache page content.

### Kadence iOS Safari gradient overlay paint bug
**Symptom:** a Kadence Row Layout with a gradient Background Overlay doesn't render on mobile (iOS Safari / iOS Chrome) until the user scrolls one pixel, then "pops in." Desktop is fine. None of the standard paint-trigger CSS tricks (translateZ, will-change, opacity hacks, blend-mode) fix it.

**Fix:** bypass Kadence's broken overlay entirely with a `::after` pseudo-element gradient. Paste into **Appearance → Customize → Additional CSS**:

```css
@media (max-width: 1024px) {
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) .kt-row-layout-overlay {
    display: none !important;
  }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) { position: relative; }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient)::after {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.15) 100%);
    pointer-events: none; z-index: 1;
  }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) > .kt-row-column-wrap,
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) > .kb-row-layout-wrap {
    position: relative; z-index: 2;
  }
}
```
The `:has(.kt-row-overlay-gradient)` scoping means only rows that originally had a gradient overlay are touched. Apply preemptively on any new Kadence site using hero gradients — it's purely additive. Hard-refresh on mobile (close the tab fully) to test.

## Per-client quick reference

### Black Rock Mortgage — `blackrockmortgage.com`
- Mortgage loan origination. Division of Coast 2 Coast Mortgage, **NMLS #303217**. Ocala FL, 1552 E Fort King St.
- **Brand colors:** teal `#049F82`, gold `#F5A524`, dark gray `#353535`.
- Migrated Divi → Kadence. Watch for migration leftovers (e.g. a duplicate `/home` was resolved with a 301).
- Lead capture: multi-step pre-approval form → n8n → Follow Up Boss (`/v1/events`) + Telegram. TRID-compliant, **no SSN** collected. CTAs standardized: "See My Options" / "Apply Now."
- Compliance: NMLS ID must be present; TCPA — SMS requires explicit consent checkbox + STOP opt-out.
- **Schema is split:** some is custom code in WP (e.g. `MortgageBroker`, `hasCredential`), some is auto-generated by AIOSEO. The two have collided on `@id` before — when editing schema, audit both sources and keep `@id` values from clashing.

### JSC Contracting — `jscfla.com`
- Marine / general contracting. Active build-out: "Floor Plans We Build" page (blueprint aesthetic), barndominium lead-magnet/affiliate angle.

### Tire Express
- Auto / tire shop. SEO + web.

### Florida Geotechnical Services (FGS)
- WordPress + Kadence (same stack/conventions as the other sites).
- GBP: primary category "Geotechnical engineer," supporting stack of materials testing + engineering consultant.
- OG/iMessage link preview needs a 1200×630 OG image + `theme-color` meta (configured via the SEO plugin).

## Things NOT to do

- Don't edit WordPress core, the Kadence parent theme, or third-party plugins.
- Don't run destructive WP-CLI (`db import`, `search-replace` without `--dry-run`, `db reset`) without an explicit go-ahead and a fresh backup.
- Don't push to remote or deploy to live without showing me the plan first.
- Don't recreate in code something that already lives in the Customizer/Perfmatters/AIOSEO — point me to it instead.
- Don't canonicalize spoke pages to pillars (see canonical rules).

## Scaling this file

This is the root file. As each client folder grows, split client-specific detail into a `CLAUDE.md` inside that folder — Claude Code loads it only when you work in that directory, keeping context lean. Use `~/.claude/CLAUDE.md` for anything that should apply across *all* your projects, and `CLAUDE.local.md` (gitignored) for personal/machine-specific notes.
