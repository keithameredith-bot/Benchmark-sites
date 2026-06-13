<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=771");
// all links + buttons with context
preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $c, $links, PREG_SET_ORDER);
echo "=== ALL links on HBG ===\n";
foreach ($links as $l) {
    $txt = trim(strip_tags($l[2])) ?: '[btn]';
    echo str_pad(substr($txt,0,40),42) . " -> " . str_replace(home_url(),'',$l[1]) . "\n";
}
// where do "Free PDF Download" / "Take This Guide" sections point
foreach (array('Free PDF Download','Take This Guide') as $n) {
    $p = strpos($c, $n);
    if ($p !== false) {
        $seg = substr($c, $p, 1200);
        preg_match_all('/href="([^"]+)"/', $seg, $hh);
        echo "\nlinks after '$n': " . implode(' | ', array_map(fn($u)=>str_replace(home_url(),'',$u), array_unique($hh[1]))) . "\n";
    }
}
