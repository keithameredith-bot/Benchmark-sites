<?php
// 1. Pulsing-dot callback bar above consumer forms (dark version in brm-prog-cta, light on contact).
// 2. Mobile-drawer "Apply Now" button -> my1003app portal.
global $wpdb;

$darkBar = '<div class="brm-callback" style="display:flex;align-items:center;gap:10px;max-width:1000px;margin:0 auto 14px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);border-radius:10px;padding:12px 18px;"><style>@keyframes brmPulse{0%{box-shadow:0 0 0 0 rgba(93,202,165,.7);}70%{box-shadow:0 0 0 9px rgba(93,202,165,0);}100%{box-shadow:0 0 0 0 rgba(93,202,165,0);}}</style><span style="width:10px;height:10px;border-radius:50%;background:#5dcaa5;animation:brmPulse 2s infinite;flex:0 0 auto;"></span><span style="font-family:Karla,sans-serif;font-size:14.5px;color:#e8f5f1;">You can expect a call back the <strong style="color:#7be3c4;">same business day</strong> &mdash; no later than the next.</span></div>
    <div class="brm-prog-cta-form-wrap">';

// all pages with the prog-cta form wrap
$rows = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%brm-prog-cta-form-wrap%'");
$done = 0;
foreach ($rows as $r) {
    $c = $r->post_content;
    if (strpos($c, 'brm-callback') !== false) continue;
    $c2 = str_replace('<div class="brm-prog-cta-form-wrap">', $darkBar, $c);
    if ($c2 !== $c) {
        $wpdb->update($wpdb->posts, array('post_content'=>$c2), array('ID'=>$r->ID));
        clean_post_cache($r->ID);
        $done++;
    }
}
echo "dark callback bar added on $done pages\n";

// contact page (light)
$row = $wpdb->get_row("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name='contact' AND post_status='publish' AND post_type='page'");
if ($row && strpos($row->post_content, 'brm-callback') === false) {
    $lightBar = '<div class="brm-callback" style="display:flex;align-items:center;gap:10px;margin:0 0 14px;background:#f4faf8;border:1px solid #d9ece7;border-radius:10px;padding:12px 18px;"><style>@keyframes brmPulse{0%{box-shadow:0 0 0 0 rgba(4,159,130,.55);}70%{box-shadow:0 0 0 9px rgba(4,159,130,0);}100%{box-shadow:0 0 0 0 rgba(4,159,130,0);}}</style><span style="width:10px;height:10px;border-radius:50%;background:#049F82;animation:brmPulse 2s infinite;flex:0 0 auto;"></span><span style="font-family:Karla,sans-serif;font-size:14.5px;color:#353535;">You can expect a reply the <strong style="color:#037a64;">same business day</strong> &mdash; no later than the next.</span></div>
  <iframe id="brmContact"';
    $c = str_replace('<iframe id="brmContact"', $lightBar, $row->post_content);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID));
    clean_post_cache($row->ID);
    echo "light bar on contact\n";
}

// get-pre-approved page (74) — check structure
$row = $wpdb->get_row("SELECT ID, post_content FROM {$wpdb->posts} WHERE ID=74");
if ($row) {
    if (strpos($row->post_content, 'brm-callback') !== false) echo "GPA already has bar\n";
    elseif (strpos($row->post_content, 'brm-prog-cta-form-wrap') !== false) echo "GPA matched prog-cta pattern (covered above)\n";
    else {
        $p = strpos($row->post_content, '<iframe');
        echo "GPA iframe context: " . substr($row->post_content, max(0,$p-200), 320) . "\n";
    }
}

// 2. mobile-drawer Apply Now button (menu item + CSS)
$items = wp_get_nav_menu_items(2);
$have = false;
foreach ($items as $it) if (stripos($it->title, 'Apply Now') !== false) $have = true;
if (!$have) {
    $mid = wp_update_nav_menu_item(2, 0, array(
        'menu-item-title' => 'Apply Now — Full Application',
        'menu-item-url' => 'https://coast2coastmortgage.my1003app.com/303217/register',
        'menu-item-status' => 'publish', 'menu-item-type' => 'custom',
    ));
    echo "Apply Now menu item added ($mid)\n";
    $css = wp_get_custom_css();
    if (strpos($css, '/* BRM mobile apply */') === false) {
        $css .= "

/* BRM mobile apply */
/* desktop nav: hide it (header already has See My Options) */
@media (min-width: 1025px){ #primary-menu .menu-item-$mid { display: none !important; } }
/* mobile drawer: style as gold button */
@media (max-width: 1024px){
.mobile-navigation .menu-item-$mid > a, #mobile-menu .menu-item-$mid > a, .drawer-nav-drop-wrap .menu-item-$mid > a{
  background:#F5A524 !important;color:#1a1a1a !important;font-family:Rubik,sans-serif;font-weight:700 !important;
  border-radius:8px;margin:14px 16px;text-align:center;justify-content:center;
  padding:14px 18px !important;letter-spacing:.02em;
}
.mobile-navigation .menu-item-$mid > a:hover{background:#ffb944 !important;}
}
";
        wp_update_custom_css_post($css);
        echo "mobile apply button CSS added\n";
    }
}
wp_cache_flush();
echo "done\n";
