<?php
global $wpdb;
// police-officers: H1 present? has Kadence hero?
$pol = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=15780");
echo "POLICE (15780): has <h1>: ".(stripos($pol,'<h1')!==false?'y':'n')." | has kadence rowlayout: ".(strpos($pol,'wp:kadence/rowlayout')!==false?'y':'n')." | has brm-prog-cta form: ".(strpos($pol,'brm-prog-cta')!==false?'y':'n')."\n";

// About (70), Our Team (548): hero structure
foreach (array(70=>'About', 548=>'OurTeam') as $pid=>$name) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    $rs = strpos($c,'<!-- wp:kadence/rowlayout');
    $bg = preg_match('/"bgImg":"([^"]+)"/', substr($c,0,2000), $m) ? $m[1] : '(none)';
    $h1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $c, $mm) ? trim(strip_tags($mm[1])) : '(no h1)';
    echo "$name ($pid): firstRowlayout@$rs | heroBgImg: ".basename($bg)." | H1: $h1\n";
}

// homepage hero CSS class
$h = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
$hi = strpos($h,'.brm-home-hero {');
echo "\nHOMEPAGE .brm-home-hero rule:\n" . substr($h,$hi, 360) . "\n";
