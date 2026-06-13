<?php
global $wpdb;
// find all menu items + widgets referencing work-with-us or pointing to page 18179
echo "=== menu items linking to 18179 / work-with-us ===\n";
$items = $wpdb->get_results("SELECT p.ID, p.post_title FROM {$wpdb->posts} p WHERE p.post_type='nav_menu_item'");
foreach ($items as $it) {
    $type = get_post_meta($it->ID, '_menu_item_type', true);
    $obj = get_post_meta($it->ID, '_menu_item_object_id', true);
    $url = get_post_meta($it->ID, '_menu_item_url', true);
    $title = get_post_meta($it->ID, '_menu_item_title', true);
    if ($obj == 18179 || stripos($url,'work-with-us')!==false) {
        echo "  item {$it->ID}: type=$type obj=$obj url='$url' title='$title'\n";
    }
}
echo "\n=== footer/widget option references to work-with-us ===\n";
foreach ($wpdb->get_results("SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE '%work-with-us%'") as $o) {
    echo "  option: {$o->option_name}\n";
}
echo "\n=== posts/pages content linking to /work-with-us/ ===\n";
foreach ($wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%/work-with-us/%'") as $p) {
    echo "  [{$p->ID}] /{$p->post_name}/\n";
}
