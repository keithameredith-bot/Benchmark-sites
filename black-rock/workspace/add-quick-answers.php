<?php
// AI-citation upgrade: add a quotable "Quick Answer" box + dateline/review line at the top of each article.
// Quick answers are written to be extractable verbatim by AI Overviews/Perplexity. Idempotent via marker.
global $wpdb;

$items = array(
  'cheapest-places-to-buy-a-house-in-florida' => array(
    'qa' => "The cheapest places to buy a house in Florida in 2026 are Palatka, Live Oak, Marianna, Lake City, Okeechobee, and the inland towns of Marion, Citrus, and Highlands counties &mdash; markets where typical homes sell for roughly half the price of coastal metros. Most of these towns are also USDA-eligible, meaning qualified buyers can purchase with \$0 down.",
  ),
  'florida-first-time-home-buyer-grants' => array(
    'qa' => "Florida first-time home buyers in 2026 can get up to \$35,000 through the Hometown Heroes program, up to \$10,000 through Florida Assist, a forgivable 3&ndash;5% HFA PLUS grant, and a recurring federal tax credit through the MCC &mdash; and several of these programs can be stacked on a single purchase with an FHA, conventional, USDA, or VA first mortgage.",
  ),
  'rent-to-own-homes-in-florida' => array(
    'qa' => "Rent-to-own homes in Florida typically require an upfront option fee of 2&ndash;7% of the purchase price plus above-market rent &mdash; on a \$300,000 home, that's \$6,000&ndash;\$21,000 at risk if you never close. That is often more cash than the 3.5% FHA down payment, and many rent-to-own shoppers with a 580+ credit score already qualify to simply buy.",
  ),
  'requirements-to-buy-a-house-in-florida' => array(
    'qa' => "To buy a house in Florida in 2026 you generally need: a credit score of 580+ (FHA) or 620+ (conventional), a two-year documentable work history, a debt-to-income ratio up to roughly 50%, and a down payment of \$0 (VA/USDA) to 3.5% (FHA). Florida residency is not required, and gift funds are allowed on all major programs.",
  ),
  'florida-property-tax-exemptions' => array(
    'qa' => "Florida's homestead exemption removes up to \$50,000 from your primary home's taxable value and caps your assessed-value growth at 3% per year (Save Our Homes). You must file once with your county property appraiser by March 1, and the exemption does not transfer from the previous owner &mdash; their tax bill is not your tax bill.",
  ),
);

foreach ($items as $slug => $cfg) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$row) { echo "MISS $slug\n"; continue; }
    $c = $row->post_content;
    if (strpos($c, 'brm-qa-box') !== false) { echo "skip $slug (has QA)\n"; continue; }
    $block = '<!-- brm-qa-box -->'
      . "\n<p style=\"font-size:13.5px;color:#5b6b6b;margin:0 0 18px;font-family:Karla,sans-serif;\">Last updated June 11, 2026 &middot; Written by Keith Meredith, Florida mortgage broker &middot; NMLS #303217</p>\n"
      . '<div class="brm-callout" style="margin-top:0;"><span class="tag">Quick answer</span><p>' . $cfg['qa'] . "</p></div>\n";
    $anchor = '<div class="brm-article">';
    $pos = strpos($c, $anchor);
    if ($pos === false) { echo "no wrapper $slug\n"; continue; }
    $at = $pos + strlen($anchor);
    $c = substr($c, 0, $at) . "\n" . $block . substr($c, $at);
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $row->ID));
    clean_post_cache($row->ID);
    echo "QA added: $slug\n";
}

// turn-times post (623): plain HTML, add quick answer + dateline at very top
$pid = 623;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brm-qa-box') === false) {
    $block = '<!-- brm-qa-box -->'
      . "\n<p style=\"font-size:13.5px;color:#5b6b6b;margin:0 0 14px;\">Last updated June 11, 2026 &middot; Written by Keith Meredith, Florida mortgage broker &middot; NMLS #303217</p>\n"
      . "<p><strong>Quick answer:</strong> Florida USDA turn times typically run 1&ndash;15 business days after underwriting, through a single statewide queue. To hear the exact submission dates the USDA is processing right now, call the Florida Rural Development hotline at <strong>352-338-3421</strong> &mdash; it's a recording, available to anyone, updated continuously.</p>\n";
    $wpdb->update($wpdb->posts, array('post_content' => $block . $c), array('ID' => $pid));
    clean_post_cache($pid);
    echo "QA added: florida-usda-turn-times\n";
}
