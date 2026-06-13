<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_type FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND (post_content LIKE '%brmPreapproval%' OR post_content LIKE '%brmContact%' OR post_content LIKE '%brmRecruit%')");
echo "Pages with a form iframe:\n";
foreach ($rows as $r) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $r->ID));
    $hasListener = strpos($c, 'f.style.height') !== false;
    $flag = $hasListener ? 'OK' : '*** MISSING LISTENER ***';
    echo sprintf("  [%d] /%s/  %s\n", $r->ID, $r->post_name, $flag);
}
