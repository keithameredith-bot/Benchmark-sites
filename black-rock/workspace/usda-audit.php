<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_status, post_type FROM {$wpdb->posts} WHERE post_status IN ('publish','draft') AND post_type IN ('page','post') AND (post_name LIKE '%usda%' OR post_title LIKE '%USDA%')");
echo "=== all USDA content ===\n";
foreach ($rows as $r) echo "[{$r->ID}] {$r->post_type}/{$r->post_status}: /{$r->post_name}/\n";

// status of the menu one (42)
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=42");
echo "\n=== /florida-usda-mortgage/ (42) update checklist ===\n";
echo "teal hero: " . (strpos($c,'class="brm-hero"')!==false?'YES':'no') . "\n";
echo "lead form: " . (strpos($c,'brm-prog-cta')!==false?'YES':'no') . "\n";
echo "ready-label: " . (strpos($c,'Ready for a Full Application')!==false?'YES':'no') . "\n";
echo "disqualify FAQ pane: " . (strpos($c,'brm-usda-disqualify')!==false?'YES':'no') . "\n";
// redirect from old slug
$r = $wpdb->get_row("SELECT source_url, target_url, enabled FROM {$wpdb->prefix}aioseo_redirects WHERE target_url LIKE '%florida-usda-mortgage%'");
echo "redirect in: " . ($r ? "{$r->source_url} -> {$r->target_url} (" . ($r->enabled?'on':'off') . ")" : 'none') . "\n";
// menu entry
$items = wp_get_nav_menu_items(2);
foreach ($items as $it) if (stripos($it->url,'usda')!==false) echo "menu: '{$it->title}' -> " . str_replace(home_url(),'',$it->url) . "\n";
// schema (loan_map covers it?)
echo "in schema loan_map: " . (strpos($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515099"), '/florida-usda-mortgage/')!==false?'YES':'no') . "\n";
