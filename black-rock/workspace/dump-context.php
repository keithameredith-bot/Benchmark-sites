<?php
// Print context around a needle in post_content. usage: wp eval-file dump-context.php <post_id> <needle> [span]
global $wpdb;
$pid = (int) $args[0];
$needle = $args[1];
$span = isset($args[2]) ? (int) $args[2] : 600;
$content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $pid));
$off = 0; $n = 0;
while (($p = strpos($content, $needle, $off)) !== false && $n < 6) {
    echo "===== match at $p =====\n";
    echo substr($content, max(0, $p - $span), $span * 2) . "\n\n";
    $off = $p + strlen($needle);
    $n++;
}
if ($n === 0) echo "no match\n";
