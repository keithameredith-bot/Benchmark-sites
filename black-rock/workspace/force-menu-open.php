<?php
// TEMP: force the Loans mega menu open WITHOUT touching display (keeps grid). Remove after.
$css = wp_get_custom_css();
// remove any prior temp first
$css = preg_replace('/\n*\/\* BRM TEMP menu-open \*\/\n[^\n]*\n?/s', '', $css);
$add = '

/* BRM TEMP menu-open */
#primary-menu .menu-item-66 > .sub-menu{opacity:1 !important;visibility:visible !important;transform:none !important;pointer-events:auto !important;}
';
wp_update_custom_css_post($css . $add);
wp_cache_flush();
echo "Loans menu forced open (grid-safe)\n";
