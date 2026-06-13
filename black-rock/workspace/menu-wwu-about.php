<?php
// Add Work With Us under the About dropdown.
$items = wp_get_nav_menu_items(2);
$about = null; $exists = false;
foreach ($items as $it) {
    if ($it->title === 'About' && (int)$it->menu_item_parent === 0) $about = $it->ID;
    if (stripos($it->title, 'Work With Us') !== false) $exists = true;
}
if ($exists) { echo "already in menu\n"; return; }
if (!$about) { echo "About parent not found\n"; return; }
$mid = wp_update_nav_menu_item(2, 0, array(
    'menu-item-title' => 'Work With Us',
    'menu-item-object' => 'page', 'menu-item-object-id' => 18179, 'menu-item-type' => 'post_type',
    'menu-item-status' => 'publish',
    'menu-item-parent-id' => $about,
    'menu-item-description' => 'Loan originators: keep more, build yours',
));
echo "added Work With Us under About (item $mid)\n";
$css = wp_get_custom_css();
if (strpos($css, ".menu-item-$mid > a::before") === false) {
    $css .= "\n#primary-menu .sub-menu .menu-item-$mid > a::before{content:\"\\1F91D\";}\n";
    wp_update_custom_css_post($css);
    echo "handshake icon added\n";
}
wp_cache_flush();
