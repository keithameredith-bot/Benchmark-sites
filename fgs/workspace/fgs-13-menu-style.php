<?php
/**
 * fgs-13-menu-style.php — "Slick" floating-pill navbar, modeled on the live Astro site's menu:
 * white rounded pill containing logo + links + CTA, floating over the page, shadow deepens
 * when Kadence Pro sticky fixes the row. Animated maroon underline on links, inverting CTA,
 * card-style dropdown, dark mobile drawer. Pure CSS via Additional CSS (marker-replaced).
 * Idempotent. Usage: wp eval-file fgs-13-menu-style.php
 */

$ms  = '/* fgs-menu:start */';
$me  = '/* fgs-menu:end */';
$new = <<<'CSS'
/* — Floating pill navbar — */
#masthead .site-main-header-wrap .site-header-row-container-inner{background:transparent !important}
#masthead .site-main-header-wrap .site-main-header-inner-wrap{
  background:#ffffff;
  border:1px solid #efe9e6;
  border-radius:20px;
  box-shadow:0 10px 34px rgba(45,45,45,.10);
  padding:12px 16px 12px 24px;
  margin:14px 0;
  min-height:0;
}
/* no shrink on scroll: pill and row keep identical height in normal and stuck states */
#masthead .site-main-header-wrap .site-header-row-container-inner,
#masthead .site-main-header-wrap .site-main-header-inner-wrap{height:auto !important;min-height:0 !important}
#masthead .item-is-fixed .site-main-header-inner-wrap{padding:12px 16px 12px 24px;margin:14px 0}
/* stuck state: lift the pill, keep the row chrome invisible */
#masthead .site-header-row-container.item-is-fixed{background:transparent !important;box-shadow:none !important}
#masthead .item-is-fixed .site-main-header-inner-wrap{box-shadow:0 18px 50px rgba(45,45,45,.20);border-color:#e9e2de}
/* logo: fixed size in both normal and stuck states — no shrink-jump, no clipping */
#masthead .site-branding .custom-logo,
#masthead .item-is-fixed .site-branding .custom-logo{
  height:80px !important;max-height:80px !important;width:auto !important;
}
#masthead .site-branding a{display:flex;align-items:center}
/* vertical centering: pill row and the CTA */
#masthead .site-main-header-wrap .site-main-header-inner-wrap{align-items:center}
#masthead .site-main-header-inner-wrap .site-header-item{display:flex;align-items:center}
#masthead .header-button-wrap{display:flex;align-items:center;margin:0}
#masthead .header-button{margin:0 !important}
/* — Links: semibold, animated maroon underline — */
#masthead .header-navigation .primary-menu-container > ul{display:flex;gap:14px}
#masthead .header-navigation .primary-menu-container > ul > li > a{
  font-weight:600;font-size:16px;color:#2d2d2d;
  padding:14px 14px;position:relative;transition:color .22s ease;
  display:inline-flex;align-items:center;
}
/* no dropdown carets — clean labels, dropdowns still open on hover (Keith 2026-06-12) */
#masthead .header-navigation .dropdown-nav-toggle{display:none !important}
#masthead .header-navigation .nav-drop-title-wrap{display:inline-flex;align-items:center}
#masthead .header-navigation .primary-menu-container > ul > li > a::after{
  content:"";position:absolute;left:14px;right:14px;bottom:8px;height:2.5px;
  border-radius:2px;background:#a91513;
  transform:scaleX(0);transform-origin:left center;transition:transform .25s ease;
}
#masthead .header-navigation .primary-menu-container > ul > li:hover > a,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-item > a,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-ancestor > a{color:#a91513}
#masthead .header-navigation .primary-menu-container > ul > li:hover > a::after,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-item > a::after,
#masthead .header-navigation .primary-menu-container > ul > li.current-menu-ancestor > a::after{transform:scaleX(1)}
/* — CTA button: maroon, inverts on hover like the live site — */
#masthead .header-button,
#mobile-header .mobile-header-button{
  background:#a91513 !important;color:#ffffff !important;
  border:2px solid #a91513 !important;border-radius:10px !important;
  padding:10px 22px !important;font-weight:800 !important;font-size:15px !important;
  box-shadow:0 6px 18px rgba(96,0,0,.22);
  transition:background .22s ease,color .22s ease,box-shadow .22s ease !important;
}
#masthead .header-button:hover,
#mobile-header .mobile-header-button:hover{
  background:#ffffff !important;color:#a91513 !important;
  box-shadow:0 10px 26px rgba(96,0,0,.18);
}
/* — Dropdown: white card, blush hover — */
/* invisible hover bridge spanning the pill padding + dropdown gap, so the menu
   stays open while the pointer travels down into it */
#masthead .header-navigation .primary-menu-container > ul > li.menu-item-has-children{position:relative}
#masthead .header-navigation .primary-menu-container > ul > li.menu-item-has-children:hover::before{
  content:"";position:absolute;left:-10px;right:-10px;top:100%;height:26px;
}
#masthead .header-navigation ul.sub-menu{
  background:#ffffff !important;border:1px solid #efe9e6;border-radius:14px;
  box-shadow:0 18px 44px rgba(45,45,45,.15) !important;
  padding:8px !important;min-width:270px;margin-top:6px;
}
#masthead .header-navigation ul.sub-menu li a{
  border-radius:9px;padding:11px 14px !important;
  color:#454545 !important;font-weight:600;font-size:14.5px;
  transition:background .18s ease,color .18s ease;width:100%;
}
#masthead .header-navigation ul.sub-menu li a:hover,
#masthead .header-navigation ul.sub-menu li.current-menu-item > a{
  background:#f0e5e5 !important;color:#a91513 !important;
}
/* — Mobile: clean white bar + charcoal drawer — */
#mobile-header .site-header-row-container-inner{box-shadow:0 6px 22px rgba(45,45,45,.08)}
#mobile-drawer .drawer-inner{background:#2d2d2d !important}
#mobile-drawer .drawer-inner .mobile-navigation ul li a{
  color:#ffffff !important;font-weight:600;font-size:17px;padding:14px 0;
}
#mobile-drawer .drawer-inner .mobile-navigation ul li{border-color:rgba(255,255,255,.10) !important}
#mobile-drawer .drawer-inner .mobile-navigation ul li.current-menu-item > a{color:#ee7c63 !important}
#mobile-drawer .drawer-header .search-toggle-open,
#mobile-drawer .drawer-header .drawer-toggle{color:#ffffff !important}
@media (max-width:1024px){
  #masthead .site-main-header-wrap .site-main-header-inner-wrap{margin:10px 0;padding:8px 12px 8px 16px}
  #masthead .site-branding .custom-logo,
  #masthead .item-is-fixed .site-branding .custom-logo{height:56px !important;max-height:56px !important}
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Pill navbar CSS written.' );
