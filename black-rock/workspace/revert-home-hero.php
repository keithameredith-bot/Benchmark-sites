<?php
global $wpdb;
$b = get_post_meta(38, '_brm_home_hero_round_backup', true);
if ($b) {
    $wpdb->update($wpdb->posts, array('post_content'=>wp_unslash($b)), array('ID'=>38));
    clean_post_cache(38);
    delete_post_meta(38, '_brm_home_hero_round_backup');
    echo "homepage hero reverted to full-width (rounding removed)\n";
} else {
    // fallback: strip the props I added
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
    $c = str_replace(".brm-home-hero {\n  position: relative;\n  max-width: 1280px;\n  margin: 22px auto 0;\n  border-radius: 18px;", ".brm-home-hero {\n  position: relative;", $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>38));
    clean_post_cache(38);
    echo "homepage hero rounding stripped (fallback)\n";
}
