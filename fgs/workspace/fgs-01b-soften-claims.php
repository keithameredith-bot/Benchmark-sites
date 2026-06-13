<?php
/**
 * fgs-01b-soften-claims.php — STAGED, dry-run by default. DO NOT APPLY unless the client
 * cannot confirm the credential claims (see CLIENT-CONFIRMATION-CHECKLIST.md).
 *
 * Replaces unverified credential claims sitewide with defensible equivalents.
 * Dry run:  wp eval-file fgs-01b-soften-claims.php          (reports occurrences only)
 * Apply:    FGS_APPLY=1 wp eval-file fgs-01b-soften-claims.php
 */

$replacements = array(
	// trust bars
	'✓ FLORIDA P.E. #58334'            => '✓ FLORIDA-LICENSED PROFESSIONAL ENGINEER',
	'✓ 45+ YEARS ENGINEERING EXPERIENCE' => '✓ DECADES OF FLORIDA ENGINEERING EXPERIENCE',
	'✓ 75+ YEARS COMBINED'             => '✓ DECADES OF COMBINED EXPERIENCE',
	'✓ FDOT WG 9.4.1 (FOUNDATION STUDIES)' => '✓ FDOT-EXPERIENCED ENGINEERING TEAM',
	// kickers / inline
	'Florida P.E. #58334 · FDOT Work Group 9.4.1' => 'Stamped by a Florida-licensed P.E.',
	'Florida P.E. #58334.'             => 'Reports stamped by a Florida-licensed P.E.',
	'FLORIDA P.E. #58334'              => 'FLORIDA-LICENSED P.E.',
	'Florida P.E. #58334'              => 'a Florida-licensed P.E.',
	'FDOT WORK GROUPS 9.1, 9.2, 9.3, 9.4.1' => 'FDOT PROJECT EXPERIENCE',
	'FDOT Work Groups 9.1–9.4.1.'      => 'Extensive FDOT project experience.',
	'FDOT Work Groups 9.1, 9.2, 9.3, and 9.4.1' => 'extensive FDOT project experience',
	'FDOT Work Group 9.4.1 (Standard Foundation Studies).' => '',
	'45+ years of geotechnical'        => 'decades of geotechnical',
	'45+ years of geotechnical engineering experience' => 'decades of geotechnical engineering experience',
	'75+ years of combined Florida geotechnical experience' => 'decades of combined Florida geotechnical experience',
);

$apply = (bool) getenv( 'FGS_APPLY' );
global $wpdb;

$ids = $wpdb->get_col(
	"SELECT ID FROM {$wpdb->posts}
	 WHERE post_type IN ('page','post','wp_block','kadence_element')
	   AND post_status IN ('publish','draft')"
);

$total = 0;
foreach ( $ids as $id ) {
	$post    = get_post( $id );
	$content = $post->post_content;
	$hits    = array();
	foreach ( $replacements as $from => $to ) {
		$n = substr_count( $content, $from );
		if ( $n > 0 ) {
			$hits[ $from ] = $n;
			$content       = str_replace( $from, $to, $content );
		}
	}
	if ( empty( $hits ) ) {
		continue;
	}
	$total += array_sum( $hits );
	WP_CLI::log( "Page {$id} ({$post->post_title}):" );
	foreach ( $hits as $from => $n ) {
		WP_CLI::log( "   {$n}x  {$from}" );
	}
	if ( $apply ) {
		$result = wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $content ) ), true );
		if ( is_wp_error( $result ) ) {
			WP_CLI::error( "Update failed on {$id}: " . $result->get_error_message() );
		}
		WP_CLI::log( '   -> WRITTEN' );
	}
}

WP_CLI::success( ( $apply ? 'APPLIED ' : 'DRY RUN — would replace ' ) . $total . ' occurrences.' );
