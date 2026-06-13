<?php
// Manufactured menu icons: truck (1F69A) -> houses/community (1F3D8 FE0F) on items 615 + 16316.
$css = wp_get_custom_css();
$n = 0;
foreach (array(615, 16316) as $id) {
    $old = "#primary-menu .sub-menu .menu-item-$id > a::before{content:\"\\1F69A\";}";
    $new = "#primary-menu .sub-menu .menu-item-$id > a::before{content:\"\\1F3D8\\FE0F\";}";
    if (strpos($css, $old) !== false) { $css = str_replace($old, $new, $css); $n++; }
}
if ($n) { wp_update_custom_css_post($css); wp_cache_flush(); }
echo "swapped $n truck icons to houses\n";
