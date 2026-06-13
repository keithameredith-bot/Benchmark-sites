<?php
// Fix mega alignment (grid -> flowing CSS columns) + icon specificity bug.
$css = wp_get_custom_css();
$orig = $css;

// 1. grid -> columns on the mega panel
$css = str_replace(
  'display: grid !important; grid-template-columns: repeat(3, 1fr); gap: 6px 44px;',
  'display: block !important; columns: 3; column-gap: 44px;',
  $css);

// 2. li cells: avoid breaking groups across columns; better rhythm
$css = str_replace(
  'display: block; width: auto !important; padding: 0 !important; margin: 0 0 6px !important; border: 0 !important;',
  'display: block; width: auto !important; padding: 0 !important; margin: 0 0 14px !important; border: 0 !important; break-inside: avoid; -webkit-column-break-inside: avoid;',
  $css);

// 3. remove now-useless grid alignment rule
$css = str_replace('#primary-menu > li.kadence-menu-mega-enabled > .sub-menu { align-items: start; }', '', $css);

// 4. icon specificity: per-ID rules must match the base rule's specificity (add .sub-menu)
$css = preg_replace('/#primary-menu \.menu-item-(\d+) > a::before\{content:/', '#primary-menu .sub-menu .menu-item-$1 > a::before{content:', $css);

if ($css !== $orig) { wp_update_custom_css_post($css); wp_cache_flush(); echo "mega columns + icon fix applied\n"; }
else echo "patterns not found\n";
