<?php
global $wpdb;
echo "=== PAGES/POSTS with my1003app portal link ===\n";
$rows = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%my1003app%'");
$missing = 0;
foreach ($rows as $r) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $r->ID));
    // count my1003app anchors lacking target=
    preg_match_all('/<a\s+[^>]*href="[^"]*my1003app[^"]*"[^>]*>/i', $c, $m);
    $noTarget = 0;
    foreach ($m[0] as $a) if (stripos($a,'target=')===false) $noTarget++;
    echo sprintf("  [%s] /%s/  anchors=%d need-newtab=%d\n", $r->ID, $r->post_name, count($m[0]), $noTarget);
    $missing += $noTarget;
}
echo "TOTAL anchors needing new-tab: $missing\n\n";
echo "=== FORM FILES (arrive button) ===\n";
foreach (glob(WP_CONTENT_DIR . '/uploads/forms/*.html') as $f) {
    $c = file_get_contents($f);
    if (strpos($c,'arriveBtn')!==false || strpos($c,'my1003app')!==false || strpos($c,'ARRIVE_URL')!==false) {
        preg_match('/<a[^>]*id="arriveBtn"[^>]*>/i', $c, $m);
        echo "  " . basename($f) . " : " . ($m ? trim(preg_replace('/\s+/',' ',$m[0])) : 'has my1003app ref') . "\n";
    }
}
