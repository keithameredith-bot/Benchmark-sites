<?php
/**
 * apply-pill-navbar.php — Benchmark "floating pill" navbar for any Kadence site.
 * The exact FGS treatment: white rounded pill floating over the page, logo + links + inverting
 * CTA ("Call Now"), animated underline links, no shrink on scroll, card dropdown, dark mobile drawer.
 *
 * HOW TO USE (from the target site's terminal):
 *   1. Edit the CONFIG block below — swap the brand colors + logo height.
 *   2. Run:  & "C:\Users\keith\.hermes\git\bin\bash.exe" -c 'source ~/Desktop/<site>-workspace/wp-env.sh \
 *            && wp eval-file "C:/Users/keith/benchmark-sites/design-system/pill-navbar/apply-pill-navbar.php"'
 *   3. Hard-refresh. Idempotent + marker-guarded (re-run anytime; safe).
 *
 * PREREQUISITES (Kadence):
 *   - Kadence + Kadence Pro (sticky header). This script turns sticky ON for the main row + shrink OFF.
 *   - The header's MAIN row must contain: logo, navigation, and a Button element (that's the "Call Now"
 *     CTA the .header-button rules style). Add it in Customize → Header if not present; set its label
 *     ("Call Now") and a tel: link.
 *   - A custom logo set (Customize → Site Identity).
 *
 * For a FLOATING-OVER-A-COLORED-HERO look (header transparent, sitting on top of a dark/colored hero
 * like FGS): see the OPTIONAL overlay block at the bottom of this file.
 */

/* ===================== CONFIG — change per site ===================== */
$accent       = '#a91513';   // brand primary: link hover/underline, CTA fill, dropdown active
$ink          = '#2d2d2d';   // nav link text + mobile drawer background
$blush        = '#f0e5e5';   // dropdown item hover background (a pale tint of the brand)
$active_dark  = '#ee7c63';   // current-page color inside the dark mobile drawer (AA on dark)
$pill_bg      = '#ffffff';
$pill_border  = '#efe9e6';
$logo_h       = '80px';      // desktop logo height (fixed; no shrink)
$logo_h_mob   = '56px';      // mobile logo height
$shadow_rgba  = 'rgba(96,0,0,.22)';   // CTA shadow tone (a dark shade of the brand)
/* =================================================================== */

