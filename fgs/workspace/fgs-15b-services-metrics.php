<?php
/**
 * fgs-15b-services-metrics.php — Keith 2026-06-12: the gray "Key Metrics" band on /services/
 * (row 98_94ea34-43, palette7) sits oddly. Convert it to the charcoal torn-edge band
 * (top AND bottom tears), matching the homepage stats band. Also fixes the stray
 * mismatched gray group on page 269 (JSON said blush, rendered div said gray).
 * Idempotent. Usage: wp eval-file fgs-15b-services-metrics.php
 */

// ---------- 1. /services/ metrics row -> charcoal ----------
$p   = get_post( 98 );
$new = str_replace(
	'<!-- wp:kadence/rowlayout {"uniqueID":"98_94ea34-43","columns":1,"colLayout":"equal","maxWidth":600,"bgColor":"palette7"',
	'<!-- wp:kadence/rowlayout {"uniqueID":"98_94ea34-43","columns":1,"colLayout":"equal","maxWidth":600,"bgColor":"#2d2d2d"',
	$p->post_content,
	$n
);
if ( ! $n ) {
	// attr order may differ — fall back to targeted regex within the row opener
	$new = preg_replace(
		'#(<!-- wp:kadence/rowlayout \{"uniqueID":"98_94ea34-43"[^>]*?)"bgColor":"palette7"#',
		'$1"bgColor":"#2d2d2d"',
		$p->post_content,
		1,
		$n
	);
}
if ( $n ) {
	$r = wp_update_post( array( 'ID' => 98, 'post_content' => wp_slash( $new ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( '98: metrics row -> #2d2d2d.' );
} else {
	WP_CLI::log( '98: metrics row already charcoal or not found.' );
}

// ---------- 2. 269 stray gray div -> blush (match its own JSON) ----------
$p   = get_post( 269 );
$new = str_replace(
	'<div class="wp-block-group has-background" style="border-radius:16px;background-color:#f3f3f3;padding-top:32px',
	'<div class="wp-block-group has-background" style="border-radius:16px;background-color:#f0e5e5;padding-top:32px',
	$p->post_content,
	$n2
);
if ( $n2 ) {
	wp_update_post( array( 'ID' => 269, 'post_content' => wp_slash( $new ) ), true );
	WP_CLI::log( '269: stray gray group -> blush.' );
} else {
	WP_CLI::log( '269: stray group already fixed.' );
}

// ---------- 3. CSS: torn edges + white text for the metrics band ----------
$ms  = '/* fgs-svc-metrics:start */';
$me  = '/* fgs-svc-metrics:end */';
$new = <<<'CSS'
/* — /services/ Key Metrics: charcoal torn band, white text — */
.kb-row-layout-id98_94ea34-43{position:relative}
.kb-row-layout-id98_94ea34-43::before{
  content:"";position:absolute;top:-1px;left:0;right:0;z-index:2;
  height:clamp(36px,4.5vw,88px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp) center top/100% 100% no-repeat;
  pointer-events:none;
}
.kb-row-layout-id98_94ea34-43::after{
  content:"";position:absolute;bottom:-1px;left:0;right:0;z-index:2;
  height:clamp(32px,4vw,80px);
  background:url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% 100% no-repeat;
  pointer-events:none;
}
.kb-row-layout-id98_94ea34-43 > .kt-row-column-wrap{padding-top:110px !important;padding-bottom:110px !important}
.kb-row-layout-id98_94ea34-43 h2,
.kb-row-layout-id98_94ea34-43 h3,
.kb-row-layout-id98_94ea34-43 .wp-block-kadence-advancedheading{color:#ffffff !important}
.kb-row-layout-id98_94ea34-43 p{color:#adadad !important}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Services metrics band converted.' );
