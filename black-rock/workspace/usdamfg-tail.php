<?php
global $wpdb;
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='usda-mortgage-for-manufactured-homes' AND post_type='page' AND post_status='publish'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
echo "page id: $pid, len " . strlen($c) . "\n";
// last few h2s + CTA-ish markers with positions
preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $c, $m, PREG_OFFSET_CAPTURE);
echo "last h2s:\n";
foreach (array_slice($m[1], -5) as $h) echo "  @" . $h[1] . "  " . trim(strip_tags($h[0])) . "\n";
foreach (array('brm-prog-cta'=>'custom form','wp:buttons'=>'button block','Apply Now'=>'apply now','Get Pre-Approved'=>'get preapproved','Pre-Approval'=>'preapproval word') as $needle=>$label) {
    $off=0; $hits=array();
    while (($p = strpos($c, $needle, $off)) !== false) { $hits[]=$p; $off=$p+strlen($needle); }
    echo "$label: " . implode(', ', $hits) . "\n";
}