$css_new = <<<CSS
/* — Floating pill navbar — */
#masthead .site-main-header-wrap .site-header-row-container-inner{background:transparent !important}
#masthead .site-main-header-wrap .site-main-header-inner-wrap{
  background:{$pill_bg};
  border:1px solid {$pill_border};
  border-radius:20px;
  box-shadow:0 10px 34px rgba(45,45,45,.10);
  padding:12px 16px 12px 24px;
  margin:14px 0;
  min-height:0;
}
/* no shrink on scroll: identical height normal + stuck */
#masthead .site-main-header-wrap .site-header-row-container-inner,
#masthead .site-main-header-wrap .site-main-header-inner-wrap{height:auto !important;min-height:0 !important}
#masthead .item-is-fixed .site-main-header-inner-wrap{padding:12px 16px 12px 24px;margin:14px 0}
#masthead .site-header-row-container.item-is-fixed{background:transparent !important;box-shadow:none !important}
#masthead .item-is-fixed .site-main-header-inner-wrap{box-shadow:0 18px 50px rgba(45,45,45,.20);border-color:#e9e2de}
/* logo: fixed size, no shrink-jump */
#masthead .site-branding .custom-logo,
#masthead .item-is-fixed .site-branding .custom-logo{height:{$logo_h} !important;max-height:{$logo_h} !important;width:auto !important}
#masthead .site-branding a{display:flex;align-items:center}
/* vertical centering */
#masthead .site-main-header-wrap .site-main-header-inner-wrap{align-items:center}
#masthead .site-main-header-inner-wrap .site-header-item{display:flex;align-items:center}
#masthead .header-button-wrap{display:flex;align-items:center;margin:0}
#masthead .header-button{margin:0 !important}
/* — Links: semibold, animated underline — */
#masthead .header-navigation .primary-menu-container > ul{display:flex;gap:14px}
#masthead .header-navigation .primary-menu-container > ul > li > a{
  font-weight:600;font-size:16px;color:{$ink};
  padding:14px 14px;position:relative;transition:color .22s ease;display:inline-flex;align-items:center;
}
/* no dropdown carets — clean labels, dropdowns still open on hover */
#masthead .header-navigation .dropdown-nav-toggle{display:none !important}
#masthead .header-navigation .nav-drop-title-wrap{display:inline-flex;align-items:center}
#masthead .header-navigation .primary-menu-container > ul > li > a::after{
  content:"";position:absolute;left:14px;right:14px;bottom:8px;height:2.5px;border-radius:2px;background:{$accent};
  transform:scaleX(0);transform-origin:left center;transition:transform .25s ease;
}
#masthead .header-navigation .primary-menu-container > ul > li:hover > a,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-item > a,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-ancestor > a{color:{$accent}}
#masthead .header-navigation .primary-menu-container > ul > li:hover > a::after,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-item > a::after,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-ancestor > a::after{transform:scaleX(1)}
/* — CTA button: brand fill, inverts on hover — */
#masthead .header-button,
#mobile-header .mobile-header-button{
  background:{$accent} !important;color:#ffffff !important;
  border:2px solid {$accent} !important;border-radius:10px !important;
  padding:10px 22px !important;font-weight:800 !important;font-size:15px !important;
  box-shadow:0 6px 18px {$shadow_rgba};
  transition:background .22s ease,color .22s ease,box-shadow .22s ease !important;
}
#masthead .header-button:hover,
#mobile-header .mobile-header-button:hover{background:#ffffff !important;color:{$accent} !important;box-shadow:0 10px 26px {$shadow_rgba}}
/* — Dropdown: white card, hover bridge so it stays open — */
#masthead .header-navigation .primary-menu-container > ul > li.menu-item-has-children{position:relative}
#masthead .header-navigation .primary-menu-container > ul > li.menu-item-has-children:hover::before{
  content:"";position:absolute;left:-10px;right:-10px;top:100%;height:26px;
}
#masthead .header-navigation ul.sub-menu{
  background:#ffffff !important;border:1px solid {$pill_border};border-radius:14px;
  box-shadow:0 18px 44px rgba(45,45,45,.15) !important;padding:8px !important;min-width:270px;margin-top:6px;
}
#masthead .header-navigation ul.sub-menu li a{
  border-radius:9px;padding:11px 14px !important;color:#454545 !important;font-weight:600;font-size:14.5px;
  transition:background .18s ease,color .18s ease;width:100%;
}
#masthead .header-navigation ul.sub-menu li a:hover,
#masthead .header-navigation ul.sub-menu li.current-menu-item > a{background:{$blush} !important;color:{$accent} !important}
/* — Mobile: clean bar + dark drawer — */
#mobile-header .site-header-row-container-inner{box-shadow:0 6px 22px rgba(45,45,45,.08)}
#mobile-drawer .drawer-inner{background:{$ink} !important}
#mobile-drawer .drawer-inner .mobile-navigation ul li a{color:#ffffff !important;font-weight:600;font-size:17px;padding:14px 0}
#mobile-drawer .drawer-inner .mobile-navigation ul li{border-color:rgba(255,255,255,.10) !important}
#mobile-drawer .drawer-inner .mobile-navigation ul li.current-menu-item > a{color:{$active_dark} !important}
#mobile-drawer .drawer-header .search-toggle-open,
#mobile-drawer .drawer-header .drawer-toggle{color:#ffffff !important}
@media (max-width:1024px){
  #masthead .site-main-header-wrap .site-main-header-inner-wrap{margin:10px 0;padding:8px 12px 8px 16px}
  #masthead .site-branding .custom-logo,
  #masthead .item-is-fixed .site-branding .custom-logo{height:{$logo_h_mob} !important;max-height:{$logo_h_mob} !important}
}
CSS;

// turn OFF Kadence sticky-shrink + ensure main-row sticky (the no-jump float)
if ( true === get_theme_mod( 'header_sticky_shrink' ) ) { set_theme_mod( 'header_sticky_shrink', false ); }
if ( true === get_theme_mod( 'mobile_header_sticky_shrink' ) ) { set_theme_mod( 'mobile_header_sticky_shrink', false ); }
if ( ! get_theme_mod( 'header_sticky' ) ) { set_theme_mod( 'header_sticky', 'main' ); }

// marker-guarded write to Additional CSS
$ms = '/* pill-navbar:start */';
$me = '/* pill-navbar:end */';
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $css_new . "\n" . $me . "\n";
$r = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) { WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() ); }
WP_CLI::success( 'Pill navbar applied. Hard-refresh; ensure a header Button (Call Now) is in the main row.' );

/* ============================ OPTIONAL: float over a colored hero ============================
   To make the header transparent and sit ON TOP of a dark/colored hero (like FGS), add this to the
   CSS above (adjust the selector to your hero row, or use the page-template body class):
     body.page #masthead{position:absolute;top:0;left:0;right:0;z-index:100;background:transparent}
     body.page .content-area{margin-top:0 !important}
   Then give the hero row enough top padding (~150px desktop / ~112px mobile) to clear the pill.
   ============================================================================================= */
