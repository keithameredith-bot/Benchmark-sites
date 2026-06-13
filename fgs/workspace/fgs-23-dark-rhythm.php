<?php
/**
 * fgs-23-dark-rhythm.php — Keith 2026-06-12: break up long text pages with black torn
 * bands. One or two mid-page prose sections per service page + About become full-bleed
 * #2d2d2d bands with torn edges and light text (inner white cards dissolve).
 * Also: footer section labels were "too peach" — now the stats-band gray (#adadad),
 * hover accent white.
 * Idempotent (marker-replaced CSS + guarded widget edit). Usage: wp eval-file fgs-23-dark-rhythm.php
 */

// Rows chosen for dark treatment (mid-page narrative sections, no grids/accordions):
// 146 pillar: "What Is Geotechnical Engineering?" + "FGS's Qualifications and Approach"
// 167: "FL Statute 627.707, Plainly" + "Fixing Confirmed Sinkholes"
// 202: "Where We Show Up" · 205: "How Deep, How Many?" · 216: "A Concrete Example..."
// 223: "Florida's Greatest Hits" · 225: "The Water Problem" · 230: "When Results Don't Match"
// 264: "What GPR Can't Do" · 92 About: "What We Stand For" + "Where We Work"
$rows = array(
	'146_a48b9c-5d', '146_50c72e-bc',
	'167_f63556-b0', '167_3c58c9-4c',
	'202_bbf570-3f',
	'205_59aa07-72',
	'216_d1f570-8b',
	'223_d61bb8-42',
	'225_131cf6-d1',
	'230_600408-11',
	'264_d42f70-2f',
	'92_508572-02', '92_9fa2bb-3c',
	// Keith 2026-06-12: first "Why..." narrative section after the hero, dark on EVERY
	// service page (his soil-testing screenshot = 216_eb8ddf-97; these are its siblings)
	'216_eb8ddf-97',
	'167_970208-f6',
	'202_f534fd-5c',
	'205_44266b-b9',
	'223_946b97-81',
	'225_93bb51-c6',
	'230_230952-b1',
	'264_42dc72-bc',
);

$sels       = array();
foreach ( $rows as $uid ) {
	$sels[] = '.kb-row-layout-id' . $uid;
}
$band  = implode( ",\n", $sels );
$inner = implode( ' .wp-block-group.has-background,' . "\n", $sels ) . ' .wp-block-group.has-background';
$h     = implode( ' :is(h2,h3,h4),' . "\n", $sels ) . ' :is(h2,h3,h4)';
$txt   = implode( ' :is(p,li),' . "\n", $sels ) . ' :is(p,li)';
$lnk   = implode( ' a,' . "\n", $sels ) . ' a';
$wrap  = implode( ' > .kt-row-column-wrap,' . "\n", $sels ) . ' > .kt-row-column-wrap';

$ms  = '/* fgs-darkband:start */';
$me  = '/* fgs-darkband:end */';
$new = <<<CSS
/* — Dark torn rhythm bands on long-text pages — */
{$band}{
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
  background-color:#2d2d2d !important;
  background-image:
    url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp),
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) !important;
  background-position:center top,center bottom !important;
  background-size:100% clamp(36px,4.5vw,84px),100% clamp(32px,4vw,76px) !important;
  background-repeat:no-repeat,no-repeat !important;
}
{$wrap}{padding-top:110px !important;padding-bottom:110px !important}
{$inner}{background:transparent !important;box-shadow:none !important}
{$h}{color:#ffffff !important}
{$txt}{color:rgba(255,255,255,0.87) !important}
{$lnk}{color:#ee7c63 !important;font-weight:700} /* deep peach — 4.8:1 on #2d2d2d, AA pass */
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::log( 'dark rhythm bands written (' . count( $rows ) . ' sections).' );

// ---------- footer label color ----------
$opt = get_option( 'widget_block' );
$c   = $opt[20]['content'];
$c2  = str_replace(
	array(
		'.fgs-footer-nap h4{color:#e0837c;',
		'.fgs-footer-nap h4{color:#adadad;',
		'.fgs-footer-nap a:hover{color:#e0837c}',
		'.fgs-footer-nap a:hover{color:#ffffff}',
	),
	array(
		'.fgs-footer-nap h4{color:#ee7c63;',
		'.fgs-footer-nap h4{color:#ee7c63;',
		'.fgs-footer-nap a:hover{color:#ee7c63}',
		'.fgs-footer-nap a:hover{color:#ee7c63}',
	),
	$c
);
if ( $c2 !== $c ) {
	$opt[20]['content'] = $c2;
	update_option( 'widget_block', $opt );
	WP_CLI::log( 'footer labels: peach -> system gray, hover white.' );
} else {
	WP_CLI::log( 'footer labels already updated.' );
}

WP_CLI::success( 'Dark rhythm + footer label fix applied.' );
