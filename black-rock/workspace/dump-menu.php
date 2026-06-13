<?php
// Dump the nav menu assigned to 'primary' location, hierarchically.
$locations = get_nav_menu_locations();
$menu_id = isset($locations['primary']) ? $locations['primary'] : 2;
$menu = wp_get_nav_menu_object($menu_id);
echo "Primary location menu: " . ($menu ? $menu->name . " (id {$menu->term_id})" : "?") . "\n\n";
$items = wp_get_nav_menu_items($menu_id);
if (!$items) { echo "no items\n"; return; }
$byParent = array();
foreach ($items as $it) $byParent[$it->menu_item_parent][] = $it;
function render($parentId, $byParent, $depth) {
    if (empty($byParent[$parentId])) return;
    foreach ($byParent[$parentId] as $it) {
        $url = str_replace(home_url(), '', $it->url);
        echo str_repeat('    ', $depth) . "- " . $it->title . "  [" . $url . "]\n";
        render($it->ID, $byParent, $depth + 1);
    }
}
render(0, $byParent, 0);
echo "\nTotal items: " . count($items) . "\n";
