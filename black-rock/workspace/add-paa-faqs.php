<?php
// Phase D: add PAA-derived FAQ entries (visible accordion + FAQPage schema) to the new pages.
// Anchored after each page's last <details> block; schema inserted before final ]}</script>.
global $wpdb;

function brm_add_faqs($slug, $afterAnchor, $detailsHtml, $schemaJson) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$row) { echo "MISS $slug\n"; return; }
    $c = $row->post_content;
    if (strpos($c, substr($detailsHtml, 0, 60)) !== false) { echo "$slug: already added\n"; return; }
    // 1. visible FAQ
    $p = strpos($c, $afterAnchor);
    if ($p === false) { echo "$slug: ANCHOR NOT FOUND\n"; return; }
    $at = $p + strlen($afterAnchor);
    $c = substr($c, 0, $at) . "\n" . $detailsHtml . substr($c, $at);
    // 2. schema
    $sAnchor = "\n]}\n</script>";
    if (substr_count($c, $sAnchor) !== 1) { echo "$slug: schema anchor count " . substr_count($c, $sAnchor) . " (skipped schema)\n"; }
    else { $c = str_replace($sAnchor, ",\n" . $schemaJson . "\n]}\n</script>", $c); }
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $row->ID));
    clean_post_cache($row->ID);
    echo "$slug: FAQs added\n";
}

