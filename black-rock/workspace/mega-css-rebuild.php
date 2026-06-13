<?php
// Replace my mega-menu polish with a COMPLETE CSS-driven mega menu layout
// (Kadence's own mega rendering isn't producing columns — we take over on .kadence-menu-mega-enabled).
$css = wp_get_custom_css();

// strip my previous polish + temp blocks (from marker to end of their rules)
$css = preg_replace('/\n*\/\* BRM mega menu polish \*\/.*?(?=\n\/\*|$)/s', '', $css);
$css = preg_replace('/\n*\/\* BRM TEMP menu-open \*\/.*?(?=\n\/\*|$)/s', '', $css);

$icons = array(
  87=>'1F3DB',15691=>'1F511',821=>'1F9F1',62=>'1F3E0',63=>'1F33E',200=>'1F396',615=>'1F69A',17550=>'1F4CD',17645=>'25AD',18308=>'1F33F',987514393=>'1F4C2',1997=>'1F3E6',880=>'1F4BC',987514399=>'1F4C8',15765=>'1F9B8',16598=>'1F3D7',18475=>'1F6E0',17867=>'1F3E1',17696=>'1F3E8',18131=>'1F48E',987512693=>'1F381',987515437=>'1FA7A',
  809=>'1F4D6',336=>'1F4DA',882=>'1F4CB',987514401=>'1F9EE',18029=>'1F522',987514949=>'1F9FE',987514951=>'1F501',987514668=>'1F396',987514391=>'2753',18427=>'1F4C9',987514924=>'1F4D0',987514666=>'1F5FA',987514670=>'1F33E',987514672=>'1F9ED',
  987513124=>'1F4DE',565=>'1F465',186=>'1F464',987515439=>'2B50',987515441=>'1F5FA',
  987515429=>'1F40E',987515430=>'26F3',987515431=>'1F40A',987515432=>'1F333',
  18173=>'26A1',225=>'1F33E',16316=>'1F69A',539=>'1F3D6',17759=>'1F4B3',987514938=>'1F504',
);
$iconRules = '';
foreach ($icons as $id => $hex) $iconRules .= "#primary-menu .menu-item-$id > a::before{content:\"\\$hex\";}\n";

$add = '

/* BRM mega menu (CSS-driven) */
@media (min-width: 1025px) {
  #masthead { position: relative; }
  #primary-menu > li.kadence-menu-mega-enabled { position: static; }
  #primary-menu > li.kadence-menu-mega-enabled > .sub-menu {
    position: absolute !important; left: 24px !important; right: 24px !important; top: 100% !important;
    width: auto !important; min-width: 0 !important; max-width: none !important;
    display: grid !important; grid-template-columns: repeat(4, 1fr); gap: 4px 36px;
    padding: 30px 42px 34px !important; margin: 0 !important;
    background: #fff !important; border-radius: 0 0 16px 16px;
    box-shadow: 0 26px 60px -22px rgba(15,46,45,.4), 0 2px 0 0 #F5A524 inset;
    opacity: 0; visibility: hidden; transform: translateY(10px); pointer-events: none;
    transition: opacity .18s ease, transform .18s ease, visibility .18s;
    z-index: 110;
  }
  #primary-menu > li.kadence-menu-mega-enabled:hover > .sub-menu,
  #primary-menu > li.kadence-menu-mega-enabled:focus-within > .sub-menu {
    opacity: 1; visibility: visible; transform: none; pointer-events: auto;
  }
  /* second-level items = column cells */
  #primary-menu li.kadence-menu-mega-enabled > .sub-menu > li {
    display: block; width: auto !important; padding: 0 !important; margin: 0 0 6px !important; border: 0 !important;
  }
  #primary-menu li.kadence-menu-mega-enabled > .sub-menu > li > a {
    display: block; padding: 9px 10px !important; border-radius: 8px;
    font-family: "Rubik", sans-serif; font-weight: 700; font-size: 14px; color: #0f2e2d !important;
    line-height: 1.4; width: auto !important;
  }
  /* third-level lists render inline under their parent (no flyout) */
  #primary-menu li.kadence-menu-mega-enabled > .sub-menu .sub-menu {
    position: static !important; display: block !important; opacity: 1 !important; visibility: visible !important;
    transform: none !important; box-shadow: none !important; border: 0 !important; background: transparent !important;
    padding: 0 0 4px 12px !important; margin: 0 !important; min-width: 0 !important; width: auto !important;
    pointer-events: auto !important;
  }
  #primary-menu li.kadence-menu-mega-enabled > .sub-menu .sub-menu a {
    display: block; padding: 6px 10px !important; border-radius: 7px;
    font-size: 13.5px; font-weight: 500; color: #41524f !important; line-height: 1.4; width: auto !important;
  }
  #primary-menu li.kadence-menu-mega-enabled .sub-menu a:hover { background: #eafaf6; color: #036b58 !important; }
  /* kill dropdown arrows inside the panel */
  #primary-menu li.kadence-menu-mega-enabled .sub-menu .dropdown-nav-toggle,
  #primary-menu li.kadence-menu-mega-enabled .sub-menu .dropdown-nav-special-toggle { display: none !important; }
}
/* icons (all viewports) */
#primary-menu .sub-menu .menu-item > a::before{content:"";display:inline-block;margin-right:8px;font-size:14px;line-height:1;vertical-align:-1px;font-family:"Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji",sans-serif;}
' . $iconRules . '
/* descriptions */
#primary-menu .menu-item-description{display:block;font-size:11.5px;color:#5b6b6b;font-weight:400;text-transform:none;letter-spacing:0;margin-top:1px;line-height:1.3;}

/* BRM TEMP menu-open */
#primary-menu .menu-item-66 > .sub-menu{opacity:1 !important;visibility:visible !important;transform:none !important;pointer-events:auto !important;}
';
wp_update_custom_css_post($css . $add);
wp_cache_flush();
echo "CSS mega menu installed (+temp open for screenshot)\n";
