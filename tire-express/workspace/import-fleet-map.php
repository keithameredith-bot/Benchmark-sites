<?php
// Import the fleet pic + map pin screenshot. Idempotent by filename.
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
$dir  = 'C:/Users/keith/Desktop/tire-express-workspace/processed-pics/';
$pics = array(
	'fleet-accounts-ocala.webp' => 'Fleet vehicle serviced at Tire Express and Complete Auto Service in Ocala, FL',
	'tire-express-map-pin.png'  => 'Map showing Tire Express and Complete Auto Service at 1708 E Silver Springs Blvd, Ocala, FL',
);
global $wpdb;
foreach ( $pics as $file => $alt ) {
	$exists = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $file ) );
	if ( $exists ) { echo "SKIP $file (att $exists)\n"; continue; }
	$tmpfile = wp_tempnam( $file );
	copy( $dir . $file, $tmpfile );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmpfile ), 0, null );
	if ( is_wp_error( $id ) ) { echo "ERR $file: " . $id->get_error_message() . "\n"; continue; }
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	echo "OK $file -> $id\n";
}
echo "DONE\n";
