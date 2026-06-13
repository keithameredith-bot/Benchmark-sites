<?php
// Inspect the author-bio reusable block (987514146) image reference.
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987514146");
echo "block len: " . strlen($c) . "\n";
// find kadence image blocks / img tags
preg_match_all('/<img[^>]*>/i', $c, $imgs);
echo "img tags: " . count($imgs[0]) . "\n";
foreach ($imgs[0] as $img) echo "  IMG: " . $img . "\n";
preg_match_all('/"id":(\d+)/', $c, $ids);
echo "block image ids referenced: " . implode(',', array_unique($ids[1])) . "\n";
preg_match_all('/(https?:[^"\s]+\.(?:jpg|jpeg|png|webp))/i', $c, $urls);
foreach (array_unique($urls[1]) as $u) {
    $rel = str_replace(home_url(), '', $u);
    $path = ABSPATH . ltrim($rel, '/');
    echo "  URL: $u  | file exists: " . (file_exists($path) ? 'YES' : 'NO ('.$path.')') . "\n";
}
