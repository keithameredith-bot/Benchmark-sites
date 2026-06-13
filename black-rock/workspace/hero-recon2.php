<?php
global $wpdb;
foreach (array(88=>'VA', 67=>'Ocala') as $pid=>$name) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    echo "=== $name ($pid) ===\n";
    // hero rowlayout start + first close
    $rs = strpos($c, '<!-- wp:kadence/rowlayout');
    $re = strpos($c, '<!-- /wp:kadence/rowlayout -->');
    echo "rowlayout #1: start=$rs firstClose=$re\n";
    $hero = substr($c, $rs, $re - $rs + 30);
    // count nested rowlayouts inside
    echo "nested rowlayout opens before first close: " . substr_count(substr($c,$rs,$re-$rs),'<!-- wp:kadence/rowlayout') . "\n";
    // H1
    if (preg_match('/"level":1[^>]*-->\s*<h1[^>]*>(.*?)<\/h1>/s', $hero, $m) || preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $hero, $m)) echo "H1: " . trim(strip_tags($m[1])) . "\n";
    // eyebrow (first p advancedheading)
    if (preg_match('/<p class="kt-adv-heading[^>]*>(.*?)<\/p>/s', $hero, $m)) echo "eyebrow: " . trim(strip_tags($m[1])) . "\n";
    // byline
    if (preg_match('/Written by[^<]*/i', $hero, $m)) echo "byline: " . trim($m[0]) . "\n"; else echo "byline: (not in hero block)\n";
    // CTAs
    preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/s', $hero, $b, PREG_SET_ORDER);
    foreach ($b as $x) echo "  cta: '" . trim(strip_tags($x[2])) . "' -> " . $x[1] . "\n";
    echo "\n";
}
// get-pre-approved square buttons
$gp = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
echo "=== get-pre-approved button border-radius occurrences ===\n";
preg_match_all('/border-radius:\s*([0-9a-z ]+)/i', $gp, $br);
$counts = array_count_values(array_map('trim',$br[1]));
foreach ($counts as $v=>$n) echo "  border-radius: $v  (x$n)\n";
