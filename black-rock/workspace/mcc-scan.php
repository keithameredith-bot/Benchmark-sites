<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_type, post_status FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_type IN ('page','post') AND (post_content LIKE '%MCC%' OR post_content LIKE '%Mortgage Credit Certificate%' OR post_title LIKE '%MCC%')");
foreach ($rows as $r) echo "[{$r->ID}] {$r->post_type}/{$r->post_status} /{$r->post_name}/\n";
