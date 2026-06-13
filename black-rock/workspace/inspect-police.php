<?php
global $wpdb;
$cur = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=15780");
$bak = get_post_meta(15780, '_brm_formcta_v2_backup_20260611', true);
$bak = wp_unslash($bak);
echo "CURRENT len: " . strlen($cur) . " | words: " . str_word_count(strip_tags($cur)) . "\n";
echo "BACKUP  len: " . strlen($bak) . " | words: " . str_word_count(strip_tags($bak)) . "\n\n";
echo "=== CURRENT headings ===\n";
preg_match_all('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $cur, $m1);
foreach ($m1[1] as $h) echo "  - " . trim(strip_tags($h)) . "\n";
echo "=== BACKUP (pre-rework) headings ===\n";
preg_match_all('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $bak, $m2);
foreach ($m2[1] as $h) echo "  - " . trim(strip_tags($h)) . "\n";
echo "\n=== what got dropped (tail after form in backup) ===\n";
$fEnd = strpos($bak, '<!-- /wp:html -->');
if ($fEnd !== false) { echo substr($bak, $fEnd + 17, 1200) . "\n"; }
