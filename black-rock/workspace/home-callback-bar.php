<?php
// Homepage: dark callback bar above its custom final-form wrap.
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
if (strpos($c, 'brm-callback') !== false) { echo "already\n"; return; }
$anchor = '<div class="brm-home-final-form-wrap">';
$bar = '<div class="brm-callback" style="display:flex;align-items:center;gap:10px;max-width:1000px;margin:0 auto 14px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);border-radius:10px;padding:12px 18px;"><style>@keyframes brmPulse{0%{box-shadow:0 0 0 0 rgba(93,202,165,.7);}70%{box-shadow:0 0 0 9px rgba(93,202,165,0);}100%{box-shadow:0 0 0 0 rgba(93,202,165,0);}}</style><span style="width:10px;height:10px;border-radius:50%;background:#5dcaa5;animation:brmPulse 2s infinite;flex:0 0 auto;"></span><span style="font-family:Karla,sans-serif;font-size:14.5px;color:#e8f5f1;">You can expect a call back the <strong style="color:#7be3c4;">same business day</strong> &mdash; no later than the next.</span></div>
      ' . $anchor;
if (strpos($c, $anchor) === false) { echo "anchor missing\n"; return; }
$c = str_replace($anchor, $bar, $c);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>38));
clean_post_cache(38);
wp_cache_flush();
echo "homepage callback bar added\n";
