# CLAUDE.md — Black Rock Mortgage

Read this first, then **PROJECT-STATUS.md** (the running session log). Shared stack conventions: `C:\Users\keith\Downloads\CLAUDE.md`. Keep this file LEAN — every line loads into context.

## What this is
Black Rock Mortgage — Florida mortgage broker, division of Coast 2 Coast Mortgage (NMLS #376205; Keith Meredith NMLS #303217), Ocala FL. **LAUNCHED 2026-06-12.** Goal: best mortgage website in Florida (rankings, UX, AI citations).
- **Live:** https://www.blackrockmortgage.com (Pressidium host + CDN). **Domain-type GSC property** → submit full sitemap URL `https://www.blackrockmortgage.com/sitemap.xml`.
- **Local (sandbox):** LocalWP `black-rock-mortgage`, http://black-rock-mortgage.local, MySQL port 10017 (root/root, db `local`), prefix `wp_`.
- Stack: Kadence + Kadence Pro/Blocks Pro, AIOSEO Pro, Perfmatters, ShortPixel, WPCode. Lead pipeline: multi-step forms → n8n → Follow Up Boss + Telegram.

## Post-launch workflow (CRITICAL)
**Live is the source of truth now. Local is a sandbox.** NEVER do a full local→live AI1WM re-push again (wipes live state). To change live:
- **Content (pages/posts/menus/meta):** REST API. Creds `C:\Users\keith\.black-rock-rest-auth.txt` (user `mortgageadmin`, app password; admin). Base `https://www.blackrockmortgage.com/wp-json`.
- **Files (mu-plugins, theme, form HTML, images):** SFTP. Creds in `C:\Users\keith\.pressidium-sftp.txt` ([black-rock production]). Host `sftp.blackrckmtg.onpressidium.com:11520`, user `blackrckmtg-prod-claude`, remote-root `blackrckmtg-www` (symlink at login dir). Client `C:\Users\keith\.tools\psftp.exe`.
- **Build/test on local first** (screenshot via headless Edge), then push. Keep local in parity after live edits.

## Access gotchas (learned the hard way)
- **SFTP:** psftp HANGS on the host-key prompt; piping "y" does NOT work. Pass the key explicitly: `-hostkey "SHA256:TJd9y2ESJHuHoyct2sgcL6WKsV9bVaTgjIaeeG+oXLI" -batch` (SAME key across all 3 Pressidium sites). `ls` lists dirs only, not single files.
- **Pressidium PAGE cache** serves stale HTML/inline-JS/images after ANY push or file deploy. Changes are in the DB/origin immediately but won't *render* until cache clears — Keith clears via Pressidium dashboard, or it expires. Verify via REST `?context=edit` raw content (the truth), not the cached render.
- **REST push from local → live carries `.local` URLs.** ALWAYS rewrite `black-rock-mortgage.local` → `www.blackrockmortgage.com` before PUTting content. (iframe/img/link srcs in content should be relative where possible.)
- **CDN caches images by URL.** Replacing a file in place needs a cache clear to propagate.

## WP-CLI / scripting gotchas (local)
- Run wp via git-bash: `source ~/Desktop/black-rock-workspace/wp-env.sh`. Invoke phar directly for args with spaces (`wp.bat` mangles them). **Inline `wp eval` quoting fails → always use `wp eval-file`.**
- **CSS glyphs (`content:"\XXXX"`):** `wp_insert_post`/`wp_update_post` strip backslashes → use `$wpdb->update` for content with CSS glyphs, or re-escape after. Same bug produces literal `\$` leaks — sweep `LIKE '%\\\\$%'` and `str_replace('\\$','$')`.
- **PowerShell 5.1:** emojis in scripts = parser error → build via `[char]::ConvertFromUtf32(0x...)`. `$home`/`$input` are read-only (rename vars). Write files UTF-8 no-BOM: `[IO.File]::WriteAllText($p,$c,(New-Object System.Text.UTF8Encoding($false)))`. Avoid `2>&1` on native exes (wraps stderr as errors).
- Backups: every content-mutating eval-file adds a `_brm_*_backup` postmeta before editing. Idempotent + rerunnable.

## Conversion-form rules
- Forms are standalone HTML in `/wp-content/uploads/forms/` (preapproval, manufactured, construction, va-construction, contact, recruiting), iframed with `?v=` cache-bust + postMessage height sync (`{brm:'height',h}`). **Every embed needs the height-sync listener** or steps clip (get-pre-approved bug). Honeypot + timing bot checks. n8n webhooks: lead forms → `/webhook/brm-preapproval`, recruiting → `/webhook/brm-recruiting`.
- **Never lazy-load the form iframe.** Excluded in Perfmatters (`lazyload.lazy_loading_exclusions` array += `uploads/forms/` + iframe ids). Never lazy-load the LCP hero either.
- The my1003app portal is external → opens new tab (handled by `brm-external-links.php` mu-plugin filter + `target=_blank` on form arrive buttons).

## Design system
Teal #049F82 (dark #037a64), gold #F5A524, ink #0f2e2d/#353535, accent #5dcaa5. Rubik headings / Karla body. Rounded everywhere (cards 14–18px, buttons 6px). Reusable: `article-css.html` (.brm-article kit), `hero-fn.php` (brm_hero_html), brm-prog-cta CTA block. Heroes teal rounded (homepage full-width). Inline SVG line icons (Lucide), not emoji, for UI.

## mu-plugins (custom, deployable via SFTP)
`brm-social-share.php` (gold share buttons; excludes conversion pages by slug; FB uses navigator.share on mobile — App-ID share dialog pending), `brm-blog-hero.php` (teal blog/category archive hero), `brm-external-links.php` (my1003app → new tab).

## n8n (API key `C:\Users\keith\.n8n-api.txt`)
`Black Rock Lead -FUB +Telegram` (gynQw95S8WbHcyGm) + `BRM Recruiting - LO Leads` (hVmQMclZV7JnVQ9z). Both use a universal "Format lead" Code node → labeled summary → Telegram + FUB. Any form's fields self-map; recruits tagged `LO Recruit` (fenced from borrowers).

## Key page IDs
homepage 38, loan-programs 64, get-pre-approved 74, become-a-mortgage-broker 18179 (recruiting; was work-with-us), spec-construction 987515486, FHA 56, USDA 42, VA 88, conventional 77, jumbo 18068, DSCR 987514055, physician 987515436, reviews 987515438, states 987515440, contact 987513017, about 70, keith 164.

## Workspace files
`wp-env.sh` (git-bash WP env), `dfs-auth.txt`+`dfs.ps1` (DataForSEO; Labs=US-only, SERP FL=21142/Ocala=1015141, one task/request). PROJECT-STATUS.md (log, read first), POST-LAUNCH-PUNCHLIST.md, GSC-INDEXING-LIST.md, CONTENT-PLAN-LENDER-NICHES.md (niche page pipeline from 224-lender list — build each from the lender's live guidelines via WebFetch, 2/wk, no city doorways = anti-mill), EDITORIAL-CALENDAR.md, BACKLINK-PLAYBOOK.md.
