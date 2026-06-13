<?php
// Blog taxonomy cleanup: 6 clean categories, one per post, demo/empty cats deleted.
global $wpdb;

// 1. rename / create
wp_update_term(17, 'category', array('name' => 'Loan Programs & Guidelines'));            // was Mortgage Guidelines
wp_update_term(38, 'category', array('name' => 'Manufactured Homes'));                    // fix casing
$buy = term_exists('Buying a Home', 'category');
if (!$buy) $buy = wp_insert_term('Buying a Home', 'category', array('slug'=>'buying-a-home', 'description'=>'Guides for buying a home in Florida — costs, requirements, markets, and timing.'));
$buyId = is_array($buy) ? (int)$buy['term_id'] : (int)$buy;
$ftb = term_exists('First-Time Buyer Help', 'category');
if (!$ftb) $ftb = wp_insert_term('First-Time Buyer Help', 'category', array('slug'=>'first-time-buyer-help', 'description'=>'Grants, down payment assistance, and programs for Florida first-time buyers.'));
$ftbId = is_array($ftb) ? (int)$ftb['term_id'] : (int)$ftb;
echo "Buying a Home = $buyId, First-Time Buyer Help = $ftbId\n";

// 2. assignments (single, definitive)
$map = array(
  987515420 => $buyId,  // cheapest places
  987515422 => $buyId,  // rent-to-own
  987515423 => $buyId,  // requirements
  987515424 => $buyId,  // property tax exemptions
  987515480 => $buyId,  // affordability
  103       => $buyId,  // housing prices
  987513719 => $buyId,  // wait for rates?
  987515481 => 17,      // fha vs usda vs va vs conventional
  987512759 => 17,      // second primary for parents
  748       => 17,      // log cabin
  987515421 => $ftbId,  // FTHB grants
  864       => $ftbId,  // MCC
  987513683 => 38,      // manufactured 2026
  987515335 => 14,      // fico/vantagescore -> Mortgage News
  17059     => 14,      // FHA MIP change -> Mortgage News
  15654     => 14,      // covid -> Mortgage News
  623       => 15,      // usda turn times
  792       => 15,      // usda income limits
  579       => 21,      // listing -> Florida Homes For Sale
);
foreach ($map as $pid => $cat) {
    wp_set_post_categories($pid, array($cat), false); // replace all
    echo "[$pid] " . get_post_field('post_name', $pid) . " => " . get_cat_name($cat) . "\n";
}

// 3. delete demo/now-empty categories
foreach (array(62 => 'Departments', 3 => 'Housing', 32 => '100% USDA Eligible Properties', 13 => 'Mortgage Rates', 18 => 'FHA Financing', 12 => 'Housing Prices', 61 => 'Mortgage Advice') as $tid => $n) {
    $t = get_term($tid, 'category');
    if ($t && !is_wp_error($t)) {
        if ((int)$t->count === 0) { wp_delete_term($tid, 'category'); echo "deleted empty cat: $n\n"; }
        else echo "SKIP $n still has {$t->count} posts\n";
    }
}
wp_cache_flush();
echo "\nfinal categories:\n";
foreach (get_categories(array('hide_empty'=>false)) as $c) echo "  {$c->name} ({$c->count})\n";
