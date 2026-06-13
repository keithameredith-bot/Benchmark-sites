<?php
global $wpdb;
$fixes = array(
  38 => array('content: "2192"' => 'content: "\2192"'),
  987515436 => array('content: "2212"' => 'content: "\2212"'),
);
foreach ($fixes as $pid => $map) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    $orig = $c;
    foreach ($map as $from => $to) $c = str_replace($from, $to, $c);
    if ($c !== $orig) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid)); clean_post_cache($pid); echo "[$pid] glyph backslash restored\n"; }
    else echo "[$pid] no change\n";
}
// re-scan to confirm clean
$rows = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post','wp_block') AND post_content REGEXP 'content:[[:space:]]*\"[0-9a-fA-F]{4}\"'");
echo "remaining broken-glyph pages: " . count($rows) . "\n";
