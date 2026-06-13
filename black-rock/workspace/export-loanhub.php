<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
// verify all directory links resolve to published pages
preg_match_all('/class="brm-lp-card" href="([^"]+)"/', $c, $m);
$bad = array();
foreach ($m[1] as $url) {
    $slug = trim(parse_url($url, PHP_URL_PATH), '/');
    $slug = basename($slug);
    $exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$exists) $bad[] = $url;
}
echo "directory cards: " . count($m[1]) . " | broken links: " . count($bad) . "\n";
foreach ($bad as $b) echo "  BROKEN: $b\n";
// write content to file for REST push
file_put_contents('C:/Users/keith/AppData/Local/Temp/loanhub-content.html', $c);
echo "exported " . strlen($c) . " bytes\n";
