<?php
// Import photo batch 2 (pest control fleet, lifted jeep, tire stack). Idempotent by filename.
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
$dir  = 'C:/Users/keith/Desktop/tire-express-workspace/processed-pics/';
$pics = array(
	'lifted-jeep-on-mud-tires-ocala.webp'   => 'Lifted Jeep Wrangler on mud tires at Tire Express in Ocala, FL',
	'fleet-account-pest-control-truck.webp' => '1-800-Pest-Control fleet truck at Tire Express and Complete Auto Service in Ocala',
	'fleet-truck-on-lift-ocala.webp'        => 'Fleet truck on the lift for service at Tire Express in Ocala',
	'fleet-flatbed-at-tire-express.webp'    => 'Fleet flatbed truck at the Tire Express service bays in Ocala, FL',
	'new-tires-in-stock-ocala.webp'         => 'New tires in stock at Tire Express in Ocala, FL',
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
