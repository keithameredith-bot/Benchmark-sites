<?php
global $wpdb;
// Home Buyers Guide
$hbg = $wpdb->get_row("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name='home-buyers-survival-guide' AND post_status='publish'");
if ($hbg) {
    $hasRow = strpos($hbg->post_content,'wp:kadence/rowlayout')!==false;
    $hasHero = strpos($hbg->post_content,'class="brm-hero"')!==false;
    $h1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/s',$hbg->post_content,$m)?trim(strip_tags($m[1])):'(none)';
    echo "Home Buyers Guide (id {$hbg->ID}): kadence-rowlayout-hero:".($hasRow?'Y':'n')." brm-hero:".($hasHero?'Y':'n')." H1:'$h1'\n";
    // bg color of first rowlayout
    if (preg_match('/"bgColor":"([^"]+)"/', substr($hbg->post_content,0,1500),$mm)) echo "  hero bgColor: {$mm[1]}\n";
    if (preg_match('/"bgImg":"([^"]+)"/', substr($hbg->post_content,0,1500),$mm)) echo "  hero bgImg: ".basename($mm[1])."\n";
}
// pages that may 404 from menu
echo "\nPages check:\n";
foreach (array('states-we-are-licensed','licensed-states','where-we-lend','work-with-us','reviews','client-reviews','testimonials') as $s) {
    $r = $wpdb->get_row($wpdb->prepare("SELECT ID, post_status FROM {$wpdb->posts} WHERE post_name=%s AND post_type='page'", $s));
    echo "  /$s/ : ".($r?"EXISTS (id {$r->ID}, {$r->post_status})":"MISSING")."\n";
}
// menu items that point to non-existent / # urls
echo "\nMenu items (Main Page, term 2) with suspicious URLs:\n";
$items = wp_get_nav_menu_items(2);
foreach ($items as $it) {
    $u = str_replace(home_url(),'',$it->url);
    if ($u==='#' || $u==='' || stripos($it->url,'work-with-us')!==false || stripos($it->url,'review')!==false || stripos($it->url,'licens')!==false || stripos($it->url,'state')!==false) {
        echo "  '{$it->title}' -> {$u} (obj:{$it->object} id:{$it->object_id} status:".get_post_status($it->object_id).")\n";
    }
}
// footer: kadence footer html/buttons in theme mods?
echo "\nFooter:\n";
$mods = get_option('theme_mods_kadence');
echo "  kadence footer present in theme_mods: ".(is_array($mods)?'yes':'no')."\n";
