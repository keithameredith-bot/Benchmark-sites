<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=56");
$from = "Counties like Broward have a limit of \$659,121";
$to = "Counties like Broward have a limit of \$667,000";
if (strpos($c, $from) !== false) { $c = str_replace($from, $to, $c); $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>56)); clean_post_cache(56); echo "Broward -> \$667,000\n"; }
else echo (strpos($c,$to)!==false ? "already fixed\n" : "not found - dump: " . (preg_match('/Broward[^.<]{0,60}/', $c, $m) ? $m[0] : 'no Broward mention') . "\n");
