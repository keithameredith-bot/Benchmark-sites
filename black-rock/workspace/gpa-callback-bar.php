<?php
// Get-pre-approved page: callback bar between formhead and iframe (light version, page is its own design).
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
if (strpos($c, 'brm-callback') !== false) { echo "already\n"; return; }
$anchor = '<iframe id="brmPreapproval"';
$bar = '<div class="brm-callback" style="display:flex;align-items:center;gap:10px;margin:0 0 14px;background:#f4faf8;border:1px solid #d9ece7;border-radius:10px;padding:12px 18px;"><style>@keyframes brmPulse{0%{box-shadow:0 0 0 0 rgba(4,159,130,.55);}70%{box-shadow:0 0 0 9px rgba(4,159,130,0);}100%{box-shadow:0 0 0 0 rgba(4,159,130,0);}}</style><span style="width:10px;height:10px;border-radius:50%;background:#049F82;animation:brmPulse 2s infinite;flex:0 0 auto;"></span><span style="font-family:Karla,sans-serif;font-size:14.5px;color:#353535;">You can expect a call back the <strong style="color:#037a64;">same business day</strong> &mdash; no later than the next.</span></div>
  ' . $anchor;
$c = preg_replace('/' . preg_quote($anchor, '/') . '/', $bar, $c, 1);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>74));
clean_post_cache(74);
wp_cache_flush();
echo "GPA callback bar added\n";
