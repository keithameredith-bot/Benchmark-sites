<?php
global $wpdb;
// dump footer/secondary menus
foreach (array(71=>'Quick Links',77=>'Useful Links',74=>'Service Request',68=>'Primary',16=>'Secondary') as $mid=>$name) {
    $items = wp_get_nav_menu_items($mid);
    if (!$items) { continue; }
    echo "=== MENU $mid ($name) ===\n";
    foreach ($items as $it) {
        $u = str_replace(home_url(),'',$it->url);
        $st = $it->object_id ? get_post_status($it->object_id) : '-';
        echo "  '{$it->title}' -> {$u}  [obj:{$it->object} status:$st]\n";
    }
}
// scan all published content for links to the 404 targets
echo "\n=== content links to states/work-with-us/reviews ===\n";
$rows = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN('page','post') AND (post_content LIKE '%work-with-us%' OR post_content LIKE '%/reviews%' OR post_content LIKE '%licensed%state%' OR post_content LIKE '%states-we%' OR post_content LIKE '%where-we-lend%')");
foreach ($rows as $r) echo "  found ref in /{$r->post_name}/ (id {$r->ID})\n";
if(!$rows) echo "  (none in content)\n";
// kadence footer config size
$mods = get_option('theme_mods_kadence');
$keys = is_array($mods) ? array_keys($mods) : array();
$footerKeys = array_filter($keys, fn($k)=>stripos($k,'footer')!==false);
echo "\n=== kadence footer mod keys ===\n  ".implode("\n  ", $footerKeys)."\n";
