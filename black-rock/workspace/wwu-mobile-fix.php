<?php
// Mobile fix: recruiting iframe eager (never lazy-load the money form) + white bg fallback.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$old = '<iframe id="brmRecruit" src="/wp-content/uploads/forms/recruiting-form.html?v=2" title="Confidential recruiting conversation" scrolling="no" loading="lazy"></iframe>';
$new = '<iframe id="brmRecruit" src="/wp-content/uploads/forms/recruiting-form.html?v=3" title="Confidential recruiting conversation" scrolling="no" loading="eager" style="background:#fff;"></iframe>';
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    wp_cache_flush();
    echo "iframe now eager + white bg + v=3\n";
} else echo "iframe pattern not found\n";
