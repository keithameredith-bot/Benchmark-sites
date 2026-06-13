<?php
/**
 * fgs-20-template-rollup.php — Homepage is now the design template:
 * 1. Full-bleed maroon torn hero band + transparent overlay header on ALL pages
 *    (generic :has(h1) first-row rule — service pages, about, contact, drafts).
 * 2. Founders band: white box dissolved — white text on black, bigger portraits.
 * 3. Footer credit: "Website by Benchmark Web Development" -> benchmarkwebd.com.
 * Idempotent. Usage: wp eval-file fgs-20-template-rollup.php
 */

$ms  = '/* fgs-template:start */';
$me  = '/* fgs-template:end */';
$new = <<<'CSS'
/* — Overlay header on all pages (homepage rule still applies; this generalizes it) — */
body.page #masthead{position:absolute;top:0;left:0;right:0;z-index:100;background:transparent}
body.page .content-area{margin-top:0 !important}
/* fallback spacing for pages whose first block is not a hero row (e.g. privacy) */
body.page .entry-content > :first-child:not(.wp-block-kadence-rowlayout){margin-top:150px}

/* — Generic maroon torn hero band: any page whose first row holds the H1 — */
body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1){
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
  background:
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% clamp(32px,4vw,76px) no-repeat,
    radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,0.12),transparent 60%),
    linear-gradient(180deg,#7a0c0e 0%,#4a0404 55%,#2e0000 100%) !important;
}
body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1) > .kt-row-column-wrap{
  padding-top:150px !important;padding-bottom:100px !important;
}
body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1) .wp-block-group.has-background:has(h1){
  background:transparent !important;box-shadow:none !important;border:0 !important;
}
/* non-group hero content (e.g. /services/ advancedheadings) goes white on the band */
body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1) h1,
body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1) .wp-block-kadence-advancedheading{color:#ffffff !important}
@media (max-width:1024px){
  body.page:not(.home) .entry-content > .wp-block-kadence-rowlayout:first-child:has(h1) > .kt-row-column-wrap{padding-top:112px !important}
  body.page .entry-content > :first-child:not(.wp-block-kadence-rowlayout){margin-top:112px}
}

/* — Founders band: no white box; light text on black; bigger portraits — */
.kb-row-layout-id90_ae7ca3-30 .wp-block-group.has-background{
  background:transparent !important;box-shadow:none !important;
  padding-left:0 !important;padding-right:0 !important;
}
.kb-row-layout-id90_ae7ca3-30 h2{color:#ffffff !important}
.kb-row-layout-id90_ae7ca3-30 h3,
.kb-row-layout-id90_ae7ca3-30 .wp-block-kadence-advancedheading{color:#ffffff !important}
.kb-row-layout-id90_ae7ca3-30 p{color:rgba(255,255,255,0.86) !important}
.kb-row-layout-id90_ae7ca3-30 figure{margin:0 0 18px}
.kb-row-layout-id90_ae7ca3-30 img{
  width:100% !important;max-width:100% !important;height:auto;
  aspect-ratio:4/5;object-fit:cover;border-radius:18px;
  box-shadow:0 16px 40px rgba(0,0,0,0.35);
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::log( 'template CSS written.' );

// footer credit
$opt = get_option( 'widget_block' );
if ( false === strpos( $opt[20]['content'], 'benchmarkwebd.com' ) ) {
	$opt[20]['content'] = str_replace(
		'Serving all 67 Florida counties from Ocala</div>',
		'Serving all 67 Florida counties from Ocala &nbsp;·&nbsp; Website by <a href="https://benchmarkwebd.com" target="_blank" rel="noopener">Benchmark Web Development</a></div>',
		$opt[20]['content']
	);
	update_option( 'widget_block', $opt );
	WP_CLI::log( 'footer credit added.' );
} else {
	WP_CLI::log( 'footer credit already present.' );
}

WP_CLI::success( 'Template rollup applied.' );
