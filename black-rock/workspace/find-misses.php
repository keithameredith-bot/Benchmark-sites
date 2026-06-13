<?php
global $wpdb;
function ctx($slug, $needle, $span=320) {
    global $wpdb;
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    $p = stripos($c, $needle);
    echo "== $slug [$needle]: " . ($p===false ? "NOT FOUND" : "...".preg_replace('/\s+/',' ',substr($c,max(0,$p-60),$span))."...") . "\n\n";
}
ctx('the-villages-mortgage-broker', 'pay off the bond at closing');
ctx('the-villages-mortgage-broker', 'Sometimes yes, sometimes no');
ctx('belleview-mortgage-broker', 'huge share of the local market');
ctx('requirements-to-buy-a-house-in-florida', 'Minimums by loan type');
ctx('rent-to-own-homes-in-florida', 'the free apps show');
