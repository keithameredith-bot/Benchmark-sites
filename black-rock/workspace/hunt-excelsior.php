<?php
global $wpdb;
foreach (array('post_content','post_excerpt') as $col) {
    $n = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE $col LIKE '%excelsior%'");
    echo "posts.$col with 'excelsior': $n\n";
}
$pm = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE '%excelsior%'");
echo "postmeta with 'excelsior': $pm\n";
$op = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_value LIKE '%excelsior%'");
echo "options with 'excelsior': $op\n";

// show exact bytes around excelsior in block 987514146
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987514146");
$p = strpos($c, 'excelsior');
if ($p !== false) {
    echo "\ncontext in 987514146:\n";
    echo "..." . substr($c, $p - 25, 90) . "...\n";
    echo "hex of 10 chars before 'excelsior': " . bin2hex(substr($c, $p - 10, 10)) . "\n";
}
// list a few post IDs containing it
$ids = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE '%excelsior%' LIMIT 20");
echo "post IDs: " . implode(',', $ids) . "\n";
