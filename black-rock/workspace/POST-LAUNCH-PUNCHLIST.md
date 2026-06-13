# Black Rock Mortgage — Post-Launch Punch List
*Everything queued for AFTER the push. None of it blocked the launch; all of it is better done against the live site.*

## Owed by Keith
- [ ] **90-second recruiting video** → embed in /work-with-us/ hero (talking points in session log: hook → credibility → $995 math → honesty → call-me). Film when fresh.
- [ ] **HELOC comp detail** → replace the placeholder row on /work-with-us/ cost sheet (currently "HELOCs run on their own comp schedule — we'll walk it in the conversation").
- [ ] **Friendlier call-box photo** → swap into the WWU "Rather just talk it out?" box (img id=wwuKeithPic; current = formal bio shot). Casual/smiling beats the loan-closer headshot for recruiting.
- [ ] **Delete the 4 TEST leads** from Follow Up Boss (test*@test.com from the n8n test fires).
- [ ] **Verify UWM broker exclusives** (0% Down DPA + Bilt rewards, per lender list) → if real, add to WWU UWM Platinum section.

## Content (build to current quality bar)
- [ ] **Rebuild 3 finished Feb drafts** to the brm-article design system + Keith's voice (kept as drafts at launch): 2026 FHA Loan Limits (987513677), Why Mortgage Brokers Save You Money (987513679), DSCR Loans Explained (987513680). Real topics, ~1,200–1,500w each, just plain-formatted + unreviewed.
- [ ] **Lender-niche content engine** (CONTENT-PLAN-LENDER-NICHES.md): 2 pages/week from Jul 6, ITIN first. Build each from the lender's live guidelines (WebFetch), not the spreadsheet summary. Horse-farm financing = the Ocala sleeper.
- [ ] **Geo-Corp EEP rent-to-own section** → add to existing /rent-to-own-homes-in-florida/ (turns that article's traffic into closable deals). Quick win.

## Tools / features
- [ ] **Reverse-mortgage custom form** — the one real form gap (excluded from rollout by design). Audience: age 55+/62+, home value, existing balance, goal. Same n8n pipeline, source="Reverse mortgage form".
- [ ] **Agent-embeddable payment calculator** (Keith greenlit "on the radar"). Co-branded standalone widget for referral agents: "Powered by Black Rock Mortgage · NMLS #303217" backlink + "Get Pre-Approved" CTA routing to Keith's form. Backlink + co-branding + lead capture through referral partners — NOT a public SaaS product. Start with payment calc; closing-cost estimator as a strong second. Standalone HTML in /uploads/ (forms pattern) — deploys without a re-push. Hand to agents in person.

## SEO / growth (first 24–48h, from PRE-LAUNCH-CHECKLIST)
- [ ] GSC: submit sitemap, request indexing on the 9 new/rebuilt money URLs.
- [ ] Watch GSC coverage on the formerly-empty Divi pages (now have content — expect recrawl gains).
- [ ] Re-run rank pulls (baseline in seo-data\) — Day 0 of measuring the climb.
- [ ] Start BACKLINK-PLAYBOOK Tier 1 — and the embeddable calculator above feeds this directly.
- [ ] Add GMB review link to n8n post-closing flow (review-velocity engine).

## Cleanup
- [ ] Remove 6 defunct lenders from the master list (Athas, Caliber, Impac, FAM, Franklin American, BBVA).
- [ ] Category descriptions for older blog cats (Mortgage News, USDA, Manufactured) so the new category-page heroes show custom subtitles instead of the generic line.

## Facebook share button — needs App ID (Keith providing)
- Mobile reality: tapped FB button can't open Facebook's real share composer without a FB App ID (sharer.php dead-ends in app; navigator.share = generic OS sheet, which Keith rejected). Current state on all 3 sites = navigator.share native sheet (functional but generic).
- WHEN KEITH PROVIDES APP ID: wire Facebook official Share Dialog in brm-social-share.php JS — FB button -> https://www.facebook.com/dialog/share?app_id=APPID&display=popup&href=ENCODED_URL (works desktop popup + mobile). Replace the navigator.share FB branch. Deploy to BR via SFTP; give Keith same snippet for TE + JSC. Test on phone after.
- App creation: developers.facebook.com -> Create App -> Consumer/Other -> copy App ID (no review needed for basic share).
