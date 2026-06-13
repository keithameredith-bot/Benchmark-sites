<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
$orig = $c;
// round the 3 square button classes (border-radius:0 -> 6px) — site standard is 6px
$c = str_replace(
  array(
    "color: #fff !important; padding: 18px 42px; border-radius: 0;",
    "color: #fff !important; padding: 14px 28px; border-radius: 0;",
    "var(--global-palette1, #007e79); padding: 12px 28px; border-radius: 0;",
  ),
  array(
    "color: #fff !important; padding: 18px 42px; border-radius: 6px;",
    "color: #fff !important; padding: 14px 28px; border-radius: 6px;",
    "var(--global-palette1, #007e79); padding: 12px 28px; border-radius: 6px;",
  ),
  $c
);
$changed = ($c !== $orig);
if ($changed) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>74)); clean_post_cache(74); }
// report remaining border-radius: 0 in button rules
$left = preg_match_all('/border-radius:\s*0;/', $c);
echo ($changed ? "rounded pa-btn buttons to 6px" : "no change") . " | remaining 'border-radius: 0;': $left\n";
