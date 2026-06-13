<?php
// Month-1 calendar: affordability guide + program comparison. Full design system, Keith's voice,
// scheduled to continue the 2/week stagger (Jul 2, Jul 6). AIOSEO via UPDATE-auto-row (not insert).
global $wpdb;
$author = (int) $wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID = 623");
if (!$author) $author = 1;
$css = file_get_contents(__DIR__ . '/article-css.html');
$bio = '/wp-content/uploads/2026/04/Keith-Meredith-division-president-of-black-rock-mortgage.webp';

$articles = array();

// ============================================================ 1. AFFORDABILITY
$articles[] = array(
  'slug' => 'how-much-house-can-i-afford-in-florida',
  'title' => 'How Much House Can I Afford in Florida? The Real Math (2026)',
  'date' => '2026-07-02 09:00:00',
  'seo_title' => 'How Much House Can I Afford in Florida? (2026) — The Real Math',
  'seo_desc' => 'The actual math lenders use in Florida: the two debt ratios, income needed for a $200K-$500K home at 2026 rates, and the Florida traps (taxes, insurance) that change the answer.',
  'content' => <<<HTML
<!-- wp:html -->
<div class="brm-article">
<p style="font-size:13.5px;color:#5b6b6b;margin:0 0 18px;font-family:Karla,sans-serif;">Last updated July 2, 2026 &middot; Written by Keith Meredith, Florida mortgage broker &middot; NMLS #303217</p>
<div class="brm-callout" style="margin-top:0;"><span class="tag">Quick answer</span><p>At mid-2026 rates, a Florida household with modest debts can roughly afford: a <strong>\$200,000 home on about \$50,000&ndash;\$60,000</strong> of income, a <strong>\$300,000 home on \$70,000&ndash;\$85,000</strong>, a <strong>\$400,000 home on \$95,000&ndash;\$110,000</strong>, and a <strong>\$500,000 home on \$120,000&ndash;\$135,000</strong> &mdash; using FHA's 3.5% down and counting Florida's full taxes and insurance. Your debts, county, and program move these numbers, which is exactly what a free pre-approval pins down.</p></div>

<p class="brm-lead">Every affordability article gives you a calculator and a shrug. I'm going to show you the actual math lenders use &mdash; the same two ratios my underwriters apply &mdash; plus the Florida-specific traps that make our state different. By the end you'll be able to roughly pre-approve yourself on a napkin.</p>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">2 Ratios</div><div class="l">decide everything</div><div class="s">Front-end (~31%) and back-end (~45%) of gross income</div></div>
  <div class="brm-stat"><div class="n">PITI</div><div class="l">not just the loan</div><div class="s">Taxes + insurance are a bigger slice in Florida than most states</div></div>
  <div class="brm-stat"><div class="n">50%+</div><div class="l">strong files stretch</div><div class="s">High score and reserves can push the back-end past 50%</div></div>
</div>

<h2>The Two Ratios &mdash; How Lenders Actually Decide</h2>
<p>Pre-approvals aren't pulled out of a hat. They come from two numbers:</p>
<ul>
<li><strong>Front-end ratio:</strong> your full house payment (principal, interest, taxes, insurance, plus HOA if any) divided by your gross monthly income. Guideline ballpark: ~31%.</li>
<li><strong>Back-end ratio:</strong> the house payment <em>plus every other monthly debt on your credit report</em> &mdash; car payments, minimum card payments, student loans, child support. Ballpark: ~45%, and strong files (good score, reserves) can stretch past 50%, especially on <a href="/fha-home-mortgage-loan/">FHA</a>.</li>
</ul>
<div class="brm-callout"><span class="tag">Napkin version</span><p>Take your gross monthly income, multiply by 0.45, subtract your monthly debts &mdash; that's roughly your maximum full house payment. Earning \$6,000/month with a \$450 car payment? \$6,000 &times; 0.45 = \$2,700 &minus; \$450 = <strong>about \$2,250/month of house</strong>. Now let's turn payments into purchase prices.</p></div>

<h2>Income Needed by Price &mdash; the 2026 Florida Table</h2>
<p>Real math at mid-2026 rates (~6.75%, 30-year fixed), FHA 3.5% down, typical inland-Florida taxes and insurance, modest existing debts. Coastal insurance pushes these up; zero debts pulls them down.</p>
<div class="brm-tablewrap"><table class="brm-table">
<thead><tr><th>Home price</th><th>Est. full payment (PITI+MIP)</th><th>Household income needed</th></tr></thead>
<tbody>
<tr><td>\$150,000</td><td>~\$1,300/mo</td><td class="yes">~\$40,000&ndash;\$48,000</td></tr>
<tr><td>\$200,000</td><td>~\$1,700/mo</td><td class="yes">~\$50,000&ndash;\$60,000</td></tr>
<tr><td>\$300,000</td><td>~\$2,500/mo</td><td class="yes">~\$70,000&ndash;\$85,000</td></tr>
<tr><td>\$400,000</td><td>~\$3,300/mo</td><td class="yes">~\$95,000&ndash;\$110,000</td></tr>
<tr><td>\$500,000</td><td>~\$4,100/mo</td><td class="yes">~\$120,000&ndash;\$135,000</td></tr>
</tbody></table></div>
<p>Two big levers move every row: <strong>\$0-down programs</strong> (<a href="/florida-usda-mortgage/">USDA</a> and <a href="/va-home-mortgage/">VA</a> drop the cash needed, not the income needed) and <strong>your other debts</strong> &mdash; every \$100/month of car payment eats about \$15,000 of house price. Run your own numbers in the <a href="/mortgage-tools/affordability-calculator/">Florida affordability calculator</a>.</p>

<h2>The Florida Traps That Change the Answer</h2>
<ul>
<li><strong>The seller's tax bill lies to you.</strong> Florida reassesses the home when it sells. A longtime owner paying \$1,800/year under the Save Our Homes cap can hand you a \$4,500/year reality at the same address. We always qualify you on <em>reassessed</em> taxes &mdash; if a lender quotes a payment using the seller's old bill, ask hard questions. (More in our <a href="/florida-property-tax-exemptions/">property tax guide</a>.)</li>
<li><strong>Insurance is a payment item, not an afterthought.</strong> Two identical-price houses can carry very different premiums based on roof age and wind mitigation &mdash; and the difference lands inside your debt ratio. Inland Marion County premiums often run \$400&ndash;\$1,000/year cheaper than the coasts, which literally buys you more house.</li>
<li><strong>Student loans count even at \$0/month.</strong> On income-based repayment? Some programs still count a percentage of your balance as a monthly payment. The rules differ by program &mdash; tell us on day one so we pick the one that treats yours kindest.</li>
</ul>

<div class="brm-keith"><div class="av"><img src="$bio" alt="Keith Meredith, Florida mortgage broker" /></div><div><p class="tag">Keith's take</p><p>I'll be honest with you: the number you're <em>approved</em> for and the number you should <em>spend</em> are two different numbers. The approval doesn't know about daycare, your truck habit, or your travel budget. Buy the payment you can live with &mdash; not the maximum a ratio allows. My job is showing you the ceiling; your job is deciding how far below it you want to live.</p></div></div>

<h2>Make Your Income Go Further</h2>
<div class="brm-callout gold"><span class="tag">The multipliers</span><p><strong><a href="/florida-usda-mortgage/">USDA</a> or <a href="/va-home-mortgage/">VA</a>:</strong> \$0 down keeps your savings intact. <strong><a href="/hometown-heroes-mortgage-program/">Hometown Heroes</a>:</strong> up to \$35,000 toward down payment and closing costs for eligible frontline workers. <strong>Seller concessions:</strong> up to 6% of price on FHA toward your costs. <strong>Cheaper markets:</strong> in the <a href="/cheapest-places-to-buy-a-house-in-florida/">most affordable Florida towns</a>, \$3,000/month of income genuinely buys a home. Stack two or three of these and the table above tilts heavily in your favor.</p></div>

<div class="brm-midcta"><h3>Stop guessing &mdash; get your real number</h3><p>The free 2-minute check starts it, and a pre-approval finishes it: your exact budget, your program, your payment &mdash; usually within 24 hours on weekdays. No credit pull to start.</p><div class="btns"><a class="go" href="/get-pre-approved/">Get My Real Number</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div></div>

<h2>Florida Affordability FAQ</h2>
<div class="brm-faq">
<details open><summary>Can I afford a \$300k house on a \$50k salary?</summary><div class="a"><p>By the standard ratios, it's a stretch &mdash; \$50,000 supports roughly \$1,875/month total debt at 45%, and a \$300,000 Florida home runs about \$2,500/month all-in. It can work with a large down payment, a co-borrower, or very low taxes/insurance &mdash; but realistically, \$50k is a strong fit for the \$200,000&ndash;\$230,000 range, which buys real homes in <a href="/cheapest-places-to-buy-a-house-in-florida/">much of inland Florida</a>.</p></div></details>
<details><summary>How much income do I need for a \$400,000 house in Florida?</summary><div class="a"><p>Roughly \$95,000&ndash;\$110,000 of household income at mid-2026 rates with modest debts, using FHA's 3.5% down and full Florida taxes and insurance. A bigger down payment or zero monthly debts pulls it toward \$90,000.</p></div></details>
<details><summary>Is the 3x income rule accurate?</summary><div class="a"><p>It's a decent first filter &mdash; roughly 3 to 3.5&times; your household income lands near what the ratios allow with typical debts. But Florida's taxes and insurance make it less reliable here than in cheap-insurance states, and your existing debts can swing it by a full multiple. Use it to browse; use a pre-approval to offer.</p></div></details>
<details><summary>Do taxes and insurance really count against what I can afford?</summary><div class="a"><p>Completely &mdash; lenders qualify you on the full PITI payment, and in Florida the taxes-and-insurance slice is one of the largest in the country. It's why the same income affords noticeably more house in Ocala than on the coast, and why we quote full payments, never just principal and interest.</p></div></details>
<details><summary>Does getting pre-approved hurt my credit?</summary><div class="a"><p>Minimally and briefly &mdash; and FICO counts all mortgage inquiries within a shopping window as a single pull. Our 2-minute check uses no credit pull at all; the hard pull only happens at full application. <a href="/get-pre-approved/">Here's exactly how our process works</a>.</p></div></details>
</div>

<p style="font-size:14px;color:#5b6b6b;margin-top:24px;"><em>Figures use mid-2026 rates and typical inland-Florida tax/insurance estimates; your county, credit, and program will move them. This is education, not a loan commitment &mdash; the free pre-approval gives you exact numbers.</em></p>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/how-much-house-can-i-afford-in-florida/#faq","mainEntity":[
{"@type":"Question","name":"Can I afford a \$300k house on a \$50k salary in Florida?","acceptedAnswer":{"@type":"Answer","text":"It is a stretch by standard ratios: \$50,000 supports roughly \$1,875 a month of total debt at 45%, while a \$300,000 Florida home runs about \$2,500 a month all-in. It can work with a large down payment or co-borrower, but \$50k fits the \$200,000 to \$230,000 range best."}},
{"@type":"Question","name":"How much income do I need for a \$400,000 house in Florida?","acceptedAnswer":{"@type":"Answer","text":"Roughly \$95,000 to \$110,000 of household income at mid-2026 rates with modest debts, using FHA 3.5% down and full Florida taxes and insurance."}},
{"@type":"Question","name":"Is the 3x income rule accurate for Florida?","acceptedAnswer":{"@type":"Answer","text":"It is a decent first filter - roughly 3 to 3.5 times household income - but Florida taxes and insurance make it less reliable than in other states, and existing debts can swing it by a full multiple."}},
{"@type":"Question","name":"Do taxes and insurance count against what I can afford?","acceptedAnswer":{"@type":"Answer","text":"Yes. Lenders qualify on the full PITI payment, and Florida's taxes-and-insurance slice is among the largest in the country, which is why the same income affords more house inland than on the coast."}},
{"@type":"Question","name":"Does getting pre-approved hurt my credit?","acceptedAnswer":{"@type":"Answer","text":"Minimally and briefly. FICO counts all mortgage inquiries in a shopping window as one pull, and a 2-minute soft check uses no credit pull at all."}}
]}
</script>
<!-- /wp:html -->
HTML
);

