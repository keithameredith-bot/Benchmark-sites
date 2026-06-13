<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515099");
file_put_contents(sys_get_temp_dir() . '/snippet-check.php', "<?php\n" . $c);
echo "dumped to " . sys_get_temp_dir() . "/snippet-check.php (len " . strlen($c) . ")\n";
// check the new entry exists and the array brace context around it
$p = strpos($c, '/florida-physician-loan/');
echo "physician entry context:\n" . substr($c, $p-80, 220) . "\n";
// any wpcode cache options?
$opts = $wpdb->get_results("SELECT option_name, LENGTH(option_value) AS len FROM {$wpdb->options} WHERE option_name LIKE '%wpcode%' OR option_name LIKE '%ihaf%'");
foreach ($opts as $o) echo "option: {$o->option_name} (len {$o->len})\n";
