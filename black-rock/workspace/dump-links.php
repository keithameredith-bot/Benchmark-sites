<?php
// Dump internal links + anchor text from a page's post_content.
// usage: wp eval-file dump-links.php <post_id>
global $wpdb;
$pid = isset($args[0]) ? (int) $args[0] : 38;
$content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $pid));
echo "post $pid, " . strlen($content) . " bytes\n\n";
preg_match_all('/<a\s[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/is', $content, $m, PREG_SET_ORDER);
foreach ($m as $a) {
    $href = $a[1];
    if (strpos($href, 'http') === 0 && strpos($href, 'black-rock-mortgage.local') === false && strpos($href, 'blackrockmortgage') === false) continue; // external
    $text = trim(strip_tags($a[2]));
    if ($text === '') $text = '[image/icon]';
    $href = preg_replace('#https?://[^/]+#', '', $href);
    printf("%-55s => %s\n", mb_substr($text, 0, 54), $href);
}
