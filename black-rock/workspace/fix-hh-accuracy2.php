<?php
global $wpdb;
// Belleview FAQ (curly apostrophe version)
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='belleview-mortgage-broker' AND post_status='publish'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$from = "Belleview, Summerfield, and Oxford let Villages-area workers own for less, and if you work full-time for a Florida employer you may also qualify for up to \$35,000 through <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a>.";
$to = "Belleview, Summerfield, and Oxford let Villages-area workers own for less &mdash; and many Villages-area jobs are exactly what <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> covers: healthcare, first responders, childcare, and K-12 school staff can get up to \$35,000 toward the purchase, and veterans qualify even as repeat buyers.";
if (strpos($c,$from)!==false) { $c=str_replace($from,$to,$c); $wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$pid)); clean_post_cache($pid); echo "belleview FAQ fixed\n"; }
else echo "belleview: still not found\n";

// Cheapest places "Free money" callout
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='cheapest-places-to-buy-a-house-in-florida'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$from = "puts up to \$35,000 toward your down payment and closing costs if you work full-time for a Florida employer.";
$to = "puts up to \$35,000 toward your down payment and closing costs if you work in an eligible frontline occupation &mdash; healthcare, K-12 schools, first responders, childcare, or military (veterans qualify even as repeat buyers).";
if (strpos($c,$from)!==false) { $c=str_replace($from,$to,$c); $wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$pid)); clean_post_cache($pid); echo "cheapest-places callout fixed\n"; }
else echo "cheapest-places: still not found\n";
