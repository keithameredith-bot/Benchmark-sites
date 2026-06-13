<?php
global $wpdb;
// VA hero: find balanced outer rowlayout boundary
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=88");
$open = '<!-- wp:kadence/rowlayout';
$close = '<!-- /wp:kadence/rowlayout -->';
$start = strpos($c, $open);
$i = $start; $depth = 0; $end = null;
while ($i < strlen($c)) {
    $no = strpos($c, $open, $i);
    $nc = strpos($c, $close, $i);
    if ($nc === false) break;
    if ($no !== false && $no < $nc) { $depth++; $i = $no + strlen($open); }
    else { $depth--; $i = $nc + strlen($close); if ($depth === 0) { $end = $i; break; } }
}
$hero = substr($c, $start, $end - $start);
echo "VA hero block: $start..$end (" . strlen($hero) . " bytes)\n";
echo "byline present in hero: " . (stripos($hero,'Written by')!==false ? 'YES' : 'no') . "\n";
if (preg_match('/Written by[^<]*(<[^>]+>[^<]*)*/i', $hero, $m)) { /* skip */ }
// print readable text lines of hero
$txt = preg_replace('/<!--.*?-->/s','',$hero);
preg_match_all('/<(h1|p|a)[^>]*>(.*?)<\/\1>/is', $txt, $mm, PREG_SET_ORDER);
foreach ($mm as $x) { $t = trim(strip_tags($x[2])); if ($t!=='') echo "  <{$x[1]}> $t\n"; }
echo "\nwhat follows hero (next 120 chars): " . substr($c, $end, 120) . "\n";

// getpre border-radius:0 contexts
echo "\n=== get-pre-approved 'border-radius:0' contexts ===\n";
$gp = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
$off = 0;
while (($p = strpos($gp, 'border-radius:0', $off)) !== false) {
    $sel = substr($gp, max(0,$p-70), 70);
    echo "  ..." . preg_replace('/\s+/',' ',$sel) . "[border-radius:0]\n";
    $off = $p + 10;
}
