<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
// find the program-cards section: between "Finding the Right" and "Compare Florida Loan Programs"
$a = stripos($c, 'Finding the Right Florida Loan Program');
$b = stripos($c, 'Compare Florida Loan Programs');
echo "find-section start (heading) at: $a\n";
echo "compare-table start at: $b\n";
echo "section length: " . ($b - $a) . " bytes\n\n";
// the block wrapper start before the heading
$secStart = strrpos(substr($c,0,$a), '<!-- wp:kadence/rowlayout');
$tableStart = strrpos(substr($c,0,$b), '<!-- wp:kadence/rowlayout');
echo "section rowlayout opener at: $secStart\n";
echo "table rowlayout opener at: $tableStart\n\n";
// how many infobox cards in that region + their titles/links
$region = substr($c, $a, $b - $a);
preg_match_all('/kadence\/infobox/', $region, $ib);
echo "infobox cards in find-section: " . count($ib[0]) . "\n";
preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>/i', $region, $links);
$rel = array_unique(array_map(fn($u)=>str_replace(home_url(),'',$u), $links[1]));
echo "linked programs in find-section:\n";
foreach ($rel as $r) echo "  $r\n";
