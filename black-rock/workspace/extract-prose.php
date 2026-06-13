<?php
// Print readable prose (paragraphs, list items, headings, accordion Q/A) from a post, in order.
global $wpdb;
$pid = (int) $args[0];
$c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
// strip block comments + style/script
$c = preg_replace('/<!--.*?-->/s', '', $c);
$c = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $c);
$c = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $c);
// pull headings, paragraphs, list items, accordion titles
preg_match_all('/<(h[1-4]|p|li)[^>]*>(.*?)<\/\1>/is', $c, $m, PREG_SET_ORDER);
foreach ($m as $x) {
    $tag = strtolower($x[1]);
    $t = trim(preg_replace('/\s+/', ' ', strip_tags($x[2])));
    if ($t === '') continue;
    if ($tag[0] === 'h') echo "\n## $t\n";
    elseif ($tag === 'li') echo " - $t\n";
    else echo "$t\n";
}
