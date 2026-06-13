<?php
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$s = strpos($c, '<!-- HOWTO -->');
$e = strpos($c, '<!-- PAIN -->');
if ($s === false || $e === false || $e < $s) { echo "markers not found\n"; return; }
$removed = $e - $s;
$c = substr($c, 0, $s) . substr($c, $e); // drop HOWTO..PAIN, keeps <!-- PAIN -->
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
file_put_contents('C:/Users/keith/AppData/Local/Temp/wwu-nohowto.html', $c);
echo "how-to section removed ($removed bytes). Conversion flow restored: hero -> c2c band -> stats -> PAIN.\n";
echo "still present: slug=become-a-mortgage-broker, FAQ schema=" . (strpos($c,'FAQPage')!==false?'yes':'no') . ", share-hide=" . (strpos($c,'page-id-18179 .brm-share')!==false?'yes':'no') . "\n";
