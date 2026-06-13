<?php
/**
 * wp eval-file apply-serp-tweaks.php — 2026-06-10 DataForSEO tweaks (Keith approved). Idempotent.
 * Syncs WP post_title to the new spec H1s (slugs untouched), writes custom AIOSEO titles/descs
 * where the wording goes beyond the default pattern, sets AIOSEO social profile URLs (sameAs).
 */
global $wpdb;

// post_title sync (default AIOSEO title = "#post_title - #site_title")
$titles = array(
	100771 => 'Central Florida Fence Builders',
	100894 => 'Custom Home Builders in Central Florida',
	100513 => 'Pole Barn Builders in Central Florida',
	101740 => 'Central Florida Boat Lift Installation & Repair',
	100421 => 'Central Florida Boathouse Builders',
);
foreach ( $titles as $id => $t ) {
	wp_update_post( array( 'ID' => $id, 'post_title' => $t ) );
	echo "post_title $id => $t (slug: " . get_post( $id )->post_name . ")\n";
}

// custom AIOSEO titles/descriptions
$meta = array(
	100894 => array( 'title' => 'Custom Home Builders in Central Florida — New Construction', 'description' => 'JSC builds custom homes and new construction across Central Florida — in-house craftsmen, honest pricing, built without the wait. Free quotes!' ),
	100658 => array( 'title' => 'Home Remodeling Central Florida — Remodeling Contractors' ),
	101740 => array( 'title' => 'Central Florida Boat Lift Installation & Repair - JSC', 'description' => 'Boat lift installation and repair in Central Florida. JSC installs, replaces, and services boat lifts on lakes, rivers, and coastlines. Free quotes!' ),
	102114 => array( 'title' => 'Container Home Builders in Florida — Shipping Container Homes' ),
	100771 => array( 'description' => 'Wood fencing, vinyl, steel posts, barbwire, wire mesh fencing and more. Need a custom gate? We can do that too. We are the best central Florida fence builders.' ),
	100513 => array( 'description' => 'We are the best pole barn builders in central Florida. Our work speaks for itself. Whether its a kit or you want a custom pole barn, we can build it!' ),
);
foreach ( $meta as $id => $m ) {
	foreach ( $m as $k => $v ) {
		$len = mb_strlen( $v );
		if ( ( 'title' === $k && $len > 65 ) || ( 'description' === $k && $len > 160 ) ) { echo "ABORT $id $k: $len chars\n"; continue 2; }
	}
	$wpdb->update( $wpdb->prefix . 'aioseo_posts', $m, array( 'post_id' => $id ) );
	echo "aioseo $id: " . implode( ', ', array_map( function ( $k, $v ) { return "$k=" . mb_strlen( $v ); }, array_keys( $m ), $m ) ) . "\n";
}

// AIOSEO social profiles -> sameAs on the org schema
$raw = get_option( 'aioseo_options' );
$o   = json_decode( $raw );
if ( isset( $o->social->profiles->urls ) ) {
	$o->social->profiles->urls->facebookPageUrl = 'https://www.facebook.com/JSCContractingInc';
	$o->social->profiles->urls->instagramUrl    = 'https://www.instagram.com/jsc_contracting_inc/';
	$o->social->profiles->urls->tiktokUrl       = 'https://www.tiktok.com/@jsccontractinginc';
	update_option( 'aioseo_options', wp_json_encode( $o ) );
	echo "social profiles set (FB, IG, TikTok)\n";
} else {
	echo "ABORT socials: social->profiles->urls not found\n";
}
echo "DONE\n";
