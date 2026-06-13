<?php
global $wpdb;
foreach (array('florida-mobile-home-financing'=>'manufactured-form.html','florida-construction-loan'=>'construction-form.html') as $slug=>$file) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    $c = str_replace($file.'?v=1', $file.'?v=2', $row->post_content);
    if ($c !== $row->post_content) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID)); clean_post_cache($row->ID); echo "$slug: v=2\n"; }
    else echo "$slug: no v=1 found\n";
}
wp_cache_flush();
