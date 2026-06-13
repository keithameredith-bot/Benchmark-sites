<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=18179");
$i = strpos($c, '<details');
echo "first <details at $i:\n";
echo substr($c, $i, 700);
