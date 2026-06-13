<?php
// Sitewide: update internal links that point at redirected URLs to their final targets
// (removes the 301 hop; covers absolute and relative forms since the path substring matches both).
global $wpdb;
$map = array(
    '/0-down-usda-rural-development-mortgage/' => '/florida-usda-mortgage/',
    '/reverse-mortgages/reverse-mortgage-in-florida/' => '/reverse-mortgages/florida-hecm-guide/',
    '/dscr-loans-florida-2/' => '/florida-dscr-loan/',
);
foreach ($map as $old => $new) {
    $n = $wpdb->query($wpdb->prepare(
        "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)
         WHERE post_status='publish' AND post_content LIKE %s",
        $old, $new, '%' . $wpdb->esc_like($old) . '%'
    ));
    echo "$old -> $new : $n posts updated\n";
}
wp_cache_flush();
echo "done\n";
