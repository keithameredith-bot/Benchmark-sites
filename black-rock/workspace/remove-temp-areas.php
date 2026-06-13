<?php
$css = wp_get_custom_css();
$css = preg_replace('/\n*\/\* BRM TEMP areas-open \*\/.*?(?=\n\/\*|$)/s', '', $css);
wp_update_custom_css_post($css);
wp_cache_flush();
echo "temp removed\n";
