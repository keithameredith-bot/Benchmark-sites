<?php
/**
 * wp eval-file author-aioseo-tweaks.php — idempotent.
 * 1. Alex (user 12) EEAT meta: authorCustomUrl -> /our-team/ (so "See Full Bio" skips the thin author archive).
 * 2. aioseo_options: author archives -> noindex (single-author site; archive duplicates /blog/).
 */

// --- 1. authorCustomUrl ---
$meta = get_user_meta( 12, 'aioseo_author_meta_data', true );
if ( ! is_array( $meta ) ) {
	echo "ABORT: aioseo_author_meta_data not an array for user 12\n";
} else {
	$meta['authorCustomUrl'] = home_url( '/our-team/' );
	update_user_meta( 12, 'aioseo_author_meta_data', $meta );
	echo "authorCustomUrl => " . $meta['authorCustomUrl'] . "\n";
}

// --- 2. author archives noindex ---
$raw = get_option( 'aioseo_options' );
$o   = json_decode( $raw );
if ( ! isset( $o->searchAppearance->archives->author ) ) {
	echo "ABORT: author archive settings not found in aioseo_options — flip it in the UI instead\n";
	echo "Top-level archives keys: " . implode( ', ', array_keys( (array) ( $o->searchAppearance->archives ?? new stdClass() ) ) ) . "\n";
} else {
	$a = $o->searchAppearance->archives->author;
	echo "BEFORE: " . wp_json_encode( $a->advanced->robotsMeta ?? 'no robotsMeta key' ) . "\n";
	if ( isset( $a->advanced->robotsMeta ) ) {
		$a->advanced->robotsMeta->default = false;
		$a->advanced->robotsMeta->noindex = true;
		update_option( 'aioseo_options', wp_json_encode( $o ) );
		echo "AFTER:  " . wp_json_encode( $a->advanced->robotsMeta ) . "\n";
	} else {
		echo "ABORT: robotsMeta key missing — flip noindex in AIOSEO UI\n";
	}
}
