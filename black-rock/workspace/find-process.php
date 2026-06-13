<?php
global $wpdb;
$gp = $wpdb->get_row("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name='get-pre-approved' AND post_status='publish'");
echo "=== get-pre-approved (ID {$gp->ID}) headings ===\n";
preg_match_all('/<h[1-4][^>]*>(.*?)<\/h[1-4]>/is', $gp->post_content, $m);
foreach ($m[1] as $h) echo "  - " . trim(strip_tags($h)) . "\n";
echo "  has form iframe: " . (strpos($gp->post_content,'brmPreapproval')!==false?'yes':'no') . " | has brm-prog-cta: " . (strpos($gp->post_content,'brm-prog-cta')!==false?'yes':'no') . " | length: " . strlen($gp->post_content) . "\n";

echo "\n=== pages mentioning 'full application' / process / 'reaches out' / steps ===\n";
$rows = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post') AND (post_content LIKE '%full application%' OR post_content LIKE '%full app%' OR post_content LIKE '%how it works%' OR post_content LIKE '%what happens next%' OR post_title LIKE '%process%' OR post_name LIKE '%process%')");
foreach ($rows as $r) echo "  [{$r->ID}] /{$r->post_name}/\n";
if (!$rows) echo "  (none found)\n";
