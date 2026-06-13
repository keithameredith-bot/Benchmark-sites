<?php
global $wpdb;
foreach (array('about-us','keith-meredith','contact') as $slug) {
    $p = $wpdb->get_row($wpdb->prepare("SELECT ID, post_title, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_type='page' AND post_status='publish'", $slug));
    if (!$p) { echo "MISS $slug\n\n"; continue; }
    $c = $p->post_content;
    echo "=== [{$p->ID}] /$slug/ \"{$p->post_title}\" (" . strlen($c) . " bytes) ===\n";
    echo "brm-hero: " . (strpos($c,'brm-hero')!==false?'YES':'no') . "\n";
    // first 3 block types
    preg_match_all('/<!-- wp:([a-z\/\-]+)/', $c, $m);
    echo "first blocks: " . implode(', ', array_slice($m[1],0,8)) . "\n";
    // h1/h2s
    preg_match_all('/<h([12])[^>]*>(.*?)<\/h\1>/is', $c, $h, PREG_SET_ORDER);
    foreach (array_slice($h,0,6) as $hh) echo "  h{$hh[1]}: " . trim(strip_tags($hh[2])) . "\n";
    // forms: shortcodes or form blocks
    if (preg_match_all('/\[([a-z0-9_\-]+)[^\]]*\]/', $c, $sc)) echo "shortcodes: " . implode(', ', array_unique($sc[1])) . "\n";
    foreach (array('wpforms','contact-form-7','kadence/form','gravityform','wp:html') as $f) if (stripos($c,$f)!==false) echo "contains: $f\n";
    echo "\n";
}
// active form plugins
echo "=== form-ish active plugins ===\n";
foreach ((array)get_option('active_plugins') as $pl) if (preg_match('/form|spam|captcha/i',$pl)) echo "  $pl\n";
