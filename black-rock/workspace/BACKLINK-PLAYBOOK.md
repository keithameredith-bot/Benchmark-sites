# Black Rock Mortgage — Backlink & AI-Citation Playbook
*Data: DataForSEO Backlinks + LLM APIs, 2026-06-10/11. Raw files in `seo-data\`.*

## Where you stand
- **117 referring domains, but only 4 carry any authority.** Best links: flmortgagebank.com (rank 142 — your old brand?), allfloridahomesrealty.com (76), aicavo.com (40), wioai.com (23). The rest is scraper/junk noise.
- 53% of all links are nofollow. Anchor profile is polluted with old brands ("Coast 2 Coast Lending", "flmortgagebank.com") and some spam (telegram link networks).
- Competitor benchmark: makefloridayourhome.com has a deep profile built on guest posts, owned microsites, and resource listings — 56 quality domains link to your competitors but not you (full list: run `php bl-gap.php`).

## 🍎 Low-hanging fruit — do these next week, in order

### Tier 1: Free, fast, high-relevance (1-2 hours each)
1. **lendersa.com** — lender directory that links to BOTH flamortgagefirm.com and ocalamortgageloans.com. Create your broker listing.
2. **Old-brand redirect audit** — flmortgagebank.com has linked to you with 21 links since 2019, and "Coast 2 Coast Lending" anchors exist. If you own/owned those domains, make sure both 301 to blackrockmortgage.com domain-wide. This is reclaiming authority you already earned.
3. **floridahousing.org participating-lender listings** — you offer Hometown Heroes; make sure you appear on every Florida Housing approved/participating lender list. This domain was cited by LLMs 6 times in our test — links AND AI citations.
4. **BBB profile** (accreditation if not already) — bbb.org was cited by ChatGPT/Perplexity for "best mortgage brokers in Ocala". Cheap AI visibility.
5. **Ocala/Marion locals**: Ocala Chamber (CEP) member listing, Ocala/Marion REALTOR association affiliate membership, Marion County builder associations. Your local competitor's best links are exactly these.
6. **Realtor partner links** — allfloridahomesrealty.com (rank 76) already links to you as a preferred lender. Replicate with every agent/brokerage you close with: "preferred lender" page links. Aim for 5 more this month.

### Tier 2: Cheap content placements (the exact network your competitor uses)
makefloridayourhome.com built links via guest posts on: **techbullion.com, justwebworld.com, thriveinsider.com, chartsattack.com, militaryparenting.org** (VA-loan resource link), ontoplist.com. Pitch the same sites — you have genuinely link-worthy assets now (USDA turn-times hotline guide, loan limits by county, Hometown Heroes guide).

### Tier 3: Expert-quote links (free, ongoing, 30 min/week)
Sign up for **Connectively (ex-HARO), Qwoted, SourceBottle** as a "Florida mortgage broker / NMLS #303217" source. Mortgage-rate and housing-market queries are constant; landing 1-2 quotes/month in finance press compounds into exactly the authority profile you lack.

### Tier 4: Strategy worth discussing
- Your competitor runs **owned microsites** (floridahometownheroesloanprogram.com ranks #6 for the program AND feeds them links/AI citations; also homesweethomeprogram.com, 100percentfhaloanprogram.com, miamidadedownpaymentassistance.com). Working strategy, but gray-hat and a maintenance burden — strong dedicated pages + GBP often beat it long-term. Your call; happy to discuss.
- **Skip**: paying for the rank-0 junk directories; disavowing the telegram spam (Google ignores it; disavow only if you get a manual action).

## 🤖 AI-citation strategy (the open field)
**Finding: neither you nor any FL broker competitor has LLM dataset mentions — but ChatGPT ALREADY cites blackrockmortgage.com for "best mortgage brokers in Ocala Florida", pulled from your Google Business Profile (4.9★, 188 reviews shown in answer).**

What drives AI answers in your niche, per our 12-query test:
1. **GBP reviews → local "best broker" answers.** Keep review velocity up; respond to all. This is already working — protect it.
2. **Fact-dense, specific pages → informational citations.** Perplexity cited a competitor's blog for USDA turn times with vague info. Your rebuilt turn-times page (statewide queue + the 352-338-3421 hotline) is precisely the content LLMs cite. Same logic: loan limits by county, USDA income limits, Hometown Heroes funding status.
3. **Authority listings get cited**: floridahousing.org (6×), bbb.org, triadfs/21st (mfg). Get ON the pages LLMs read (participating-lender lists, BBB, directories above).
4. Technical: robots.txt clean (no AI-bot blocks ✓), llms.txt live ✓ (AIOSEO). Keep both.
5. Re-test quarterly with `pull-llm.ps1` (~$0.35/run) to track citation share.

## Content shipped (staging) supporting all this
- `/cheapest-places-to-buy-a-house-in-florida/` — targets ~50k/mo combined cluster
- `/florida-first-time-home-buyer-grants/` — targets 8,100/mo + long tail
- Rebuilt `/florida-usda-turn-times/` — the AI-citation play
Remaining from gap list: FHA requirements FL, FHA limits FL, rent-to-own FL, requirements-to-buy FL, property tax exemptions.
