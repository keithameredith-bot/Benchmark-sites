<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
echo "=== around 'loan programs' h2 (10968) — show 10600..11200 ===\n";
echo substr($c, 10600, 600) . "\n\n";
echo "=== before 'Compare' table (57628) — show 57100..57720 ===\n";
echo substr($c, 57100, 620) . "\n\n";
echo "=== first wp:rowlayout after stats: openers between 8500 and 11000 ===\n";
$o=8500; while(($p=strpos($c,'<!-- wp:kadence/rowlayout',$o))!==false && $p<11500){ echo "  rowlayout opener @ $p: " . substr($c,$p,90) . "\n"; $o=$p+10; }
echo "\n=== rowlayout opener immediately before Compare table heading ===\n";
$tp = strrpos(substr($c,0,57628), '<!-- wp:kadence/rowlayout');
echo "  @ $tp: " . substr($c,$tp,90) . "\n";
