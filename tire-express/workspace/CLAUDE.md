# CLAUDE.md — Tire Express (Ocala tire shop + auto repair)

**START HERE: read `PROJECT-STATUS.md` in this folder** — it's the live handoff (very detailed).
Shared Benchmark conventions (WP+Kadence stack, Perfmatters playbook, caching order, iOS gradient
fix, SEO/canonical rules) auto-load from the global `~/.claude/CLAUDE.md` — don't re-read Downloads.

## Quick facts
- **Local WP (LocalWP):** `C:\Users\keith\Local Sites\tire-express\app\public\` — domain `tire-express.local`
  (site id 1FkoTj42H; START it in Local; mysql port 10005). **Must be running for WP-CLI.**
- **Live:** tireexpressandservice.com (Pressidium prod) · dev: tireexpress-dev.onpressidium.com
- **Theme: plain `kadence`** active. Divi + `ignition-divi-child` are INACTIVE leftovers — this WAS a
  mid-flight Divi→Kadence migration; all pages have since been rebuilt in Kadence. No child theme →
  custom code lives in mu-plugin `wp-content/mu-plugins/tire-express-custom.php`.
- **WP-CLI:** `& "C:\Users\keith\.hermes\git\bin\bash.exe" -c 'source ~/Desktop/tire-express-workspace/wp-env.sh && wp ...'`
- **Graphics:** `OneDrive\Documents\Graphics\Tire Express\`
- **Prod deploy (no child theme):** mu-plugin pushed via **SFTP** (creds `~\.pressidium-sftp.txt`, user
  `tireexpress-prod-claude`); content/authors via REST. mu-plugins are files — NOT REST-pushable.
  After any prod change: **Keith purges Pressidium cache.**
- **Backup before DB change:** `wp db export backup-<thing>-<date>.sql`

## Page-build pattern (proven here)
- Hand-coded `te-np` template: body HTML in `page-<slug>.html` + shared `te-np.css`, applied by
  `apply-te-pages.php` (edit file → rerun; sets Kadence page meta + AIOSEO title/desc). Idempotent.
- **Theme hides page titles globally → every page needs its own H1 in content.**
- Menus: site header uses the **'Primary' menu (id 91)**; `main_menu` (77) is a dead Divi-era menu —
  ignore it. Rebuild nav deterministically (full delete+recreate; item-updates scramble the tree).

## Gotchas specific to TE
- **`wp_slash()` on all content writes** — without it backslashes get stripped (the "2212" minus-sign
  CSS bug: `content:"\2212"` lost its escape). Direct `$wpdb` update also avoids the mangling.
- **No BOM in CSS files** — a PowerShell UTF-8 BOM broke the `@import` and killed brand fonts. Strip it.
- Schema: businessType **TireShop** (not generic LocalBusiness); Service schema on all 14 service pages
  via the mu-plugin. No FAQPage schema (Google killed FAQ rich results for non-gov/health Aug 2023).
- Reviews: Trustindex (`wp-reviews`), `[trustindex]` shortcode renders inside `wp:html`.
- Blog: Ben Bishop is post author; blog hero + share bar + author box all in the mu-plugin (inline styles).

## Client facts
- Auto/tire shop, Ocala FL. Owner: **Ben Bishop**. 50+ years. Sells/repairs tires, alignments, brakes,
  A/C, batteries (free testing), oil, tune-ups, CV axles, fleet accounts, lift-kit install, up to 38" tires.
- Voice: honest, no-corporate, call-first shop (no contact form by Keith's call). Prices in page titles
  where they exist (oil-change house style). Confirmed prices: brakes $350/axle, A/C from $139.95,
  coolant flush $89.95.

## Keith's working style
- Direct, technically precise, no hedging. Minimal scoped changes; show plan before non-trivial copy.
- Don't deploy without showing the plan. Keith approves copy. Don't fabricate prices/specs — ask Ben.
