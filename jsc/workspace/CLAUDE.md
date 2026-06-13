# CLAUDE.md — JSC Contracting migration working folder

This folder (`Desktop\jsc-kadence-mockup\`) holds the JSC Divi→Kadence migration deliverables.

**START HERE:** read `PROJECT-STATUS.md` in this folder — it's the full handoff (all decisions,
conventions, next steps). The Benchmark shared conventions (WP + Kadence, AIOSEO, Perfmatters,
ShortPixel, Pressidium host/CDN, Cloudflare DNS-only, caching order, iOS Safari gradient bug + fix)
now **auto-load from the global `~/.claude/CLAUDE.md`** — no need to open Downloads manually.

## Quick facts
- **Local site:** `C:\Users\keith\Local Sites\jsc\app\public\` (LocalWP, still Divi)
- **Shell:** git-bash (POSIX), not PowerShell. WP-CLI works.
- **Always** `wp db export backup.sql` before any DB-touching change; `search-replace` only with `--dry-run` first, local only.
- **Never** edit WP core, Kadence parent theme, or third-party plugins. Custom code → child theme or snippet plugin.

## Files here
- `barndominium-mockup.html` — APPROVED design template (open in browser to view). Styling reference for all pages.
- `bwd-review-shortcodes.php` — review stars snippet, data filled (25 reviews, 5.0). Not yet installed in WP.
- `PROJECT-STATUS.md` — the handoff doc. Source of truth for this project.
- `docs\alex-license-CRC1332267-exp2026.pdf` — contractor license.

## Keith's working style
- Direct, technically precise. No hedging. If something won't work or can't be verified, say so upfront.
- Flag canonical/SEO-cluster decisions explicitly (he's not deep on canonicals).
- Minimal scoped changes; show diffs/plan before anything beyond trivial. Don't auto-push or deploy.
- Copy-pasteable deliverables in code blocks.
