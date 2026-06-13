<?php
// Find published content still in Divi block format (invisible under Kadence).
global $wpdb;
$rows = $wpdb->get_results("
    SELECT ID, post_type, post_name FROM {$wpdb->posts}
    WHERE post_status = 'publish' AND post_type IN ('page','post')
      AND post_content LIKE '%wp:divi/%'
    ORDER BY post_type, post_name");
echo count($rows) . " published items contain Divi blocks:\n";
foreach ($rows as $r) echo "  [{$r->ID}] {$r->post_type}: /{$r->post_name}/\n";
