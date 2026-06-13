<?php
// Extract the full wp:html CTA/form block (containing brmPreapproval) from post 88.
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID = 88");
$needle = 'brmPreapproval';
$p = strpos($c, $needle);
$start = strrpos(substr($c, 0, $p), '<!-- wp:html -->');
$endMarker = '<!-- /wp:html -->';
$end = strpos($c, $endMarker, $p) + strlen($endMarker);
$block = substr($c, $start, $end - $start);
file_put_contents(__DIR__ . '/va-form-block.txt', $block);
echo "extracted " . strlen($block) . " bytes to va-form-block.txt\n";
echo "starts with: " . substr($block, 0, 60) . "\n";
echo "ends with: " . substr($block, -40) . "\n";
