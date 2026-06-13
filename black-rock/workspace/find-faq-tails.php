<?php
global $wpdb;
foreach (array('cheapest-places-to-buy-a-house-in-florida','florida-first-time-home-buyer-grants') as $slug) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    $p = strrpos($c, '</details>');
    echo "=== $slug last details tail ===\n";
    echo substr($c, max(0,$p-200), 230) . "\n\n";
}
