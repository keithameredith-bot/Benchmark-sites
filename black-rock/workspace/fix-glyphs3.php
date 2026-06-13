<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post','wp_block') AND post_content REGEXP 'content:[[:space:]]*\"[0-9a-fA-F]{4}\"'");
foreach ($rows as $r) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID={$r->ID}");
    $n = 0;
    $c = preg_replace_callback('/content:(\s*)"([0-9a-fA-F]{4})"/', function($m) use (&$n){ $n++; return 'content:'.$m[1].'"\\'.$m[2].'"'; }, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$r->ID));
    clean_post_cache($r->ID);
    echo "[{$r->ID}] fixed $n glyph(s)\n";
}
$left = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post','wp_block') AND post_content REGEXP 'content:[[:space:]]*\"[0-9a-fA-F]{4}\"'");
echo "remaining broken-glyph pages: " . count($left) . "\n";
