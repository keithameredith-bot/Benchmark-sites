<?php
/**
 * fgs-18-tears-v2.php — Definitive tear implementation. The pseudo-element approach
 * rendered ::after (bottom tears) but never ::before (top tears) in Keith's browser
 * across three variants. v2 sidesteps pseudos entirely: tears are painted as
 * multi-layer background-images directly on the dark sections. Also neutralizes all
 * old tear pseudos and fixes the two remaining near-white hero columns (illegible
 * white-on-white card) with the glass treatment.
 * Idempotent (marker-replaced). Usage: wp eval-file fgs-18-tears-v2.php
 */

$ms  = '/* fgs-tears2:start */';
$me  = '/* fgs-tears2:end */';
$new = <<<'CSS'
/* kill the old pseudo-element tears (v1) everywhere */
.kb-row-layout-id90_57a751-f5::before,.kb-row-layout-id90_57a751-f5::after,
.kb-row-layout-id90_bdd234-9c::before,.kb-row-layout-id90_bdd234-9c::after,
.kb-row-layout-id98_94ea34-43::before,.kb-row-layout-id98_94ea34-43::after,
.fgs-torn::before,.fgs-torn::after,
.fgs-footer-nap::before,
.kb-row-layout-id90_c12bb7-a1::after{content:none !important}

/* — v2: tears as background layers ON the dark bands (no pseudos) — */
.kb-row-layout-id90_57a751-f5,
.kb-row-layout-id90_bdd234-9c,
.kb-row-layout-id98_94ea34-43{
  background-image:
    url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp),
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) !important;
  background-position:center top,center bottom !important;
  background-size:100% clamp(36px,4.5vw,84px),100% clamp(32px,4vw,76px) !important;
  background-repeat:no-repeat,no-repeat !important;
}
/* footer: the dark element is #colophon itself (footer_wrap_background = palette3).
   Tear goes on ITS top edge; the NAP widget inside goes transparent so there is one
   continuous dark band with no straight bar above the rip. */
#colophon{
  background:
    url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp) center top/100% clamp(32px,4vw,72px) no-repeat
    #2d2d2d !important;
}
.fgs-footer-nap{background:transparent !important;}
/* hero band: bottom tear folded into the gradient stack */
.kb-row-layout-id90_c12bb7-a1{
  background:
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% clamp(32px,4vw,76px) no-repeat,
    radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,0.12),transparent 60%),
    linear-gradient(180deg,#7a0c0e 0%,#4a0404 55%,#2e0000 100%) !important;
}

/* — hero: remaining near-white columns become glass (fixes white-on-white text) — */
.kadence-column90_06acc3-46 > .kt-inside-inner-col,
.kadence-column90_a60f79-32 > .kt-inside-inner-col{
  background-color:rgba(255,255,255,0.08) !important; /* longhand: must NOT wipe a column's background-image photo */
  border:1px solid rgba(255,255,255,0.16);
  border-radius:15px;
  backdrop-filter:blur(6px);
  -webkit-backdrop-filter:blur(6px);
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Tears v2 (background-layer) + hero glass written.' );
