<?php
/**
 * fgs-17-bands.php — Keith 2026-06-12 (round: bands + hero):
 * 1. Maroon full-bleed band behind the homepage hero, torn bottom edge into the white page.
 *    Hero card goes transparent so the text sits directly on the band (text/buttons already white).
 * 2. Footer dark NAP band -> full-bleed, so its torn top edge spans the viewport.
 * 3. Recent Projects: photos forced to a uniform 16:10 crop (they rendered too tall),
 *    project columns get the system card surface.
 * 4. body overflow-x clip guards the full-bleed margin trick against scrollbar overflow.
 * (Torn tops on the stats band + "What Sets Us Apart" were already applied in fgs-15.)
 * CSS only, marker-replaced, idempotent. Usage: wp eval-file fgs-17-bands.php
 */

$ms  = '/* fgs-bands:start */';
$me  = '/* fgs-bands:end */';
$new = <<<'CSS'
body{overflow-x:clip}

/* — Hero: full-bleed maroon band with torn bottom — */
.kb-row-layout-id90_c12bb7-a1{
  position:relative;
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
  background:
    radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,0.12),transparent 60%),
    linear-gradient(180deg,#7a0c0e 0%,#4a0404 55%,#2e0000 100%);
}
.kb-row-layout-id90_c12bb7-a1::after{
  content:"";position:absolute;bottom:-1px;left:0;right:0;z-index:2;
  height:clamp(32px,4vw,80px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% 100% no-repeat;
  pointer-events:none;
}
.kb-row-layout-id90_c12bb7-a1 > .kt-row-column-wrap{padding-top:150px !important;padding-bottom:110px !important}

/* — Header floats over the maroon band (homepage): transparent header, band starts at viewport top — */
.home #masthead{position:absolute;top:0;left:0;right:0;z-index:100;background:transparent}
.home .kb-row-layout-id90_c12bb7-a1{margin-top:0}
/* kill the theme's 5rem content gap so the band fills to the very top — no white above */
.home .content-area{margin-top:0 !important}
.home .entry-content{margin-top:0 !important}
@media (max-width:1024px){
  .home .kb-row-layout-id90_c12bb7-a1 > .kt-row-column-wrap{padding-top:112px !important}
}
/* hero inner layers dissolve into the band — no white anywhere */
.kb-row-layout-id90_1db09f-bf,
.kb-row-layout-id90_1db09f-bf.kt-row-has-bg{background:transparent !important}
/* headline card: glass on maroon instead of gray */
.kadence-column90_663c26-f1 > .kt-inside-inner-col{
  background:rgba(255,255,255,0.07) !important;
  border:1px solid rgba(255,255,255,0.16);
  border-radius:15px;
  backdrop-filter:blur(6px);
  -webkit-backdrop-filter:blur(6px);
}
.kb-row-layout-id90_1db09f-bf h1,
.kb-row-layout-id90_1db09f-bf .wp-block-kadence-advancedheading{color:#ffffff !important;text-shadow:0 2px 10px rgba(0,0,0,0.25)}
.kb-row-layout-id90_1db09f-bf p{color:rgba(255,255,255,0.92) !important}
.kb-row-layout-id90_1db09f-bf .wp-block-button__link,
.kb-row-layout-id90_1db09f-bf .kb-button,
.kb-row-layout-id90_1db09f-bf .kt-button{
  background:#ffffff !important;color:#5c0606 !important;border-color:#ffffff !important;
  box-shadow:0 12px 30px rgba(0,0,0,0.28);
}

/* — Footer: full-bleed dark band (torn top edge already applied in fgs-15) — */
.fgs-footer-nap{
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
}

/* — Recent Projects: flush-image cards (image bleeds to card top, text padded below) — */
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout .wp-block-kadence-column > .kt-inside-inner-col{
  background:#fbfbfb;border:1px solid #ece7e4;border-radius:18px;
  padding:0 0 24px;height:100%;box-sizing:border-box;overflow:hidden;
  transition:transform .2s ease,box-shadow .2s ease;
}
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout .wp-block-kadence-column:hover > .kt-inside-inner-col{
  transform:translateY(-4px);box-shadow:0 14px 32px rgba(96,0,0,.09);
}
/* kill every wrapper gap Kadence puts around the image so the card fills behind it */
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout figure,
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout .wp-block-image,
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout .wp-block-kadence-image{margin:0 !important;padding:0 !important}
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout img{
  width:100% !important;aspect-ratio:16/10;height:auto;object-fit:cover;
  border-radius:0 !important;display:block;
}
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout h3{font-size:19px;margin:18px 22px 8px}
.kb-row-layout-id90_ea8191-8d .wp-block-kadence-rowlayout p{margin:0 22px;font-size:14.5px;line-height:1.55}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Bands CSS written (hero band, footer bleed, projects cards).' );
