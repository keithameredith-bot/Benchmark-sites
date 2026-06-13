<?php
// Smooth-scroll in-page anchors without polluting the URL hash (fixes refresh-jumps-to-form).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brmWwuAnchors') !== false) { echo "already patched\n"; return; }

$marker = '(function(){
  window.addEventListener("message", function(e){';
$patch = '(function(){
  /* smooth-scroll page anchors without setting location.hash, so a refresh
     starts at the top instead of jumping back to the form */
  window.brmWwuAnchors = true;
  document.addEventListener("click", function(e){
    var a = e.target.closest(\'a[href^="#"]\');
    if (!a) return;
    var t = document.getElementById(a.getAttribute("href").slice(1));
    if (!t) return;
    e.preventDefault();
    t.scrollIntoView({behavior:"smooth", block:"start"});
    if (location.hash) { history.replaceState(null, "", location.pathname + location.search); }
  });
  /* if a hash is already in the URL from an old link, clear it after first paint */
  if (location.hash) { history.replaceState(null, "", location.pathname + location.search); }
  window.addEventListener("message", function(e){';
$c = str_replace($marker, $patch, $c);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "anchor fix applied\n";
