<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=164");
$n = substr_count($c, '\\$');
if ($n) {
    $c = str_replace('\\$', '$', $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>164));
    clean_post_cache(164);
}
echo "fixed $n literal backslash-dollar(s)\n";
