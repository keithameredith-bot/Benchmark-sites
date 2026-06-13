<?php
// Scan all published content for CSS content: properties with a 4-hex glyph code missing its backslash
// (migration artifact). e.g. content: "201C" should be content: "\201C".
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_type, post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post','wp_block') AND post_content REGEXP 'content:[[:space:]]*\"[0-9a-fA-F]{4}\"'");
if (!$rows) { echo "no broken-glyph content found anywhere. clean.\n"; return; }
foreach ($rows as $r) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID={$r->ID}");
    preg_match_all('/content:\s*"([0-9a-fA-F]{4})"/', $c, $m);
    echo "[{$r->ID}] {$r->post_type} /{$r->post_name}/ -> " . implode(', ', array_unique($m[1])) . "\n";
}