// ---- CHEAPEST PLACES ----
brm_add_faqs('cheapest-places-to-buy-a-house-in-florida',
  "matter.</p></div></details>",
  '<details><summary>Where should you NOT buy a house in Florida?</summary><div class="a"><p>Watch for three traps: homes in high-risk flood zones priced suspiciously low (the flood policy can erase the savings), older coastal condos facing post-Surfside milestone inspections and special assessments, and any market where insurance quotes run wild. The real number is the full monthly payment &mdash; insurance included &mdash; and we run it before you make an offer.</p></div></details>
<details><summary>What is the cheapest and safest place to live in Florida?</summary><div class="a"><p>The small inland county seats &mdash; Marianna, Live Oak, Lake City &mdash; consistently pair some of the state&rsquo;s lowest home prices with lower crime rates than the big metros. &ldquo;Safest&rdquo; always varies street by street, so check neighborhood-level data, but cheap-and-safe genuinely coexist inland in Florida.</p></div></details>
<details><summary>Can I live in Florida on \$3,000 a month?</summary><div class="a"><p>In the towns on this list, realistically yes. A \$150,000&ndash;\$200,000 home bought with \$0-down USDA runs roughly \$1,100&ndash;\$1,500 a month with taxes and insurance at mid-2026 rates &mdash; leaving room in a \$3,000 budget for everything else. In Miami, Tampa, or Orlando, no.</p></div></details>',
  '{"@type":"Question","name":"Where should you NOT buy a house in Florida?","acceptedAnswer":{"@type":"Answer","text":"Avoid homes in high-risk flood zones priced suspiciously low, older coastal condos facing milestone inspections and special assessments, and markets where insurance premiums erase the low price. Always evaluate the full monthly payment including insurance."}},
{"@type":"Question","name":"What is the cheapest and safest place to live in Florida?","acceptedAnswer":{"@type":"Answer","text":"Small inland county seats like Marianna, Live Oak, and Lake City pair some of Florida\'s lowest home prices with lower crime rates than the big metros. Safety varies by neighborhood, so check local data."}},
{"@type":"Question","name":"Can I live in Florida on $3,000 a month?","acceptedAnswer":{"@type":"Answer","text":"In affordable inland towns, yes. A $150,000 to $200,000 home with $0-down USDA runs roughly $1,100 to $1,500 a month including taxes and insurance at mid-2026 rates, leaving room in a $3,000 budget. Coastal metros, no."}}');

// ---- FTHB GRANTS ----
brm_add_faqs('florida-first-time-home-buyer-grants',
  "a cycle opens.</p></div></details>",
  '<details><summary>What is the \$10,000 grant for Florida homeowners?</summary><div class="a"><p>That phrase almost always refers to <strong>Florida Assist</strong> &mdash; up to \$10,000 as a 0%-interest deferred second mortgage for buyers &mdash; or its sibling, the FL HLP \$10,000 second with a small monthly payment. Neither is technically a &ldquo;grant&rdquo; (they&rsquo;re repaid when you sell or refinance), but no monthly cost on FL Assist makes it function like one while you own the home.</p></div></details>
<details><summary>Who qualifies for the \$25,000 first-time homebuyer grant?</summary><div class="a"><p>Careful with this one: <strong>Florida has no \$25,000 state grant.</strong> That number usually refers to a federal proposal that has not become law, or to one-off county SHIP awards that vary by county and cycle. Florida&rsquo;s real, funded programs are Hometown Heroes (up to \$35,000), FL Assist (\$10,000), and the forgivable 3&ndash;5% PLUS grant &mdash; all covered above.</p></div></details>',
  '{"@type":"Question","name":"What is the $10,000 grant for Florida homeowners?","acceptedAnswer":{"@type":"Answer","text":"It almost always refers to Florida Assist, up to $10,000 as a 0%-interest deferred second mortgage for buyers, or the FL HLP $10,000 second with a small monthly payment. Both are repaid when you sell or refinance rather than true grants."}},
{"@type":"Question","name":"Who qualifies for the $25,000 first-time homebuyer grant?","acceptedAnswer":{"@type":"Answer","text":"Florida has no $25,000 state grant. That figure usually refers to a federal proposal that has not become law or to county SHIP awards that vary. Florida\'s funded programs are Hometown Heroes (up to $35,000), FL Assist ($10,000), and the forgivable 3-5% PLUS grant."}}');

// ---- RENT TO OWN ----
brm_add_faqs('rent-to-own-homes-in-florida',
  "FHA, VA, or USDA.</p></div></details>",
  '<details><summary>Does Florida have rent-to-own homes?</summary><div class="a"><p>Yes &mdash; in nearly every Florida metro you&rsquo;ll find both corporate lease-to-own programs and private lease-option deals. They&rsquo;re legal and common. The smarter question is whether you need one: many Florida renters who assume they can&rsquo;t get a mortgage actually qualify today, with less cash than a rent-to-own contract requires.</p></div></details>
<details><summary>Are rent-to-own homes worth it?</summary><div class="a"><p>For most buyers with a 580+ credit score, no &mdash; the option fee plus the rent premium usually exceeds what an FHA down payment would have cost, without building equity or locking today&rsquo;s appreciation. They earn their keep only when a specific, temporary barrier (a credit event months from clearing, brand-new self-employment) blocks a mortgage right now.</p></div></details>',
  '{"@type":"Question","name":"Does Florida have rent-to-own homes?","acceptedAnswer":{"@type":"Answer","text":"Yes, nearly every Florida metro has corporate lease-to-own programs and private lease-options. They are legal and common, but many renters who assume they cannot get a mortgage actually qualify today with less upfront cash."}},
{"@type":"Question","name":"Are rent-to-own homes worth it?","acceptedAnswer":{"@type":"Answer","text":"For most buyers with a 580+ credit score, no. The option fee plus rent premium usually exceeds an FHA down payment without building equity. They make sense only when a specific temporary barrier blocks a mortgage right now."}}');

// ---- REQUIREMENTS ----
brm_add_faqs('requirements-to-buy-a-house-in-florida',
  "is to get pre-approved.</p></div></details>",
  '<details><summary>Can I buy a house in Florida making \$3,000 a month?</summary><div class="a"><p>Yes &mdash; in the right market. At a ~50% debt-to-income cap, \$3,000 a month supports roughly \$1,400&ndash;\$1,500 in total monthly debt including the mortgage. With \$0-down USDA in an affordable inland market, that&rsquo;s a \$150,000&ndash;\$180,000 home &mdash; an everyday purchase in <a href="/cheapest-places-to-buy-a-house-in-florida/">Ocala, Palatka, or Lake City</a>. Existing car loans and cards shrink that number, which is why the pre-approval math matters.</p></div></details>
<details><summary>How much income do I need to buy a \$300,000 house in Florida?</summary><div class="a"><p>Ballpark at mid-2026 rates: roughly <strong>\$75,000&ndash;\$90,000 household income</strong> with modest existing debts, using FHA at 3.5% down with taxes and insurance included. A bigger down payment or zero monthly debts pulls that figure down. The exact answer depends on rates, county costs, and your debts &mdash; a pre-approval gives you the real number in a day.</p></div></details>
<details><summary>Can a 70-year-old get a 30-year mortgage in Florida?</summary><div class="a"><p>Absolutely. Age discrimination in lending is illegal under federal law (ECOA) &mdash; lenders qualify you on income and credit, and Social Security, pension, and retirement income all count. Buyers 62+ also have a second path: the <a href="/reverse-mortgages/">HECM for purchase</a>, with no monthly mortgage payment at all.</p></div></details>',
  '{"@type":"Question","name":"Can I buy a house in Florida making $3,000 a month?","acceptedAnswer":{"@type":"Answer","text":"Yes, in the right market. At a roughly 50% debt-to-income cap, $3,000 a month supports about $1,400 to $1,500 in total monthly debt including the mortgage, which buys a $150,000 to $180,000 home with $0-down USDA in affordable inland Florida markets."}},
{"@type":"Question","name":"How much income do I need to buy a $300,000 house in Florida?","acceptedAnswer":{"@type":"Answer","text":"Roughly $75,000 to $90,000 household income at mid-2026 rates with modest debts, using FHA at 3.5% down including taxes and insurance. A larger down payment or no monthly debts lowers the figure."}},
{"@type":"Question","name":"Can a 70-year-old get a 30-year mortgage in Florida?","acceptedAnswer":{"@type":"Answer","text":"Yes. Age discrimination in lending is illegal under ECOA. Lenders qualify on income and credit, and retirement income counts. Buyers 62 and older can also use a HECM for purchase with no monthly mortgage payment."}}');

// ---- PROPERTY TAX ----
brm_add_faqs('florida-property-tax-exemptions',
  "so check your property appraiser.</p></div></details>",
  '<details><summary>At what age do seniors stop paying property taxes in Florida?</summary><div class="a"><p>There&rsquo;s no age at which Florida property taxes automatically stop. What changes at 65: many counties and cities offer an <em>additional</em> senior homestead exemption (income-limited) worth up to another \$50,000 off taxable value, and some long-term-residency versions can eliminate the county or city portion entirely on modest homes. School levies and special districts generally remain. You have to apply &mdash; nothing happens automatically.</p></div></details>
<details><summary>Do property taxes go down when you turn 65 in Florida?</summary><div class="a"><p>They can &mdash; if you apply. Stack the standard homestead exemption, the Save Our Homes 3% cap you&rsquo;ve accumulated, and your county&rsquo;s additional senior exemption (subject to an annually-adjusted income limit), and many 65+ homeowners see a real drop. File with your county property appraiser; it is not automatic.</p></div></details>',
  '{"@type":"Question","name":"At what age do seniors stop paying property taxes in Florida?","acceptedAnswer":{"@type":"Answer","text":"No age automatically stops Florida property taxes. At 65, many counties offer an additional income-limited senior homestead exemption worth up to another $50,000 off taxable value, and some long-term-residency versions can eliminate the county or city portion on modest homes. You must apply."}},
{"@type":"Question","name":"Do property taxes go down when you turn 65 in Florida?","acceptedAnswer":{"@type":"Answer","text":"They can if you apply. The standard homestead exemption, accumulated Save Our Homes cap, and the county additional senior exemption together lower many 65+ homeowners\' bills. File with your county property appraiser; it is not automatic."}}');

// ---- PHYSICIAN ----
brm_add_faqs('florida-physician-loan',
  "ways to strengthen a file.</p></div></details>",
  '<details><summary>Do physicians get better mortgage rates?</summary><div class="a"><p>Not automatically lower <em>rates</em> &mdash; the real advantage is the <em>terms</em>: 100% financing with no mortgage insurance and student-debt flexibility. Because there&rsquo;s no monthly MI at \$0 down, the physician loan&rsquo;s effective monthly cost often beats a conventional loan at a similar rate &mdash; and crushes FHA once you add FHA&rsquo;s permanent mortgage insurance.</p></div></details>
<details><summary>Is a physician loan better than an FHA loan?</summary><div class="a"><p>For eligible medical professionals with a 680+ score, usually yes: FHA requires 3.5% down and carries mortgage insurance for the life of the loan; the physician loan is \$0 down with no MI and goes to \$2M, far beyond <a href="/loan-limits/">FHA&rsquo;s county caps</a>. FHA wins when your credit score is below 680 or your profession isn&rsquo;t on the eligible list.</p></div></details>',
  '{"@type":"Question","name":"Do physicians get better mortgage rates?","acceptedAnswer":{"@type":"Answer","text":"Not automatically lower rates. The advantage is the terms: 100% financing, no mortgage insurance, and student-debt flexibility. With no monthly MI at $0 down, the effective monthly cost often beats conventional at a similar rate and beats FHA once FHA\'s permanent mortgage insurance is added."}},
{"@type":"Question","name":"Is a physician loan better than an FHA loan?","acceptedAnswer":{"@type":"Answer","text":"For eligible medical professionals with a 680+ score, usually yes. FHA requires 3.5% down with mortgage insurance for the life of the loan; the physician loan is $0 down, no MI, up to $2M. FHA wins below a 680 score or outside the eligible professions."}}');

echo "done\n";
