<?php
/**
 * fgs-06-real-hero-photos.php — Replace placehold.co hero banners with FGS's real job-site
 * photos on the five service pages where a photo genuinely matches the service.
 * Lab (216), ESA (223), GPR (264) keep placeholders until the client sends matching photos.
 * Idempotent: replaces the <img src="https://placehold.co/1200x500..."> only if present.
 * Usage: wp eval-file fgs-06-real-hero-photos.php
 */

$map = array(
	167 => array( // Sinkhole Investigation
		'url' => '/wp-content/uploads/2026/05/fgs-cat-excavator-deep-sinkhole-excavation-soil-stratigraphy-florida.jpg',
		'alt' => 'FGS excavator exposing soil stratigraphy during a deep sinkhole excavation in Central Florida',
	),
	205 => array( // Drilling
		'url' => '/wp-content/uploads/2026/05/fgs-company-truck-excavator-site-investigation-florida-geotechnical.jpg',
		'alt' => 'FGS truck and excavator mobilized for a geotechnical site investigation in Florida',
	),
	202 => array( // CMT
		'url' => '/wp-content/uploads/2026/05/fgs-roadway-materials-testing-crew-truck-compaction-florida.jpg',
		'alt' => 'FGS crew performing roadway materials and compaction testing in Florida',
	),
	225 => array( // Pavement
		'url' => '/wp-content/uploads/2026/05/fgs-roadway-materials-testing-crew-truck-compaction-florida.jpg',
		'alt' => 'FGS technicians evaluating roadway subgrade and compaction for pavement design in Florida',
	),
	230 => array( // Concrete & Asphalt
		'url' => '/wp-content/uploads/2026/05/fgs-concrete-core-drilling-precast-structure-team-florida.jpg',
		'alt' => 'FGS team core-drilling concrete at a precast structure in Florida',
	),
	269 => array( // Foundation
		'url' => '/wp-content/uploads/2026/05/fgs-concrete-core-drilling-wall-workers-florida-geotechnical-services.jpg',
		'alt' => 'FGS workers core-drilling a concrete wall during a foundation evaluation in Florida',
	),
);

foreach ( $map as $pid => $img ) {
	$p       = get_post( $pid );
	$content = $p->post_content;
	$pattern = '#<img src="https://placehold\.co/1200x500/[^"]*"([^>]*) alt="[^"]*"([^>]*)/?>#';
	$replace = '<img src="' . $img['url'] . '"$1 alt="' . esc_attr( $img['alt'] ) . '"$2/>';
	$new     = preg_replace( $pattern, $replace, $content, 1, $n );
	if ( $n ) {
		$r = wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $new ) ), true );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( "{$pid}: " . $r->get_error_message() );
		}
		WP_CLI::log( "{$pid} ({$p->post_title}): hero photo swapped." );
	} else {
		WP_CLI::log( "{$pid} ({$p->post_title}): no 1200x500 placeholder found — skipped." );
	}
}
WP_CLI::success( 'Hero photo swap done.' );
