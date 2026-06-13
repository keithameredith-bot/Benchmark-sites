<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
// iframe + its wrapper + any height-sync script
$i = strpos($c, 'brmPreapproval');
echo "=== iframe + 400 before/after ===\n" . substr($c, max(0,$i-500), 1100) . "\n\n";
// CSS rules touching the iframe / its wrapper
preg_match_all('/\.[a-zA-Z0-9_\-]*(form|iframe|gp-)[a-zA-Z0-9_\-]*\s*\{[^}]*\}/', $c, $m);
echo "=== relevant CSS rules ===\n";
foreach ($m[0] as $r) if (preg_match('/height|overflow|max-/', $r)) echo $r . "\n";
echo "\n=== height-sync script present? ===\n";
echo (strpos($c, "brm==='height'") !== false || strpos($c, 'brm === \'height\'') !== false || strpos($c, 'e.data.brm') !== false) ? "YES height listener found\n" : "NO height listener — iframe never resizes!\n";
$s = strpos($c, 'brmPreapproval');
$sc = strpos($c, 'addEventListener', $s);
if ($sc !== false && $sc - $s < 3000) echo "script near iframe:\n" . substr($c, strpos($c,'<script',$s), 600) . "\n";
