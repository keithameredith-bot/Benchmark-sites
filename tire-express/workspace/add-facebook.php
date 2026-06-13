<?php
// Facebook page: footer link (after Get Directions) + AIOSEO social profile (sameAs). Idempotent.
$fb = 'https://www.facebook.com/tireexpressandcompleteautoservice/';

// 1. footer widget
$widgets = get_option( 'widget_block' );
$changed = false;
foreach ( $widgets as $k => $w ) {
	if ( ! is_array( $w ) || empty( $w['content'] ) || false === strpos( $w['content'], 'Get Directions' ) ) { continue; }
	if ( false !== strpos( $w['content'], 'facebook.com' ) ) { echo "footer already has FB\n"; break; }
	$widgets[ $k ]['content'] = str_replace(
		'<a href="https://maps.google.com/?cid=14203459939532349517" target="_blank" rel="noopener">Get Directions &rarr;</a>',
		'<a href="https://maps.google.com/?cid=14203459939532349517" target="_blank" rel="noopener">Get Directions &rarr;</a><br><a href="' . $fb . '" target="_blank" rel="noopener">Follow us on Facebook</a>',
		$w['content'], $n
	);
	if ( $n ) { update_option( 'widget_block', $widgets ); $changed = true; echo "footer FB link added (widget $k)\n"; }
	break;
}
if ( ! $changed ) { echo "NOTE: footer not changed (already present or markup mismatch)\n"; }

// 2. AIOSEO social profile -> sameAs
$raw = get_option( 'aioseo_options' );
$o   = json_decode( $raw );
if ( isset( $o->social->profiles->urls ) ) {
	if ( $o->social->profiles->urls->facebookPageUrl !== $fb ) {
		$o->social->profiles->urls->facebookPageUrl = $fb;
		update_option( 'aioseo_options', wp_json_encode( $o ) );
		echo "AIOSEO facebookPageUrl set\n";
	} else { echo "AIOSEO already set\n"; }
}
