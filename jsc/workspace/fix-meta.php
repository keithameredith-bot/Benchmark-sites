<?php
/**
 * wp eval-file fix-meta.php — title/meta straggler fixes from the 2026-06-10 sweep. Idempotent.
 * Service-page titles untouched (preservation rule). Asserts lengths before writing.
 */
global $wpdb;

$fixes = array(
	// page_id => [ 'title' => ..., 'description' => ... ] (null = leave)
	90829  => array( 'description' => "Thanks for reaching out to JSC Contracting — your message is on its way to the right team member. We'll get back to you within one business day." ),
	91280  => array( 'description' => 'JSC Contracting was founded in 2018 on marine construction roots going back to 1984. Meet the Central Florida builder behind docks, barndominiums and homes.' ),
	100468 => array( 'description' => 'Florida seawall construction and repair by JSC Contracting. Engineered foundations, anchored tie-backs, and fast repairs that protect your waterfront.' ),
	101224 => array( 'description' => 'Photos from real JSC boathouse builds across Central Florida — covered slips, decking, boat lifts and custom finishes. Every photo is our own work.' ),
	101248 => array( 'description' => 'Photos from JSC seawall construction and repair projects on Central Florida lakes and waterways. Every photo is a real JSC job.' ),
	101434 => array( 'description' => 'Our privacy policy at JSC Contracting. We keep your information secure and never share it with third parties.' ),
	101257 => array( 'description' => 'Check out our past pole barn construction jobs here at JSC Contracting. Real barns, real builds, no stock photos.' ),
	// blog posts — custom titles trimmed to ~60, descriptions to <=160
	101827 => array(
		'title'       => 'Central Florida Seawall Inspection Checklist: 7 Warning Signs',
		'description' => 'Hurricane season starts June 1. The 7 warning signs every Central Florida waterfront owner should check on their seawall before the storms roll in.',
	),
	101890 => array(
		'title'       => 'Fence Installation in Central Florida — 2026 Costs & Materials',
		'description' => 'Wood, vinyl, chain link or aluminum — which fence holds up in Central Florida heat, humidity and storms? Real costs and honest pros and cons from a builder.',
	),
	102014 => array(
		'title'       => 'Building a Dock on Lake George FL — Wind, Waves & What It Takes',
		'description' => "Lake George is Florida's second-largest lake and one of the roughest to build on. What goes into designing a dock that survives the wind and waves.",
	),
);

foreach ( $fixes as $id => $f ) {
	$data = array();
	if ( isset( $f['title'] ) ) {
		$tl = mb_strlen( $f['title'] );
		if ( $tl > 65 ) { echo "ABORT $id: title $tl chars\n"; continue; }
		$data['title'] = $f['title'];
	}
	if ( isset( $f['description'] ) ) {
		$dl = mb_strlen( $f['description'] );
		if ( $dl > 160 || $dl < 70 ) { echo "ABORT $id: desc $dl chars\n"; continue; }
		$data['description'] = $f['description'];
	}
	$exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}aioseo_posts WHERE post_id = %d", $id ) );
	if ( $exists ) {
		$wpdb->update( $wpdb->prefix . 'aioseo_posts', $data, array( 'post_id' => $id ) );
	} else {
		$data['post_id'] = $id;
		$wpdb->insert( $wpdb->prefix . 'aioseo_posts', $data );
	}
	$lens = array();
	foreach ( $data as $k => $v ) { if ( 'post_id' !== $k ) { $lens[] = "$k=" . mb_strlen( $v ); } }
	echo "OK $id (" . get_post( $id )->post_name . "): " . implode( ', ', $lens ) . "\n";
}
echo "DONE\n";
