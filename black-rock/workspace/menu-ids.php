<?php
$items = wp_get_nav_menu_items(2);
foreach ($items as $it) {
    $url = str_replace(home_url(), '', $it->url);
    echo $it->ID . "\t" . ($it->menu_item_parent ? '  ' : '') . $it->title . "\t" . $url . "\n";
}
