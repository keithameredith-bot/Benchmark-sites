<?php
global $wpdb;
$pid = 987513017;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
echo "kadence/form occurrences: " . substr_count($c, 'wp:kadence/form') . "\n";
foreach (array('Looking for help', 'brm-contact-wrap', 'Find our contact', 'kadence/form') as $n) {
    $p = strpos($c, $n);
    echo str_pad($n, 22) . " @ " . ($p === false ? 'NONE' : $p) . "\n";
}
// list rowlayout opener positions + a hint of their content
$off = 0;
while (($p = strpos($c, '<!-- wp:kadence/rowlayout', $off)) !== false) {
    $hint = '';
    $seg = substr($c, $p, 3000);
    foreach (array('Looking for help','kadence/form','Find our contact','uniqueID":"([^"]+)"') as $x) {}
    preg_match('/"uniqueID":"([^"]+)"/', $seg, $m);
    $hasForm = strpos($seg, 'kadence/form') !== false ? ' [contains form within 3k]' : '';
    echo "rowlayout @ $p  id=" . ($m[1] ?? '?') . $hasForm . "\n";
    $off = $p + 10;
}
