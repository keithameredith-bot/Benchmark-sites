<?php
$items = wp_get_nav_menu_items(2);
foreach ($items as $it) {
    if ($it->title === 'Areas We Serve' && (int)$it->menu_item_parent === 0) {
        wp_update_nav_menu_item(2, $it->ID, array(
            'menu-item-title' => 'Areas We Serve',
            'menu-item-url' => home_url('/states-we-are-licensed/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-position' => $it->menu_order,
        ));
        echo "Areas We Serve parent -> /states-we-are-licensed/ (item {$it->ID})\n";
        break;
    }
}
wp_cache_flush();
