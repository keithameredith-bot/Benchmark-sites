<?php
global $wpdb;
// About: the dark Meet Keith section — show rowlayout opener attrs
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=70");
$p = strpos($c, 'MEET KEITH');
if ($p === false) $p = strpos($c, 'Meet Keith');
$start = strrpos(substr($c,0,$p), '<!-- wp:kadence/rowlayout');
echo "=== ABOUT meet-keith rowlayout opener ===\n" . substr($c, $start, 700) . "\n\n";

// Contact: first rowlayout (hero) opener + the form section opener
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987513017");
$h = strpos($c, '<!-- wp:kadence/rowlayout');
echo "=== CONTACT hero opener ===\n" . substr($c, $h, 500) . "\n\n";
$f = strpos($c, 'kadence/form');
$fs = strrpos(substr($c,0,$f), '<!-- wp:kadence/rowlayout');
echo "=== CONTACT form-section opener (rowlayout before kadence/form) ===\n" . substr($c, $fs, 500) . "\n\n";
// how many rowlayout closers between? count rowlayout openers in form section vicinity
echo "rowlayout openers total: " . substr_count($c, '<!-- wp:kadence/rowlayout') . ", closers: " . substr_count($c, '<!-- /wp:kadence/rowlayout -->') . "\n";

// Keith page first rowlayout opener
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=164");
$h = strpos($c, '<!-- wp:kadence/rowlayout');
echo "\n=== KEITH hero opener ===\n" . substr($c, $h, 500) . "\n";
