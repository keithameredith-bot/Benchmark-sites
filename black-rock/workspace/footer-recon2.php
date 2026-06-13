<?php
$mods = get_option('theme_mods_kadence');
echo "footer_items: " . json_encode($mods['footer_items'] ?? null) . "\n\n";
// widget areas
global $wpdb;
$sidebars = get_option('sidebars_widgets');
foreach ($sidebars as $area => $widgets) {
    if (stripos($area,'footer')===false || !is_array($widgets)) continue;
    echo "AREA $area: " . json_encode($widgets) . "\n";
}
// widget_block contents
$blocks = get_option('widget_block');
if (is_array($blocks)) {
    foreach ($blocks as $k => $b) {
        if (!is_array($b) || empty($b['content'])) continue;
        $txt = preg_replace('/\s+/',' ', strip_tags($b['content']));
        echo "widget_block[$k]: " . substr($txt,0,110) . "\n";
        if (stripos($b['content'],'button')!==false || stripos($b['content'],'See My Options')!==false) {
            echo "   RAW: " . substr(preg_replace('/\s+/',' ',$b['content']),0,400) . "\n";
        }
    }
}
