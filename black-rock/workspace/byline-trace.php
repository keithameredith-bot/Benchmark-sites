<?php
global $wpdb;
$va = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=88");
echo "VA references block 987515105: " . (strpos($va,'987515105')!==false?'YES':'no') . "\n";
if (($p=strpos($va,'987515105'))!==false) echo "  context: ..." . substr($va,$p-80,160) . "...\n";
echo "VA references block 987514146 (author bio): " . (strpos($va,'987514146')!==false?'YES':'no') . "\n";
// where does the hero close and what's the first ~600 chars after it
$close='<!-- /wp:kadence/rowlayout -->'; $heroEnd = 3635;
echo "\nVA content right after hero (chars 3635-4300):\n" . substr($va,3635,665) . "\n";

echo "\n=== Author Byline block 987515105 (first 700) ===\n";
echo substr($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515105"),0,700) . "\n";

echo "\n=== wpcode snippet 987515099 (first 500) ===\n";
echo substr($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515099"),0,500) . "\n";
