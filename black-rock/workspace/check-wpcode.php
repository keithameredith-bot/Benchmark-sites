<?php
global $wpdb;
$metas = $wpdb->get_results("SELECT meta_key, LEFT(meta_value,80) AS v, LENGTH(meta_value) AS len FROM {$wpdb->postmeta} WHERE post_id=987515099");
foreach ($metas as $m) echo "{$m->meta_key} (len {$m->len}): {$m->v}\n";
// does post_content contain physician now?
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515099");
echo "\npost_content has physician: " . (strpos($c,'florida-physician-loan')!==false?'yes':'no') . " (len " . strlen($c) . ")\n";
