# FGS — Staging Push Runbook (AIO-WPM export -> Pressidium staging)

## Export timing check (2026-06-12)
Final pre-export prep landed at the last minute: junk trashed (home ex / Contact Example /
privacy dup / 7 starter posts) + **Search Engines Discouraged ON** (blog_public=0).
**If your export started BEFORE that, re-export — takes a minute and matters** (staging must
not be indexable, and the client shouldn't see "Hello world" in the pages list).

## Import on Pressidium staging
1. Staging wp-admin -> All-in-One WP Migration -> Import -> upload the .wpress.
2. AIO-WPM rewrites fsg.local -> staging URL automatically; all our internal links are relative, so they're safe.
3. After import, log back in (creds become the LOCAL site's admins — incl. new users
   ryan-townsend / dave-cappa, random passwords; you log in with your own admin).
4. **Settings -> Permalinks -> Save** (flush rewrites; llms.txt + sitemap depend on it).
5. Clear Pressidium server cache (their dashboard) before judging anything.
6. Verify Settings -> Reading still shows "Discourage search engines" CHECKED on staging.
7. Sweep: `.\verify-all.ps1 -BASE https://<staging-url>` (expect og/theme-color OK, pages 200).
   Add `-IncludeDrafts` only after location pages are published.

## What the client will see (and won't)
- SEES: full redesign, blog (2 posts), gallery (33 photos), free-quote funnel, mission page.
- WON'T SEE (drafts, need Keith approval first): 6 location pages, Reviews page, Blog index is live.
- WILL SEE the unverified claims (P.E. #58334, 45+/75+ years, Cappa) — that's intentional:
  client review IS the confirmation step. Walk them through CLIENT-CONFIRMATION-CHECKLIST.md.

## At PRODUCTION launch (not staging) — do not skip
- [ ] Flip Settings -> Reading -> ALLOW search engines (blog_public=1)
- [ ] Apply redirects.csv in AIOSEO Redirects
- [ ] Deactivate the two AIO-WPM plugins again after the push
- [ ] Pre-warn Pressidium support: intentional redesign (staging->live auto-rollback gotcha)
- [ ] Client checklist items confirmed (PE# is the gate)
- [ ] GSC: submit sitemap, verify llms.txt
