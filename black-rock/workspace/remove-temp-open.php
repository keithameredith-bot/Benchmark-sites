<?php
$css = wp_get_custom_css();
$css = preg_replace('/\n*\/\* BRM TEMP menu-open \*\/.*?(?=\n\/\*|$)/s', '', $css);
wp_update_custom_css_post($css);
wp_cache_flush();
echo "temp force-open removed; menu now hover-only\n";
