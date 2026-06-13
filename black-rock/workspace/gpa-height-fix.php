<?php
global $wpdb;
$pid = 74;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, "e.data.brm===\"height\"") !== false || strpos($c, 'e.data.brm==="height"') !== false) { echo "height listener already present\n"; return; }
if (!get_post_meta($pid, '_brm_gpaheight_backup', true)) add_post_meta($pid, '_brm_gpaheight_backup', wp_slash($c), true);

$anchor = '<iframe id="brmPreapproval" src="/wp-content/uploads/forms/preapproval-form.html?v=2" scrolling="no" loading="eager" title="See what you qualify for - Black Rock Mortgage"></iframe>';
$script = $anchor . '
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){window.addEventListener("message",function(e){if(!e.data)return;if(e.data.brm==="height"){var f=document.getElementById("brmPreapproval");if(f&&e.data.h){f.style.height=e.data.h+"px";}}});})();
</script>';
if (strpos($c, $anchor) === false) { echo "iframe anchor not found (src may differ)\n"; return; }
$c = str_replace($anchor, $script, $c);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
file_put_contents('C:/Users/keith/AppData/Local/Temp/gpa-content.html', $c);
echo "height-sync listener added to get-pre-approved (page 74)\n";
