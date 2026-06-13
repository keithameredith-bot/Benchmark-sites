<?php
global $wpdb;
$pid = 64;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = substr_count($c, '"bgColor":"rgba(4,159,130,0.22)"');
$c = str_replace('"bgColor":"rgba(4,159,130,0.22)"', '"bgColor":"#f5f9f8"', $c);
// also round the section corners + give breathing room (loan-grid)
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "softened mint bg ($n replaced) to #f5f9f8\n";
