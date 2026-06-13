<?php
global $wpdb;
$pid = 38;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'max-width: 1280px;') !== false && strpos($c,'.brm-home-hero {') !== false) { /* may already be done */ }
$from = ".brm-home-hero {\n  position: relative;";
// add contain + round to the hero (keep photo). Insert props right after position:relative.
$to = ".brm-home-hero {\n  position: relative;\n  max-width: 1280px;\n  margin: 22px auto 0;\n  border-radius: 18px;";
if (strpos($c, 'max-width: 1280px;') === false && strpos($c, $from) !== false) {
    if(!get_post_meta($pid,'_brm_home_hero_round_backup',true)) add_post_meta($pid,'_brm_home_hero_round_backup',wp_slash($c),true);
    $c = str_replace($from, $to, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "homepage hero -> contained + rounded (photo kept)\n";
} else {
    echo "homepage hero: anchor not found or already rounded\n";
}
