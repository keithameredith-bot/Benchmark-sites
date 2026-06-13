<?php
global $wpdb;
foreach (array('belleview-mortgage-broker','cheapest-places-to-buy-a-house-in-florida') as $slug) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    echo "=== $slug ===\n";
    $off = 0;
    while (($p = stripos($c, 'hometown', $off)) !== false) {
        echo "..." . preg_replace('/\s+/',' ', substr($c, max(0,$p-200), 380)) . "...\n---\n";
        $off = $p + 8;
    }
}
