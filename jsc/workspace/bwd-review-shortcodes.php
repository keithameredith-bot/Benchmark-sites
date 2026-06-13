<?php
/**
 * BWD Review Shortcodes — JSC Contracting
 * Drop into the child theme's functions.php or a code-snippet plugin.
 *
 * ─────────────────────────────────────────────────────────
 *  TO UPDATE THE REVIEW COUNT / RATING: edit ONLY the two
 *  values below. Every page updates instantly, sitewide.
 * ─────────────────────────────────────────────────────────
 */

function bwd_review_data() {
	return array(
		'count'  => 25,    // ← UPDATE ME: Google review count
		'rating' => 5.0,   // ← UPDATE ME: Google rating
		'url'    => 'https://g.page/r/CU_afPuU9LllEAE/review', // GBP review link
	);
}

/** [bwd_review_count] → 27 */
add_shortcode( 'bwd_review_count', function () {
	return esc_html( bwd_review_data()['count'] );
} );

/** [bwd_rating] → 5.0 */
add_shortcode( 'bwd_rating', function () {
	return esc_html( number_format( bwd_review_data()['rating'], 1 ) );
} );

/**
 * [bwd_stars] → full badge: ★★★★★ 5.0 · 27 Google Reviews (linked to GBP)
 * [bwd_stars link="no"] → same badge, no link
 */
add_shortcode( 'bwd_stars', function ( $atts ) {
	$atts = shortcode_atts( array( 'link' => 'yes' ), $atts );
	$d    = bwd_review_data();

	$inner = sprintf(
		'<span class="bwd-stars-icons" aria-hidden="true">★★★★★</span> <strong>%s</strong> · %d Google Reviews',
		number_format( $d['rating'], 1 ),
		(int) $d['count']
	);

	if ( 'yes' === $atts['link'] && $d['url'] ) {
		return sprintf(
			'<a class="bwd-stars" href="%s" target="_blank" rel="noopener nofollow" aria-label="Read our %d Google reviews, rated %s stars">%s</a>',
			esc_url( $d['url'] ),
			(int) $d['count'],
			number_format( $d['rating'], 1 ),
			$inner
		);
	}

	return '<span class="bwd-stars">' . $inner . '</span>';
} );
