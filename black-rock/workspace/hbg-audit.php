<?php
global $wpdb;
// 1. HBG page headings + download links
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=771");
echo "=== HBG (771) headings ===\n";
preg_match_all('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $c, $m);
foreach ($m[1] as $h) echo "  - " . trim(strip_tags($h)) . "\n";
echo "\n=== HBG links containing download/pdf/guide ===\n";
preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $c, $links, PREG_SET_ORDER);
foreach ($links as $l) {
    $txt = trim(strip_tags($l[2]));
    if (preg_match('/download|pdf|guide|get the/i', $txt . ' ' . $l[1])) echo "  '$txt' -> {$l[1]}\n";
}
// 2. stock kadence pages (drafts + suspicious published)
echo "\n=== draft pages (likely stock) ===\n";
$rows = $wpdb->get_results("SELECT ID, post_title, post_name, post_status FROM {$wpdb->posts} WHERE post_type='page' AND post_status='draft'");
foreach ($rows as $r) echo "  [{$r->ID}] {$r->post_title} (/{$r->post_name}/)\n";
echo "\n=== published pages w/ stocky names ===\n";
$rows = $wpdb->get_results("SELECT ID, post_title, post_name FROM {$wpdb->posts} WHERE post_type='page' AND post_status='publish' AND (post_title LIKE '%department%' OR post_title LIKE '%project%' OR post_name LIKE '%sample%' OR post_title LIKE '%service%' OR post_content LIKE '%Scelerisque%' OR post_content LIKE '%lorem%')");
foreach ($rows as $r) echo "  [{$r->ID}] {$r->post_title} (/{$r->post_name}/)\n";
