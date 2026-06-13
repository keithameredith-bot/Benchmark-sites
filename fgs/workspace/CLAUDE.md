# CLAUDE.md — FGS (Florida Geotechnical Services) working folder

This folder holds the FGS site build-out work. **START HERE: read `PROJECT-STATUS.md` in this folder** —
it's the live handoff. Also read the Benchmark shared conventions at `C:\Users\keith\Downloads\CLAUDE.md`
(stack: WP + Kadence, AIOSEO, Perfmatters, ShortPixel, Pressidium host, Cloudflare DNS-only, caching
order, iOS Safari gradient bug + fix).

## Quick facts

- **Local WP site (LocalWP):** `C:\Users\keith\Local Sites\fsg\app\public\` — domain `fsg.local`
  (⚠️ imported into Local as "FSG", letters transposed; the client is FGS). Site must be STARTED in Local.
- **Already Kadence** — this is a BUILD-OUT, not a Divi migration.
- **Origin:** Pressidium staging export via All-in-One WP Migration (2026-06).
- **Shell for WP-CLI:** run via `C:\Users\keith\.hermes\git\bin\bash.exe` (no standard Git for Windows install):
  `& "C:\Users\keith\.hermes\git\bin\bash.exe" -c 'source /c/Users/keith/Desktop/fgs-workspace/wp-env.sh && wp ...'`
- **Backup before any DB-touching change:** `wp db export backup-<thing>-<date>.sql`

## Conventions proven on JSC + Tire Express (reuse them)

- Idempotent `wp eval-file` scripts in this folder for every change; verify before/after; Keith approves copy.
- **`wp_slash()` content in wp_update_post** — backslashes get stripped otherwise (the "2212" FAQ bug).
- `wp db query` is broken on Windows — eval-file for SQL.
- PowerShell 5.1 scripts need UTF-8 BOM, no em dashes, `@(,@())` for pair arrays.
- Menu changes: deterministic full rebuild script, never incremental item updates (they scramble).
- DataForSEO creds: `C:\Users\keith\.dataforseo-auth` (Basic auth header) — pull volumes/SERPs BEFORE
  writing titles. Plugin licenses (when Keith provides): `C:\Users\keith\.benchmark-licenses.md`.
- Verification sweep pattern: see `tire-express-workspace\verify-all.ps1` (pages 200 / one H1 /
  self-canonical / meta desc / images / 301s) — copy + adapt.
- Pressidium gotchas: server cache masks deploys (clear first, look for X-Cache/Age headers); their
  staging→live auto-rollback can trigger on big intentional content diffs (tell support it's a redesign).

## Client facts (from Benchmark root CLAUDE.md)

- Florida Geotechnical Services — geotechnical engineering.
- GBP: primary category "Geotechnical engineer," supporting: materials testing + engineering consultant.
- Known TODO from root doc: OG/iMessage link preview needs a 1200×630 OG image + `theme-color` meta (via AIOSEO).

## Keith's working style

- Direct, technically precise, no hedging. Minimal scoped changes; show plan before non-trivial copy changes.
- Flag canonical/SEO-cluster decisions explicitly. Don't deploy — that's Keith's call.
