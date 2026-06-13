<?php
global $wpdb;
$pid = 38;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$orig = $c;
// restore the missing backslash on the decorative quote glyphs
$c = str_replace('content: "201C"', 'content: "\201C"', $c);
$c = str_replace('content: "201D"', 'content: "\201D"', $c);
$c = str_replace("content:\"201C\"", "content:\"\\201C\"", $c);
$c = str_replace("content:\"201D\"", "content:\"\\201D\"", $c);
if ($c !== $orig) {
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "homepage decorative quote fixed (201C/201D -> escaped glyphs)\n";
} else {
    echo "no change (pattern not matched)\n";
}
