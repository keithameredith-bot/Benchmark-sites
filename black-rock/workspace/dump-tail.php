<?php
// Print the last N chars of a page's content + the block boundary before any #see-my-options / old CTA.
// usage: wp eval-file dump-tail.php <slug> [chars]
global $wpdb;
$slug = $args[0];
$n = isset($args[1]) ? (int) $args[1] : 1600;
$c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
if (!$c) { echo "MISSING $slug\n"; return; }
echo "=== $slug (len " . strlen($c) . ") last $n chars ===\n";
echo substr($c, -$n) . "\n";
