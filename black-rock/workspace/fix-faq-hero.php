<?php
global $wpdb;
$pid = 31;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$orig = $c;

// 1. constrain the FAQ hero to match the 820px blog content (not full width)
$c = str_replace('<div class="brm-hero">', '<div class="brm-hero" style="max-width:820px;margin:0 auto;">', $c);

// 2. remove the redundant subhead from the hero (the brm-blog subtitle below covers it)
$c = preg_replace('/\s*<p class="sub">Straight answers[^<]*<\/p>/', '', $c, 1);

if ($c !== $orig) {
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "FAQ hero: constrained to 820px + subhead removed\n";
} else {
    echo "FAQ hero: no change (patterns not matched)\n";
}
