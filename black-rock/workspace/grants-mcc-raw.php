<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515421");
// raw segment around the MCC section heading
$i = strpos($c, 'The Tax Credit Almost Nobody Uses');
echo "=== section raw (h start -400 to +1400) ===\n" . substr($c, $i-400, 1800) . "\n\n";
$i = strpos($c, "the stack I reach for most");
echo "=== keith take raw ===\n" . substr($c, $i-50, 600) . "\n\n";
$i = strpos($c, 'combine more than one program');
echo "=== faq raw ===\n" . substr($c, $i-120, 700) . "\n\n";
// schema mentions
$i = strpos($c, 'application/ld+json');
$schema = substr($c, $i, 3000);
echo "schema has MCC: " . (stripos($schema, 'MCC') !== false ? 'YES' : 'no') . "\n";
if (stripos($schema, 'MCC') !== false) { $j = stripos($schema, 'MCC'); echo substr($schema, max(0,$j-300), 600) . "\n"; }
