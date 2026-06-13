<?php
// TEMP: force open "Areas We Serve" (standard dropdown, item 987515428) for screenshot.
$css = wp_get_custom_css();
if (strpos($css, '/* BRM TEMP areas-open */') !== false) { echo "already\n"; return; }
$add = '

/* BRM TEMP areas-open */
#primary-menu .menu-item-987515428 > .sub-menu{opacity:1 !important;visibility:visible !important;transform:none !important;pointer-events:auto !important;display:block !important;clip:auto !important;clip-path:none !important;}
';
wp_update_custom_css_post($css . $add);
wp_cache_flush();
echo "areas dropdown forced open\n";
