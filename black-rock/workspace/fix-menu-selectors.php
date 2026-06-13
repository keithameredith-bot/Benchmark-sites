<?php
// Fix the mega-menu polish: #main-menu (wrong) -> #primary-menu (Kadence's actual id).
$css = wp_get_custom_css();
$n = substr_count($css, '#main-menu');
$css = str_replace('#main-menu', '#primary-menu', $css);
wp_update_custom_css_post($css);
wp_cache_flush();
echo "replaced $n #main-menu selectors with #primary-menu\n";
