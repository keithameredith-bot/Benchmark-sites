<?php
/**
 * fgs-04-aioseo-meta.php — Phase 2 SEO foundation.
 * 1. Fill missing AIOSEO titles/descriptions (pillar page 146 had NONE).
 * 2. Fix Local Business data: zip 34471->34474 (NAP mismatch vs contact page + live site),
 *    "AVe" typo, about/contact URLs, map center (was Seattle default), phone formatting.
 * 3. Unpublish 7 starter-template blog posts (draft, not delete — reversible).
 * Idempotent. Usage: wp eval-file fgs-04-aioseo-meta.php
 */

global $wpdb;
$table = $wpdb->prefix . 'aioseo_posts';

// ---------- 1. Titles/descriptions ----------
$meta = array(
	146 => array(
		'Geotechnical Engineering Florida | Stamped Reports | FGS',
		'Geotechnical engineering across all 67 Florida counties. SPT borings, lab testing, stamped foundation reports, sinkhole evaluations. (352) 619-9292.',
	),
	98  => array(
		'Our Services | Geotechnical, Drilling & Testing | FGS Florida',
		'Nine geotechnical and materials-testing service lines under one Florida roof — drilling, soil lab, CMT, GPR, ESA, pavement, foundations, sinkholes. (352) 619-9292.',
	),
	96  => array(
		'Our Mission | Florida Geotechnical Services',
		'Why FGS exists: faster turnarounds, the engineer on the phone is the engineer on the report, and Florida-specific geotechnical work done right.',
	),
	99  => array(
		'Project Gallery | Florida Geotechnical Services',
		'Field photos from FGS projects across Florida — drilling, sinkhole excavations, materials testing, and laboratory work.',
	),
	6   => array(
		'Privacy Policy | Florida Geotechnical Services',
		'How Florida Geotechnical Services collects, uses, and protects information submitted through this site.',
	),
);
foreach ( $meta as $pid => $td ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT id, title, description FROM {$table} WHERE post_id = %d", $pid ) );
	if ( $row && $row->title === $td[0] && $row->description === $td[1] ) {
		WP_CLI::log( "meta {$pid}: already set — skip." );
		continue;
	}
	if ( $row ) {
		$wpdb->update( $table, array( 'title' => $td[0], 'description' => $td[1] ), array( 'post_id' => $pid ) );
	} else {
		$wpdb->insert(
			$table,
			array(
				'post_id'     => $pid,
				'title'       => $td[0],
				'description' => $td[1],
				'created'     => current_time( 'mysql' ),
				'updated'     => current_time( 'mysql' ),
			)
		);
	}
	WP_CLI::log( "meta {$pid}: written." );
}

// ---------- 2. Local Business fixes ----------
$pro = json_decode( get_option( 'aioseo_options_pro' ), true );
if ( isset( $pro['localBusiness']['locations']['business'] ) ) {
	$b       = &$pro['localBusiness']['locations']['business'];
	$changed = array();
	if ( '34474' !== $b['address']['zipCode'] ) {
		$b['address']['zipCode'] = '34474';
		$changed[]               = 'zip->34474';
	}
	if ( '302 SW 33rd Ave' !== $b['address']['streetLine1'] ) {
		$b['address']['streetLine1'] = '302 SW 33rd Ave';
		$changed[]                   = 'street typo';
	}
	if ( '(352) 619-9292' !== $b['contact']['phoneFormatted'] ) {
		$b['contact']['phoneFormatted'] = '(352) 619-9292';
		$changed[]                      = 'phone format';
	}
	if ( empty( $b['urls']['aboutPage'] ) ) {
		$b['urls']['aboutPage']   = home_url( '/about/' );
		$b['urls']['contactPage'] = home_url( '/contact/' );
		$changed[]                = 'about/contact urls';
	}
	unset( $b );
	$maps = &$pro['localBusiness']['maps']['mapOptions']['center'];
	if ( abs( $maps['lat'] - 29.1827 ) > 0.01 ) {
		$maps['lat'] = 29.1827;
		$maps['lng'] = -82.1856;
		$changed[]   = 'map center -> Ocala';
	}
	unset( $maps );
	if ( $changed ) {
		update_option( 'aioseo_options_pro', wp_json_encode( $pro ) );
		WP_CLI::log( 'localBusiness fixed: ' . implode( ', ', $changed ) );
	} else {
		WP_CLI::log( 'localBusiness: already correct.' );
	}
} else {
	WP_CLI::warning( 'localBusiness structure not found in aioseo_options_pro.' );
}

// ---------- 3. Unpublish starter posts ----------
foreach ( array( 2, 34, 36, 37, 39, 41, 42 ) as $pid ) {
	$p = get_post( $pid );
	if ( $p && 'publish' === $p->post_status ) {
		wp_update_post( array( 'ID' => $pid, 'post_status' => 'draft' ) );
		WP_CLI::log( "post {$pid} ({$p->post_title}): -> draft" );
	} elseif ( $p ) {
		WP_CLI::log( "post {$pid}: already {$p->post_status}." );
	}
}

WP_CLI::success( 'Phase 2 meta/LB/cleanup complete.' );
