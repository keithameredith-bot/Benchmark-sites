<?php
// Add the UWM logo to the Platinum section header + the stack strip.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// 1. logo into the UWM section, beside the heading (white card chip so the blue logo reads on dark)
$old = '<h2 style="color:#fff;">Platinum with UWM &mdash; the #1 lender in America</h2>';
$new = '<div style="display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap;margin:0 0 6px;"><span style="background:#fff;border-radius:10px;padding:10px 18px;display:inline-flex;align-items:center;"><img src="/wp-content/uploads/wwu/logo-uwm.webp" alt="United Wholesale Mortgage" style="height:34px !important;width:auto !important;object-fit:contain;" loading="lazy"></span><span style="background:#F5A524;color:#1a1a1a;font-family:Rubik,sans-serif;font-weight:800;font-size:13px;letter-spacing:.1em;text-transform:uppercase;border-radius:999px;padding:8px 18px;">Platinum Status</span></div>
    <h2 style="color:#fff;">Platinum with UWM &mdash; the #1 lender in America</h2>';
if (strpos($c, 'logo-uwm') === false && strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

// 2. add UWM to the stack strip
$old = '<img src="/wp-content/uploads/wwu/logo-morethanink.webp" alt="More Than Ink business cards" loading="lazy">';
$new = $old . '
      <img src="/wp-content/uploads/wwu/logo-uwm.webp" alt="UWM - United Wholesale Mortgage" loading="lazy">';
if (substr_count($c, 'logo-uwm') < 2 && strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "UWM logo placed: $n spots\n";
