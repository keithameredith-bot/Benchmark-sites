<?php
// Extend rounded/hover treatment to standard (non-mega) dropdowns + mega refinements.
$css = wp_get_custom_css();
if (strpos($css, '/* BRM standard dropdowns */') !== false) { echo "already added\n"; return; }
$add = '

/* BRM standard dropdowns */
@media (min-width: 1025px) {
  /* regular dropdown panels: rounded card, shadow, gold accent */
  #primary-menu > li.menu-item-has-children:not(.kadence-menu-mega-enabled) > .sub-menu {
    border-radius: 0 0 14px 14px !important;
    box-shadow: 0 22px 50px -20px rgba(15,46,45,.38), 0 2px 0 0 #F5A524 inset !important;
    padding: 14px 12px !important;
    border: 0 !important;
    background: #fff !important;
    min-width: 260px;
  }
  #primary-menu li:not(.kadence-menu-mega-enabled) .sub-menu a {
    border-radius: 8px;
    padding: 9px 12px !important;
    line-height: 1.4;
    transition: background .15s ease, color .15s ease;
  }
  #primary-menu li:not(.kadence-menu-mega-enabled) .sub-menu a:hover {
    background: #eafaf6 !important;
    color: #036b58 !important;
  }
  /* nested flyouts of standard dropdowns: same card look */
  #primary-menu li:not(.kadence-menu-mega-enabled) .sub-menu .sub-menu {
    border-radius: 14px !important;
    box-shadow: 0 22px 50px -20px rgba(15,46,45,.38) !important;
    padding: 12px 10px !important;
    border: 0 !important;
    background: #fff !important;
  }

  /* mega refinements */
  #primary-menu > li.kadence-menu-mega-enabled > .sub-menu { align-items: start; }
  #primary-menu li.kadence-menu-mega-enabled > .sub-menu > li > a { white-space: normal; }
  /* hover bridge: no dead gap between the nav item and the panel */
  #primary-menu > li.kadence-menu-mega-enabled > .sub-menu::before {
    content: ""; position: absolute; left: 0; right: 0; top: -14px; height: 14px;
  }
}
';
wp_update_custom_css_post($css . $add);
wp_cache_flush();
echo "standard dropdown treatment + mega refinements added\n";
