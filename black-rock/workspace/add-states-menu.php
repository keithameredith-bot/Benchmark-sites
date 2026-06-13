<?php
global $wpdb;
$items = wp_get_nav_menu_items(2);
$about = null; $has = false;
foreach ($items as $it) {
    if ($it->title === 'About') $about = $it->ID;
    if (strpos($it->url, 'states-we-are-licensed') !== false) $has = true;
}
if ($about && !$has) {
    $id = wp_update_nav_menu_item(2, 0, array(
        'menu-item-title'=>'Where We Lend','menu-item-url'=>home_url('/states-we-are-licensed/'),
        'menu-item-status'=>'publish','menu-item-type'=>'custom','menu-item-parent-id'=>$about,
        'menu-item-description'=>'Licensed in 40+ states',
    ));
    echo "added 'Where We Lend' under About (item $id)\n";
} else {
    echo "skip (about=" . ($about ?: 'none') . " has=" . ($has?'y':'n') . ")\n";
}
wp_cache_flush();
