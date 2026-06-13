# JSC Migration — Pre-Launch Checklist (Pressidium staging → live)

> Deploy is Keith's call. Work top to bottom; don't skip the re-verification steps — local passing ≠ staging passing.

## Before export (local)

- [ ] Keith final visual review of every page (esp. home + today's changes: contact map, dock page rebuild w/ repair section + FAQ, author bio boxes on posts)
- [ ] Pending content from Alex (none block launch): FAQ build-timeline answer, **dock + container cost numbers** (for the two cost blog posts), container home pics, more seawall photos
- [x] ~~AIOSEO → Local SEO~~ DONE 2026-06-10: businessType GeneralContractor, NAP, hours (Sat/Sun closed), areaServed, hasCredential = Certified RESIDENTIAL Contractor CRC1332267 via schema filter
- [ ] WPCode plugin (installed 2026-06-10, unused — all custom code is in kadence-child): either delete before export or keep empty deliberately
- [ ] `wp db export` final local backup

## Migrate to staging

- [ ] All-in-One WP Migration export (local) → import on Pressidium **staging**
- [ ] Search-replace `jsc.local` → staging domain (AIO usually handles; verify with `wp option get home`)
- [ ] **Verify serialized URLs survived the search-replace:** author bio box on a blog post (EEAT authorImage `alex-400.webp` + "See Full Bio" → `/our-team/` — stored in serialized user meta), AIOSEO Local image, contact-page map renders
- [ ] Re-activate license keys on staging: Kadence Pro, Kadence Blocks Pro (key in Keith's Kadence account), AIOSEO Pro, WPForms, ShortPixel
- [ ] **ShortPixel**: bulk-optimize the media library (the 21 images >2MB especially)
- [ ] **Clear Pressidium server cache before every test** (caching order matters — see Benchmark root CLAUDE.md)

## Verify on staging (repeat of local sweep)

- [ ] Run `verify-all.sh` with BASE changed to the staging URL (from any machine with bash; or spot-check manually)
- [ ] 301s: `/central-florida-fence-builder-2/`, `/blog/dock-builder-near-me/`, `/marine-construction-gallery/`
- [ ] **Rich Results Test** (staging is public): barndominium page → expect Service + FAQPage + Breadcrumbs; **dock page → Service + FAQPage**; cost blog post → BlogPosting + FAQPage; home → GeneralContractor w/ hours + hasCredential; no duplicate org nodes (`schema-audit.ps1` with staging URL does all of this)
- [ ] Contact form: submit a test → confirm email arrives + lands on /thank-you/ (which must stay noindex)
- [ ] Trustindex reviews widget renders on /our-reviews/ and home
- [ ] PageSpeed Insights: mobile + desktop on home, barndominium, dock pages (Perfmatters on; check hero LCP)
- [ ] Mobile pass on a real phone: hero gradient legibility (iOS Safari — the `::after` pattern should hold), menu drawer, click-to-call button, photo grid placement high on page
- [ ] AIOSEO sitemap: drafted pages (dock-near-me post, marine gallery) absent; container homes page present

## Launch (staging → live)

- [ ] Lowest-risk window (their traffic is daytime weekday-heavy; deploy evening)
- [ ] Pressidium staging→live push (or AIO export/import to live)
- [ ] Search-replace staging domain → `jscfla.com`; verify `wp option get home`
- [ ] Clear Pressidium cache + Cloudflare cache (DNS-only per stack, but purge anyway if proxied assets exist)
- [ ] Re-run the 301 checks + 5-page spot check ON LIVE immediately
- [ ] Google Search Console: submit sitemap, request indexing for barndominium page + container homes page + restored blog posts
- [ ] Watch GSC coverage + rankings for the barndominium page daily for 2 weeks (it's the #1–2 ranker being protected)

## Post-launch (first week)

- [ ] Alex license renewal nudge — **CRC1332267 expires Aug 31, 2026**
- [ ] **Create a WP application password on live** (Users → Profile → Application Passwords) for Claude's REST content-push flow → store next to `~/.dataforseo-auth`; test with a harmless draft. New content flow: build local → verify → REST-push as draft → Keith publishes. NO full DB pushes after launch, ever.
- [ ] GBP: confirm website link works, add the container homes page as a service/product, upload the new photos
- [ ] Set up JSC YouTube channel; upload the 6 videos; embed on matching pages (Perfmatters facade) — transcripts via Whisper (to be set up)
- [x] ~~DataForSEO credentials~~ DONE 2026-06-10 (`~/.dataforseo-auth`) — dock push applied; next plays: dock cost post (needs Alex), seawall page treatment, content wheel (PROJECT-STATUS roadmap)
- [ ] Reconcile bwd review shortcode naming with Tire Express implementation (long-standing TODO)
