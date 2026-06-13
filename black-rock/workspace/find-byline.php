<?php
global $wpdb;
// Find the source of the "Written by Keith" byline (Kadence Element or template).
$rows = $wpdb->get_results("SELECT ID, post_type, post_status, post_title FROM {$wpdb->posts} WHERE post_content LIKE '%Written by%' OR post_title LIKE '%byline%' OR post_content LIKE '%Division President%'");
echo "posts containing 'Written by'/'Division President'/byline:\n";
foreach ($rows as $r) echo "  [{$r->ID}] {$r->post_type}/{$r->post_status}: {$r->post_title}\n";
if (!$rows) echo "  (none)\n";

echo "\nkadence_element posts:\n";
$els = $wpdb->get_results("SELECT ID, post_status, post_title FROM {$wpdb->posts} WHERE post_type='kadence_element'");
foreach ($els as $e) echo "  [{$e->ID}] {$e->post_status}: {$e->post_title}\n";
if (!$els) echo "  (none)\n";

// what renders on VA between hero close and first content — check for byline markup
$va = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=88");
echo "\nVA 'Written by' in content: " . (stripos($va,'Written by')!==false?'yes':'no') . "\n";
