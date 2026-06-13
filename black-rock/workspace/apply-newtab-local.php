<?php
update_post_meta(987515491, '_menu_item_target', '_blank');
$xfn = get_post_meta(987515491, '_menu_item_xfn', true);
if (strpos((string)$xfn, 'noopener') === false) update_post_meta(987515491, '_menu_item_xfn', trim($xfn . ' noopener'));
clean_post_cache(987515491);
wp_cache_flush();
echo "local: Apply Now menu item -> target=" . get_post_meta(987515491,'_menu_item_target',true) . " xfn=" . get_post_meta(987515491,'_menu_item_xfn',true) . "\n";
