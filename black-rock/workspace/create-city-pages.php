<?php
// Service-area pages: The Villages, Gainesville, Belleview. Idempotent by slug.
global $wpdb;
$author = (int) $wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID = 623");
if (!$author) $author = 1;

$pages = array();

$pages[] = array(
    'slug' => 'the-villages-mortgage-broker',
    'title' => 'The Villages, FL Mortgage Broker — VA, Reverse & Retirement-Smart Lending',
    'seo_title' => 'The Villages FL Mortgage Broker | VA, HECM & 55+ Lending | Black Rock',
    'seo_desc' => 'Mortgage broker serving The Villages, Florida — VA loans for the huge veteran community, HECM purchase for 55+, and lenders who understand bond assessments.',
    'content' => <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">A Mortgage Broker Who Actually Understands The Villages</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>The Villages isn't a normal mortgage market. Homes carry <strong>bond assessments</strong> that most out-of-area lenders handle wrong on the application (and it costs buyers in their debt-to-income calculation). A huge share of buyers are <strong>retirees qualifying on assets and retirement income</strong> rather than paychecks. And the veteran population is one of the largest of any community in America. We're based 20 minutes up the road in Ocala, we close loans in The Villages every month, and our programs are built for exactly these situations.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Loan Programs That Fit The Villages</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list"><li><strong><a href="/va-home-mortgage/">VA loans</a> — $0 down, no monthly mortgage insurance.</strong> If you served, this is almost always the strongest financing in The Villages, whether you're buying a designer home or a courtyard villa.</li><li><strong><a href="/reverse-mortgages/">Reverse mortgage (HECM) for purchase</a>.</strong> Buyers 62+ can purchase in The Villages with roughly half down and <em>no monthly mortgage payment</em> — a strategy thousands of Villagers use to keep retirement savings invested. See our <a href="/reverse-mortgages/florida-hecm-guide/">Florida HECM guide</a>.</li><li><strong><a href="/conventional-mortgage-in-florida/">Conventional loans</a></strong> for second homes and primary residences alike — including options for retirees qualifying on assets.</li><li><strong><a href="/florida-non-qm-loans/">Non-QM and asset-based programs</a></strong> when traditional income documentation doesn't tell your real financial story.</li><li><strong><a href="/florida-cash-out-refinance/">Cash-out refinance</a> and <a href="/home-equity-line-of-credit-in-florida/">HELOCs</a></strong> for current Villages homeowners tapping equity.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The Bond Question Every Villages Buyer Asks</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Most homes in The Villages carry a bond — the infrastructure assessment paid through your tax bill — plus annual maintenance and amenity fees. Two things matter for your mortgage: the bond payment must be counted correctly in qualifying (we see out-of-state lenders miss this constantly), and whether to pay off the bond at purchase is a real financial decision we'll run both ways for you. Use our <a href="/mortgage-tools/mortgage-calculator/">Florida mortgage calculator</a> to see the full payment picture, including assessments.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The Villages Mortgage FAQ</h2>
<!-- /wp:heading -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Can I buy in The Villages with a reverse mortgage?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Yes — HECM-for-purchase is common here. Roughly half down (age-dependent), no monthly principal-and-interest payment, and you keep title. You remain responsible for taxes, insurance, and fees.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Do VA loans work on Villages homes with bonds?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Yes. The bond is handled in qualifying, and VA's $0-down benefit applies the same as anywhere in Florida.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Can I qualify if my income is Social Security and investments?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Yes — retirement income, pension, and asset-based qualifying are everyday loans for us, not exceptions.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Ready to talk through a Villages purchase or refinance?</strong> <a href="/get-pre-approved/">Get pre-approved</a> or call Keith directly at <a href="tel:3526194959">352-619-4959</a> — NMLS #303217, based in Marion County, lending throughout The Villages, Lady Lake, Fruitland Park, and Wildwood.</p>
<!-- /wp:paragraph -->
HTML
);

