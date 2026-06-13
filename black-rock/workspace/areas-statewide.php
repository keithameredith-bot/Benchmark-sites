<?php
// Areas We Serve: add "All of Florida — Statewide" as FIRST child + "Where We Lend (40+ States)" as last.
// Signals statewide targeting, not just the four cities.
global $wpdb;
$menu_id = 2;
$items = wp_get_nav_menu_items($menu_id);
$areas = null; $ocalaOrder = null; $haveFL = false; $haveLend = false;
foreach ($items as $it) {
    if ($it->title === 'Areas We Serve') $areas = $it->ID;
    if ($it->title === 'Ocala' && $it->menu_item_parent) $ocalaOrder = (int)$it->menu_order;
    if (stripos($it->title, 'All of Florida') !== false) $haveFL = true;
    if ($it->menu_item_parent && stripos($it->url, 'states-we-are-licensed') !== false && $it->title !== 'Where We Lend') $haveLend = true;
}
if (!$areas) { echo "Areas parent missing\n"; return; }

if (!$haveFL) {
    // shift items at/after Ocala's order down by 1
    foreach ($items as $it) { if ((int)$it->menu_order >= $ocalaOrder) wp_update_post(array('ID'=>$it->ID, 'menu_order'=>(int)$it->menu_order+1)); }
    $fl = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'All of Florida',
        'menu-item-url' => home_url('/states-we-are-licensed/'),
        'menu-item-status' => 'publish', 'menu-item-type' => 'custom',
        'menu-item-parent-id' => $areas,
        'menu-item-position' => $ocalaOrder,
        'menu-item-description' => 'Statewide — every Florida county',
    ));
    echo "added 'All of Florida' first (item $fl)\n";
    // icon: palm tree
    $css = wp_get_custom_css();
    if (strpos($css, ".menu-item-$fl > a::before") === false) {
        $css .= "\n#primary-menu .sub-menu .menu-item-$fl > a::before{content:\"\\1F334\";}\n";
        wp_update_custom_css_post($css);
        echo "palm icon added for item $fl\n";
    }
} else echo "All of Florida already present\n";

// add 'Licensed in 40+ States' at end of Areas dropdown
$haveStatesInAreas = false;
foreach (wp_get_nav_menu_items($menu_id) as $it) {
    if ((int)$it->menu_item_parent === (int)$areas && stripos($it->url,'states-we-are-licensed') !== false) $haveStatesInAreas = true;
}
if (!$haveStatesInAreas) {
    $ln = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Licensed in 40+ States',
        'menu-item-url' => home_url('/states-we-are-licensed/'),
        'menu-item-status' => 'publish', 'menu-item-type' => 'custom',
        'menu-item-parent-id' => $areas,
        'menu-item-description' => 'See everywhere we lend',
    ));
    echo "added 'Licensed in 40+ States' (item $ln)\n";
    $css = wp_get_custom_css();
    if (strpos($css, ".menu-item-$ln > a::before") === false) {
        $css .= "\n#primary-menu .sub-menu .menu-item-$ln > a::before{content:\"\\1F5FA\";}\n";
        wp_update_custom_css_post($css);
    }
} else echo "states link already in Areas\n";
wp_cache_flush();
echo "done\n";
