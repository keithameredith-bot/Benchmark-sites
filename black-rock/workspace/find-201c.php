<?php
global $wpdb;
// find posts/blocks containing "Meet Your Broker" or "201C" or a content: quote rule
$rows = $wpdb->get_results("SELECT ID, post_type, post_status, post_title FROM {$wpdb->posts} WHERE post_content LIKE '%Meet Your Broker%' OR post_content LIKE '%201C%' OR post_content LIKE '%201c%' OR post_content LIKE '%Producing Branch President%'");
foreach ($rows as $r) {
    if ($r->post_status==='inherit') continue;
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID={$r->ID}");
    $has201 = (stripos($c,'201c')!==false);
    $hasMeet = (stripos($c,'Meet Your Broker')!==false);
    echo "[{$r->ID}] {$r->post_type}/{$r->post_status}: {$r->post_title} | 201c:".($has201?'Y':'n')." meetBroker:".($hasMeet?'Y':'n')."\n";
    if ($has201) {
        $p = stripos($c,'201c');
        echo "   201c ctx: ..." . preg_replace('/\s+/',' ', substr($c, max(0,$p-60), 130)) . "...\n";
    }
}
// also check Customizer additional CSS
$css = wp_get_custom_css();
if (stripos($css,'201c')!==false){ $p=stripos($css,'201c'); echo "CUSTOMIZER CSS has 201c: ...".substr($css,max(0,$p-60),130)."...\n"; }
else echo "Customizer CSS: no 201c\n";
