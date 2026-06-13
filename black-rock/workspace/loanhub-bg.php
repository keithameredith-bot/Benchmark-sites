<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
$p = strpos($c, '"loan-header"');
echo "loan-header opener:\n" . substr($c, $p-40, 600) . "\n\n";
// any section/group with bg between stats and directory
$lp = strpos($c, 'class="brm-lp"');
$region = substr($c, max(0,$lp-2500), 2500);
preg_match_all('/bgColor[^,]*|"background"[^,]*|theme-palette\d/', $region, $bg);
echo "bg hints before directory: " . implode(' | ', array_unique($bg[0])) . "\n";