$pages[] = array(
    'slug' => 'gainesville-mortgage-broker',
    'title' => 'Gainesville, FL Mortgage Broker — First-Time Buyers, UF Families & Investors',
    'seo_title' => 'Gainesville FL Mortgage Broker | First-Time Buyer & Investor Loans',
    'seo_desc' => 'Mortgage broker serving Gainesville, Florida — first-time buyer programs for UF and UF Health employees, parent-buyer options for students, and DSCR investor loans.',
    'content' => <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Gainesville Lending, From First Homes to Gator Rentals</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Gainesville runs on the University of Florida and UF Health — which makes its mortgage market unlike anywhere else in North Central Florida: thousands of first-time buyers and hospital and university employees, parents buying for students, and one of the state's most reliable rental markets. We broker all of it from right up the road in Ocala.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">For First-Time Buyers (Including UF &amp; UF Health Staff)</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>If you work full-time in Florida — nurses, professors, staff, first responders — the <a href="/hometown-heroes-mortgage-program/">Florida Hometown Heroes program</a> can put up to $35,000 toward your down payment and closing costs. Stack it with an <a href="/fha-home-mortgage-loan/">FHA loan (580+ credit, 3.5% down)</a> or a <a href="/conventional-mortgage-in-florida/conventional-first-time-home-buyer-program/">3%-down conventional first-time buyer program</a>, and Gainesville's neighborhoods get a lot more reachable. Every program that can help is in our <a href="/florida-first-time-home-buyer-grants/">Florida first-time buyer grants guide</a>.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Living Outside Town? USDA Means $0 Down</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Step outside the Gainesville core — Newberry, High Springs, Alachua, Archer, Hawthorne, Micanopy — and most of the map is eligible for a <a href="/florida-usda-mortgage/">$0-down USDA loan</a>. Check your address against <a href="/usda-eligibility/">Florida USDA eligibility</a>; the income limits are higher than most people expect.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Parents of Students &amp; Investors</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list"><li><strong>Buying for a student?</strong> There are smarter structures than co-signing a lease for four years — including options for <a href="/buy-a-second-primary-residence-for-your-parents/">family-purchase situations</a>. Ask us to run rent-vs-buy for your student's years in Gainesville.</li><li><strong>Investors:</strong> Gainesville's perpetual rental demand makes it a favorite for <a href="/florida-dscr-loan/">DSCR loans</a> — qualify on the property's rental income, no tax returns needed. Self-employed? See <a href="/self-employed-mortgage/">bank statement programs</a>.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Gainesville Mortgage FAQ</h2>
<!-- /wp:heading -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Does Hometown Heroes work for UF and UF Health employees?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>If you're a full-time employee of a Florida-based employer and meet the county income limits — yes, that's exactly who the program is for.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Can I buy a duplex and rent half?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Yes — FHA allows 2–4 unit owner-occupied purchases with 3.5% down, and the rent from the other units can help you qualify. It's one of the best wealth-building moves in a college town.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Do you lend in surrounding towns?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>All of Alachua County and beyond — Newberry, Alachua, High Springs, Archer, Hawthorne, Waldo, and into Marion, Levy, and Bradford counties.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Start with a real number, not a guess.</strong> <a href="/get-pre-approved/">Get pre-approved</a> or call <a href="tel:3526194959">352-619-4959</a> — NMLS #303217, serving Gainesville and all of North Central Florida.</p>
<!-- /wp:paragraph -->
HTML
);

$pages[] = array(
    'slug' => 'belleview-mortgage-broker',
    'title' => 'Belleview, FL Mortgage Broker — USDA, Manufactured Home & First-Time Buyer Loans',
    'seo_title' => 'Belleview FL Mortgage Broker | USDA $0 Down & Manufactured Home Loans',
    'seo_desc' => 'Local mortgage broker for Belleview and south Marion County — $0-down USDA loans, manufactured home financing on land, and first-time buyer programs.',
    'content' => <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Your Local Broker for Belleview &amp; South Marion County</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Belleview, Summerfield, Oxford, Weirsdale, Ocklawaha — this is our backyard. South Marion County is one of the best-value home markets left in Central Florida, and it happens to line up perfectly with the loan programs we know best: $0-down USDA, manufactured homes on land, and first-time buyer assistance.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Why Belleview Buyers Have an Edge</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list"><li><strong><a href="/florida-usda-mortgage/">USDA eligibility</a>:</strong> most of the Belleview area outside the city core qualifies for $0-down USDA Rural Development financing — <a href="/usda-eligibility/">check your address here</a>.</li><li><strong><a href="/florida-mobile-home-financing/">Manufactured homes on land</a></strong> are a huge share of the local market, and we finance them with FHA, VA, USDA, and conventional — including <a href="/florida-mobile-home-financing/singlewide-manufactured-home-financing/">singlewides</a>, which most lenders won't touch.</li><li><strong>Affordability:</strong> Belleview made our list of the <a href="/cheapest-places-to-buy-a-house-in-florida/">cheapest places to buy a house in Florida</a> region — pair low prices with $0-down programs and the math beats renting almost every time.</li><li><strong>Workers commuting to The Villages or Ocala:</strong> the <a href="/hometown-heroes-mortgage-program/">Hometown Heroes program</a> puts up to $35,000 toward your purchase if you work full-time for a Florida employer.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Belleview Mortgage FAQ</h2>
<!-- /wp:heading -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Is Belleview USDA-eligible?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Much of the surrounding area is. Eligibility is address-specific — send us the address and we'll confirm in minutes, or use our <a href="/usda-eligibility/">eligibility guide</a>.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Can I finance a manufactured home with land in Belleview?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Yes — home-and-land packages back to 1976 construction, including <a href="/florida-mobile-home-financing/usda-mortgage-for-manufactured-homes/">$0-down USDA manufactured home loans</a> on newer units, and <a href="/florida-mobile-home-financing/refinance-manufactured-home/">refinances</a> if you already own.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">What credit score do I need?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><a href="/fha-home-mortgage-loan/">FHA works from 580</a> (sometimes lower with more down), VA has flexibility for veterans, and USDA looks for 640+. Not there yet? We'll give you the exact plan to get there.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Talk to a broker who knows these streets.</strong> <a href="/get-pre-approved/">Get pre-approved</a> or call <a href="tel:3526194959">352-619-4959</a> — NMLS #303217, minutes from Belleview, serving all of Marion County.</p>
<!-- /wp:paragraph -->
HTML
);

foreach ($pages as $a) {
    $exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name = %s", $a['slug']));
    if ($exists) { echo "SKIP {$a['slug']} (exists as $exists)\n"; continue; }
    $pid = wp_insert_post(array(
        'post_title'   => $a['title'],
        'post_name'    => $a['slug'],
        'post_content' => $a['content'],
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => $author,
    ), true);
    if (is_wp_error($pid)) { echo "ERROR {$a['slug']}: " . $pid->get_error_message() . "\n"; continue; }
    $pt = $wpdb->prefix . 'aioseo_posts';
    $wpdb->insert($pt, array('post_id' => $pid, 'title' => $a['seo_title'], 'description' => $a['seo_desc'], 'created' => current_time('mysql', true), 'updated' => current_time('mysql', true)));
    echo "PUBLISHED {$a['slug']} (page $pid)\n";
}