// ============================================================ 2. PROGRAM COMPARISON
$articles[] = array(
  'slug' => 'fha-vs-usda-vs-va-vs-conventional-florida',
  'title' => 'FHA vs USDA vs VA vs Conventional in Florida: Which Loan Wins for You? (2026)',
  'date' => '2026-07-06 09:00:00',
  'seo_title' => 'FHA vs USDA vs VA vs Conventional in Florida (2026) — Which Wins?',
  'seo_desc' => 'The four major Florida loan programs compared honestly: down payments, credit floors, mortgage insurance, 2026 limits — and the crossover rules that decide which one actually saves you money.',
  'content' => <<<HTML
<!-- wp:html -->
<div class="brm-article">
<p style="font-size:13.5px;color:#5b6b6b;margin:0 0 18px;font-family:Karla,sans-serif;">Last updated July 6, 2026 &middot; Written by Keith Meredith, Florida mortgage broker &middot; NMLS #303217</p>
<div class="brm-callout" style="margin-top:0;"><span class="tag">Quick answer</span><p>The 30-second version: <strong>if you served, VA wins</strong> &mdash; \$0 down, no monthly mortgage insurance. <strong>If the home is USDA-eligible and you're under the income limit, USDA wins</strong> &mdash; \$0 down with the cheapest mortgage insurance of any low-down program. <strong>680+ credit with a decent down payment usually favors conventional</strong>; <strong>lower scores or tight ratios favor FHA</strong>. But the FHA-vs-conventional crossover moves with PMI pricing &mdash; make your lender run both side by side before you commit.</p></div>

<p class="brm-lead">Four programs finance almost every home in Florida, and picking the wrong one quietly costs thousands &mdash; not in some dramatic way, just a little every month for thirty years. I run these four against each other all day. Here's the honest comparison, the real 2026 numbers, and the crossover rules that actually decide it.</p>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">\$0 Down</div><div class="l">two programs do it</div><div class="s">VA for those who served; USDA in eligible areas</div></div>
  <div class="brm-stat"><div class="n">\$541,287</div><div class="l">2026 FHA floor (most FL)</div><div class="s">Conventional goes to \$832,750 everywhere</div></div>
  <div class="brm-stat"><div class="n">10 Min</div><div class="l">to compare properly</div><div class="s">Running programs side by side is the cheapest insurance there is</div></div>
</div>

<h2>The Four Programs, Side by Side (2026)</h2>
<div class="brm-tablewrap"><table class="brm-table">
<thead><tr><th></th><th>Conventional</th><th>FHA</th><th>VA</th><th>USDA</th></tr></thead>
<tbody>
<tr><td><strong>Min down</strong></td><td>3% (first-time) / 5%</td><td>3.5%</td><td class="yes">\$0</td><td class="yes">\$0</td></tr>
<tr><td><strong>Credit floor</strong></td><td>620</td><td>~580 (lower w/ 10% down)</td><td>~620 typical (we work lower)</td><td>620&ndash;640</td></tr>
<tr><td><strong>Mortgage insurance</strong></td><td class="yes">PMI &mdash; cancellable at ~20% equity</td><td>1.75% upfront + ~0.55%/yr, usually life of loan</td><td class="yes">None monthly (one-time funding fee)</td><td>1% upfront + 0.35%/yr &mdash; cheapest of the low-down options</td></tr>
<tr><td><strong>2026 limit (most FL)</strong></td><td>\$832,750</td><td>\$541,287</td><td class="yes">No cap w/ full entitlement</td><td>By income, not loan size</td></tr>
<tr><td><strong>Seller concessions</strong></td><td>3&ndash;9% (by down payment)</td><td class="yes">6%</td><td>4% + customary costs</td><td class="yes">6%</td></tr>
<tr><td><strong>Who it's really for</strong></td><td>680+ credit, decent down</td><td>Lower scores, higher ratios</td><td>Veterans &amp; active military</td><td>Eligible areas, income under limit</td></tr>
</tbody></table></div>
<p>All four finance manufactured homes (yes, really &mdash; <a href="/florida-mobile-home-financing/">we close them constantly</a>), and all four work for first-time and repeat buyers alike.</p>

<h2>The Crossover Rules That Actually Decide It</h2>
<h3>VA first &mdash; always, if you're eligible</h3>
<p>If you served, start at <a href="/va-home-mortgage/">VA</a> and make every other program beat it. \$0 down, no monthly mortgage insurance, strong rates, and the one-time funding fee (2.15% first use) is financed in &mdash; and <strong>waived entirely with a service-connected disability rating</strong>. In some cases a veteran can carry two VA loans at once. It loses only in rare scenarios, like very large down payments where conventional's no-funding-fee math edges ahead.</p>
<h3>USDA second &mdash; if the map and the income limit say yes</h3>
<p>The best-kept secret in Florida lending. About 97% of the state's geography is <a href="/usda-eligibility/">USDA-eligible</a>, the income limit (~\$112,000 for a 1&ndash;4 person household in most counties) is higher than people assume, and the 0.35% annual fee is roughly <em>half</em> of FHA's mortgage insurance. \$0 down plus the cheapest MI in the low-down world is hard to beat &mdash; the trade-off is the extra <a href="/florida-usda-turn-times/">USDA review time</a> on your contract.</p>
<h3>FHA vs conventional &mdash; the 680 rule of thumb (and why it moves)</h3>
<p>Here's the honest version: <strong>680+ score with a decent down payment usually favors <a href="/conventional-mortgage-in-florida/">conventional</a></strong> &mdash; the PMI is cheaper at good scores and it cancels at ~20% equity, while FHA's mortgage insurance usually rides for the life of the loan. <strong>Lower scores or tight debt ratios usually favor <a href="/fha-home-mortgage-loan/">FHA</a></strong> &mdash; it forgives both better than anything else, and the seller can pay up to 6% of your costs even at 3.5% down. But PMI pricing is driven by your exact score and down payment, so the crossover point moves file by file. It's a 10-minute side-by-side that can save you thousands &mdash; make your lender do it.</p>

<div class="brm-keith"><div class="av"><img src="$bio" alt="Keith Meredith, Florida mortgage broker" /></div><div><p class="tag">Keith's take</p><p>The mistake I see most isn't picking the wrong program &mdash; it's never comparing at all. A loan officer with one product sells you that product. With 200+ wholesale lenders behind me, I genuinely don't care which of the four you end up in; I care that we ran them against each other first. When someone tells me another lender quoted them FHA without ever pricing conventional, I already know there's money on the table.</p></div></div>

<h2>Four Buyers, Four Answers</h2>
<ul>
<li><strong>The nurse in Gainesville, 700 score, 5% saved:</strong> conventional first-time-buyer program, with <a href="/hometown-heroes-mortgage-program/">Hometown Heroes</a> covering most of the cash &mdash; cancellable PMI beats FHA's lifetime MIP at her score.</li>
<li><strong>The young family near Dunnellon, 640 score, almost nothing saved:</strong> USDA &mdash; \$0 down, eligible address, income under the limit. FHA is the backup if the address fails the map.</li>
<li><strong>The veteran in Ocala, any score:</strong> VA, full stop &mdash; \$0 down and no monthly MI. We've closed VA loans most lenders would have turned away on credit.</li>
<li><strong>The self-employed contractor with great income and a 600 score:</strong> FHA today &mdash; then refinance into conventional once score and equity allow. The program you start in isn't the program you have to die in.</li>
</ul>

<div class="brm-callout gold"><span class="tag">Try it yourself</span><p>Want to see your own scenario across all four? Our <a href="/mortgage-tools/florida-loan-program-comparison/">Florida loan program comparison tool</a> runs them side by side, and the <a href="/how-much-house-can-i-afford-in-florida/">affordability guide</a> shows what income each price point takes.</p></div>

<div class="brm-midcta"><h3>Make the programs compete for you</h3><p>Tell me your score ballpark, your savings, and where you're buying. I'll run all four side by side and show you the math &mdash; the 10-minute exercise that saves thousands.</p><div class="btns"><a class="go" href="/get-pre-approved/">Run My Comparison</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div></div>

<h2>Program Comparison FAQ</h2>
<div class="brm-faq">
<details open><summary>Which is better, FHA or USDA?</summary><div class="a"><p>If the address is eligible and you're under the income limit, USDA usually wins: \$0 down vs 3.5%, and its 0.35% annual fee is about half of FHA's 0.55% mortgage insurance. FHA wins when the property isn't USDA-eligible, your income exceeds the limit, or your credit needs FHA's extra flexibility.</p></div></details>
<details><summary>Can I switch from FHA to conventional later?</summary><div class="a"><p>Yes &mdash; it's one of the most common refinances we do. Buyers start in FHA for the easier qualifying, build equity, then refinance into conventional to drop the mortgage insurance once they're near 20% equity and the rate math works. The program you start in is a starting point, not a life sentence.</p></div></details>
<details><summary>Is VA really better than everything else?</summary><div class="a"><p>For eligible veterans, almost always &mdash; \$0 down, no monthly mortgage insurance, and competitive rates is a combination nothing else matches. The funding fee is financed (and waived with a service-connected disability). The rare exception is a very large down payment, where conventional with no funding fee can pencil slightly better &mdash; which is exactly why we run both.</p></div></details>
<details><summary>What credit score do I need for each program?</summary><div class="a"><p>Ballparks: conventional 620+, FHA ~580 (and 500&ndash;579 with 10% down), USDA 620&ndash;640, VA has no official floor &mdash; we work VA files from 500. Remember it's your middle score of three bureaus that counts, and since April 2026 <a href="/do-mortgage-lenders-use-fico-or-vantagescore/">VantageScore 4.0 is also accepted</a> on conventional and VA.</p></div></details>
<details><summary>Do all four programs work for manufactured homes?</summary><div class="a"><p>Yes &mdash; FHA, VA, USDA, and conventional all finance manufactured homes on land in Florida, each with its own rules on age, foundation, and inspections. Most lenders avoid them; <a href="/florida-mobile-home-financing/">we close them every month</a>, including \$0-down USDA on newer homes.</p></div></details>
</div>

<p style="font-size:14px;color:#5b6b6b;margin-top:24px;"><em>2026 limits and program figures as of publication; guidelines change and your file gets priced on its own facts. The side-by-side comparison in a pre-approval is the real answer.</em></p>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/fha-vs-usda-vs-va-vs-conventional-florida/#faq","mainEntity":[
{"@type":"Question","name":"Which is better, FHA or USDA?","acceptedAnswer":{"@type":"Answer","text":"If the address is USDA-eligible and income is under the limit, USDA usually wins: \$0 down versus 3.5%, with an annual fee about half of FHA's mortgage insurance. FHA wins when the property is not eligible, income exceeds the limit, or credit needs FHA's flexibility."}},
{"@type":"Question","name":"Can I switch from FHA to conventional later?","acceptedAnswer":{"@type":"Answer","text":"Yes, it is one of the most common refinances: start in FHA for easier qualifying, build equity, then refinance into conventional to drop mortgage insurance near 20% equity."}},
{"@type":"Question","name":"Is VA really better than everything else?","acceptedAnswer":{"@type":"Answer","text":"For eligible veterans, almost always: \$0 down, no monthly mortgage insurance, and competitive rates. The funding fee is financed and waived with a service-connected disability. Very large down payments can occasionally favor conventional."}},
{"@type":"Question","name":"What credit score do I need for each program?","acceptedAnswer":{"@type":"Answer","text":"Ballparks: conventional 620+, FHA about 580 (500-579 with 10% down), USDA 620-640, VA no official floor. The middle score of three bureaus counts, and VantageScore 4.0 is accepted on conventional and VA since April 2026."}},
{"@type":"Question","name":"Do all four programs work for manufactured homes?","acceptedAnswer":{"@type":"Answer","text":"Yes. FHA, VA, USDA, and conventional all finance manufactured homes on land in Florida, each with its own age, foundation, and inspection rules."}}
]}
</script>
<!-- /wp:html -->
HTML
);

