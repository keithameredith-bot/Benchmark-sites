<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=64");
// all rowlayout openers with their bgColor + uniqueID, in order, up to the compare table
$compare = strpos($c, 'Compare Florida Loan Programs');
$o = 0;
while (($p = strpos($c, '<!-- wp:kadence/rowlayout', $o)) !== false && $p < $compare) {
    $seg = substr($c, $p, 400);
    preg_match('/"uniqueID":"([^"]+)"/', $seg, $u);
    preg_match('/"bgColor":"([^"]+)"/', $seg, $bg);
    preg_match('/"bgColorClass":"([^"]+)"/', $seg, $bgc);
    echo "@$p id=" . ($u[1]??'?') . " bg=" . ($bg[1]??'-') . " class=" . ($bgc[1]??'-') . "\n";
    $o = $p + 10;
}
