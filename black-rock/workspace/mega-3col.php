<?php
$css = wp_get_custom_css();
$from = 'display: grid !important; grid-template-columns: repeat(4, 1fr); gap: 4px 36px;';
$to   = 'display: grid !important; grid-template-columns: repeat(3, 1fr); gap: 6px 44px;';
if (strpos($css, $from) !== false) { $css = str_replace($from, $to, $css); wp_update_custom_css_post($css); wp_cache_flush(); echo "mega -> 3 columns\n"; }
elseif (strpos($css, $to) !== false) echo "already 3 cols\n";
else echo "pattern not found\n";
