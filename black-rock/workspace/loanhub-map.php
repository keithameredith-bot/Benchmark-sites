<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
// offsets of headings, infoboxes, html blocks, hero
function offs($c, $needle) { $r=array(); $o=0; while(($p=stripos($c,$needle,$o))!==false){$r[]=$p;$o=$p+1;} return $r; }
echo "HERO (brm-hero): " . implode(',', offs($c,'class="brm-hero"')) . "\n";
echo "/wp:html closers: " . count(offs($c,'<!-- /wp:html -->')) . " at " . implode(',', array_slice(offs($c,'<!-- /wp:html -->'),0,6)) . "\n";
echo "infoboxes at: " . implode(',', offs($c,'kadence/infobox')) . "\n";
echo "HEADINGS w/ offset:\n";
preg_match_all('/<h([12])[^>]*>(.*?)<\/h\1>/is', $c, $m, PREG_OFFSET_CAPTURE);
foreach ($m[0] as $i=>$mm) echo "  @" . $mm[1] . "  h" . $m[1][$i][0] . ": " . trim(strip_tags($m[2][$i][0])) . "\n";
// all program links currently in page
preg_match_all('/href="([^"]*\/(conventional|fha|va-home|florida-usda|jumbo|hometown|down-payment|mobile-home|construction|self-employed|bank-statement|non-qm|dscr|physician|condo|cash-out|equity|reverse|refinance|buydown|streamline|singlewide|manufactured)[^"]*)"/i', $c, $pl);
$rel = array_unique(array_map(fn($u)=>str_replace(home_url(),'',$u), $pl[1]));
echo "\nPROGRAM LINKS CURRENTLY ON PAGE (" . count($rel) . "):\n";
foreach ($rel as $r) echo "  $r\n";
