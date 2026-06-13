<?php
// Make ALL form iframe srcs relative (absolute .local URLs break phone/LiveLink testing and are push hazards).
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%http://black-rock-mortgage.local/wp-content/uploads/forms/%'");
foreach ($rows as $r) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $r->ID));
    $c2 = str_replace('http://black-rock-mortgage.local/wp-content/uploads/forms/', '/wp-content/uploads/forms/', $c);
    if ($c2 !== $c) {
        $wpdb->update($wpdb->posts, array('post_content'=>$c2), array('ID'=>$r->ID));
        clean_post_cache($r->ID);
        echo "fixed /{$r->post_name}/\n";
    }
}
wp_cache_flush();
echo "done — " . count($rows) . " pages scanned\n";
