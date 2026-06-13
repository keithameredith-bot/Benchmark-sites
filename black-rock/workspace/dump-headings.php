<?php
// List headings in a post's content. usage: wp eval-file dump-headings.php <post_id>
global $wpdb;
$pid = (int) $args[0];
$content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $pid));
preg_match_all('/<(h[1-4])[^>]*>(.*?)<\/\1>/is', $content, $m, PREG_SET_ORDER);
foreach ($m as $h) {
    $lvl = strtoupper($h[1]);
    $txt = trim(preg_replace('/\s+/', ' ', strip_tags($h[2])));
    $pad = str_repeat('  ', (int) substr($lvl, 1) - 1);
    echo "$pad$lvl: $txt\n";
}