foreach ($articles as $a) {
    if ($wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s", $a['slug']))) { echo "SKIP {$a['slug']}\n"; continue; }
    $pid = wp_insert_post(array(
        'post_title' => $a['title'], 'post_name' => $a['slug'],
        'post_content' => $css . "\n\n" . $a['content'],
        'post_status' => 'future', 'post_type' => 'post', 'post_author' => $author,
        'post_date' => $a['date'], 'post_date_gmt' => get_gmt_from_date($a['date']),
    ), true);
    if (is_wp_error($pid)) { echo "ERR {$a['slug']}: " . $pid->get_error_message() . "\n"; continue; }
    // glyph backslash repair (wp_insert_post strips them)
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    $c2 = preg_replace_callback('/content:(\s*)"([0-9a-fA-F]{4})"/', fn($m) => 'content:'.$m[1].'"\\'.$m[2].'"', $c);
    if ($c2 !== $c) $wpdb->update($wpdb->posts, array('post_content'=>$c2), array('ID'=>$pid));
    // AIOSEO: UPDATE the auto-created row (lesson learned)
    $t = $wpdb->prefix . 'aioseo_posts';
    $row = $wpdb->get_var($wpdb->prepare("SELECT id FROM $t WHERE post_id=%d", $pid));
    $data = array('title'=>$a['seo_title'], 'description'=>$a['seo_desc'], 'updated'=>current_time('mysql',true));
    if ($row) $wpdb->update($t, $data, array('id'=>$row));
    else { $data['post_id']=$pid; $data['created']=current_time('mysql',true); $wpdb->insert($t, $data); }
    clean_post_cache($pid);
    echo "SCHEDULED {$a['slug']} (post $pid, {$a['date']})\n";
}
echo "done\n";
