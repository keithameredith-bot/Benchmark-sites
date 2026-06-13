<?php
// Add an "Areas We Serve" dropdown to the primary menu (term 2) with city pages.
// Idempotent: skips if "Areas We Serve" already exists. Placed right after "About".
global $wpdb;
$menu_id = 2;

$items = wp_get_nav_menu_items($menu_id);
foreach ($items as $it) {
    if ($it->title === 'Areas We Serve') { echo "already exists (item {$it->ID})\n"; return; }
}
// find About's menu_order to place Locations right after it
$aboutOrder = null;
foreach ($items as $it) {
    if (stripos($it->title, 'About') !== false && (int)$it->menu_item_parent === 0) { $aboutOrder = (int)$it->menu_order; break; }
}
if ($aboutOrder === null) $aboutOrder = 90;

// shift top-level items after About down by 1 to make room
foreach ($items as $it) {
    if ((int)$it->menu_item_parent === 0 && (int)$it->menu_order > $aboutOrder) {
        wp_update_post(array('ID' => $it->ID, 'menu_order' => (int)$it->menu_order + 1));
    }
}

$parent = wp_update_nav_menu_item($menu_id, 0, array(
    'menu-item-title'     => 'Areas We Serve',
    'menu-item-url'       => home_url('/ocala-mortgage-broker/'),
    'menu-item-status'    => 'publish',
    'menu-item-type'      => 'custom',
    'menu-item-position'  => $aboutOrder + 1,
));
echo "parent 'Areas We Serve' created (item $parent)\n";

$children = array(
    'Ocala'        => '/ocala-mortgage-broker/',
    'The Villages' => '/the-villages-mortgage-broker/',
    'Gainesville'  => '/gainesville-mortgage-broker/',
    'Belleview'    => '/belleview-mortgage-broker/',
);
$pos = 1;
foreach ($children as $title => $path) {
    $cid = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title'      => $title,
        'menu-item-url'        => home_url($path),
        'menu-item-status'     => 'publish',
        'menu-item-type'       => 'custom',
        'menu-item-parent-id'  => $parent,
        'menu-item-position'   => $pos++,
    ));
    echo "  child '$title' -> item $cid\n";
}
wp_cache_flush();
echo "done\n";
