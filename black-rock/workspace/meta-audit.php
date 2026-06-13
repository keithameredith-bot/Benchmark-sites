<?php
global $wpdb;
$slugs = array('cheapest-places-to-buy-a-house-in-florida','florida-first-time-home-buyer-grants','rent-to-own-homes-in-florida','requirements-to-buy-a-house-in-florida','florida-property-tax-exemptions','the-villages-mortgage-broker','gainesville-mortgage-broker','belleview-mortgage-broker','florida-physician-loan','reviews','states-we-are-licensed','florida-usda-turn-times');
echo str_pad('slug',44) . "T-len D-len  title\n";
foreach ($slugs as $s) {
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $s));
    if (!$pid) { echo str_pad($s,44) . "MISSING\n"; continue; }
    $r = $wpdb->get_row($wpdb->prepare("SELECT title, description FROM {$wpdb->prefix}aioseo_posts WHERE post_id=%d", $pid));
    $t = $r ? html_entity_decode($r->title) : '';
    $d = $r ? html_entity_decode($r->description) : '';
    $tf = strlen($t) > 62 ? '⚠' : ' ';
    $df = strlen($d) > 160 ? '⚠' : ' ';
    echo str_pad($s,44) . str_pad(strlen($t).$tf,6) . str_pad(strlen($d).$df,7) . substr($t,0,60) . "\n";
}
