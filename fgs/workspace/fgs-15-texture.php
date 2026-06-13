<?php
/**
 * fgs-15-texture.php — Live-site texture treatment (Keith 2026-06-12):
 * 1. Torn brush edges on the dark full-bleed bands (white tear overlays at top/bottom,
 *    assets lifted from the client's live Astro site: fgs-edge-top/bottom.webp).
 *    Applied to the homepage stats band + "What Sets Us Apart", plus a generic .fgs-torn.
 * 2. Subtle construction line-art sketch (#515759 strokes at 6% opacity,
 *    fgs-sketch-construction.svg) behind white sections: homepage founder band +
 *    Recent Projects, plus a generic .fgs-sketch.
 * Pure CSS (marker-replaced). Idempotent. Usage: wp eval-file fgs-15-texture.php
 */

$ms  = '/* fgs-texture:start */';
$me  = '/* fgs-texture:end */';
$new = <<<'CSS'
/* — Torn brush edges on dark bands — */
.kb-row-layout-id90_57a751-f5,
.kb-row-layout-id90_bdd234-9c,
.fgs-torn{position:relative}
.kb-row-layout-id90_57a751-f5::before,
.kb-row-layout-id90_bdd234-9c::before,
.fgs-torn::before{
  content:"";position:absolute;top:-1px;left:0;right:0;z-index:2;
  height:clamp(36px,4.5vw,88px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp) center top/100% 100% no-repeat;
  pointer-events:none;
}
.kb-row-layout-id90_57a751-f5::after,
.kb-row-layout-id90_bdd234-9c::after,
.fgs-torn::after{
  content:"";position:absolute;bottom:-1px;left:0;right:0;z-index:2;
  height:clamp(32px,4vw,80px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% 100% no-repeat;
  pointer-events:none;
}
/* keep band content clear of the tears */
.kb-row-layout-id90_57a751-f5 .fgs-stats{padding-top:96px;padding-bottom:92px}
.kb-row-layout-id90_bdd234-9c > .kt-row-column-wrap{padding-top:90px !important;padding-bottom:90px !important}

/* — Footer: ripped top edge on the dark NAP band — */
.fgs-footer-nap{position:relative;padding-top:104px !important}
.fgs-footer-nap::before{
  content:"";position:absolute;top:-1px;left:0;right:0;z-index:2;
  height:clamp(32px,4vw,76px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp) center top/100% 100% no-repeat;
  pointer-events:none;
}

/* — Construction sketch behind white sections — */
.kb-row-layout-id90_ae7ca3-30,
.kb-row-layout-id90_ea8191-8d,
.fgs-sketch{position:relative}
.kb-row-layout-id90_ae7ca3-30::before,
.kb-row-layout-id90_ea8191-8d::before,
.fgs-sketch::before{
  content:"";position:absolute;inset:0;z-index:0;
  background:url(/wp-content/uploads/2026/06/fgs-sketch-construction.svg) left -60px center/auto 92% no-repeat;
  opacity:.06;pointer-events:none;
}
.kb-row-layout-id90_ea8191-8d::before{background-position:right -80px center}
.kb-row-layout-id90_ae7ca3-30 > .kt-row-column-wrap,
.kb-row-layout-id90_ea8191-8d > .kt-row-column-wrap,
.fgs-sketch > .kt-row-column-wrap{position:relative;z-index:1}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Texture CSS written (torn edges + sketch).' );
