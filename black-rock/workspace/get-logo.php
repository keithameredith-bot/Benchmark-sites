<?php
$url = wp_get_attachment_url(get_theme_mod('custom_logo'));
echo "logo: $url\n";
// fix the wall's logo path
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=18179");
$bad = '/wp-content/uploads/2026/04/cropped-black-rock-mortgage-logo.webp';
if ($url && strpos($c, $bad) !== false) {
    $rel = str_replace(home_url(), '', $url);
    $c = str_replace($bad, $rel, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>18179));
    clean_post_cache(18179);
    echo "wall updated to $rel\n";
}
