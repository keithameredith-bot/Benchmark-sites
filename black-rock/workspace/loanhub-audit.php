<?php
global $wpdb;
// 1. current loan-programs (64) structure
$p = get_post(64);
echo "=== loan-programs (64) — " . strlen($p->post_content) . " bytes ===\n";
preg_match_all('/<h[12][^>]*>(.*?)<\/h[12]>/is', $p->post_content, $m);
echo "headings:\n";
foreach ($m[1] as $h) echo "  - " . trim(strip_tags($h)) . "\n";
preg_match_all('/<!-- wp:([a-z\/\-]+)/', $p->post_content, $bl);
echo "block types: " . implode(', ', array_unique($bl[1])) . "\n";
echo "has brm-hero: " . (strpos($p->post_content,'brm-hero')!==false?'Y':'N') . "\n\n";

// 2. all published loan-program-type pages with slug (for the directory)
echo "=== PUBLISHED PROGRAM PAGES (candidates for the hub) ===\n";
$slugs = array(
  'conventional-mortgage-in-florida','fha-home-mortgage-loan','va-home-mortgage','florida-usda-mortgage',
  'florida-jumbo-loan','hometown-heroes-mortgage-program','down-payment-assistance-in-florida',
  'florida-mobile-home-financing','florida-construction-loan','spec-construction-loans',
  'self-employed-mortgage','bank-statement-mortgage-program','florida-non-qm-loans','florida-dscr-loan',
  'florida-physician-loan','condo-tel-financing-in-florida','florida-cash-out-refinance',
  'home-equity-line-of-credit-in-florida','reverse-mortgages','refinance-mortgage','temporary-rate-buydown',
  'fha-streamline-refinance','usda-refinance-program','singlewide-manufactured-home-financing',
  'manufactured-homes-that-have-been-moved','usda-mortgage-for-manufactured-homes','refinance-manufactured-home',
  'va-new-construction-loan','new-houses-in-ocala-florida'
);
foreach ($slugs as $s) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_title, post_status FROM {$wpdb->posts} WHERE post_name=%s AND post_type='page'", $s));
    if ($row) echo sprintf("  [%s] /%s/  %s\n", $row->post_status, $s, $row->post_title);
    else echo "  MISSING: /$s/\n";
}
