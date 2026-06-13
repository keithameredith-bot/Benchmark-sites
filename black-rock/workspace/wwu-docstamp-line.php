<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=18179");
$old = 'In Florida, UWM-to-UWM refinances skip the doc stamps &mdash; real money your client sees on the closing disclosure.';
$new = 'In Florida, UWM-to-UWM refinances skip the doc stamps &mdash; every day, no promotion required. Real money your client sees on the closing disclosure.';
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>18179));
    clean_post_cache(18179);
    wp_cache_flush();
    echo "everyday line restored\n";
} else echo "not found\n";
