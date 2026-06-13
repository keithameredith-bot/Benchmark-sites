<?php
/**
 * wp eval-file import-new-pics.php — import Keith's 2026-06-10 photo batch (processed webp) with alts.
 * Idempotent: skips files already in the library (by filename).
 */
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$dir  = 'C:/Users/keith/Desktop/tire-express-workspace/processed-pics/';
$pics = array(
	'air-filter-replacement.webp'                        => 'Air filter replacement at Tire Express in Ocala, FL',
	'ben-working-at-his-desk.webp'                       => 'Ben at his desk at Tire Express and Complete Auto Service in Ocala',
	'car-and-truck-battery-replacement-in-ocala.webp'    => 'Car and truck battery replacement in Ocala at Tire Express',
	'coil-replacement.webp'                              => 'Ignition coil replacement at Tire Express in Ocala, FL',
	'engine-rebuild.webp'                                => 'Engine rebuild in progress at Tire Express in Ocala, FL',
	'new-heads-and-intake-on-a-motor.webp'               => 'New heads and intake installed on a motor at Tire Express',
	'new-strut-replacement.webp'                         => 'New strut replacement at Tire Express in Ocala, FL',
	'new-tires-and-wheels-on-a-f-250.webp'               => 'New off-road tires and wheels on a Ford F-250 at Tire Express in Ocala',
	'new-toyo-tires.webp'                                => 'New Toyo tires at Tire Express in Ocala, FL',
	'new-wheels-and-tires.webp'                          => 'New wheels and tires installed at Tire Express in Ocala',
	'tire-balancing-in-ocala.webp'                       => 'Tire balancing in Ocala at Tire Express and Complete Auto Service',
	'tire-express-crew-working-on-balancing-a-tire.webp' => 'Tire Express crew balancing a tire in Ocala, FL',
);

global $wpdb;
foreach ( $pics as $file => $alt ) {
	$exists = $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $file ) );
	if ( $exists ) { echo "SKIP $file (att $exists)\n"; continue; }
	$tmp = array( 'name' => $file, 'tmp_name' => $dir . $file );
	// sideload without moving the source: copy to tmp first
	$tmpfile = wp_tempnam( $file );
	copy( $dir . $file, $tmpfile );
	$tmp['tmp_name'] = $tmpfile;
	$id = media_handle_sideload( $tmp, 0, null );
	if ( is_wp_error( $id ) ) { echo "ERR $file: " . $id->get_error_message() . "\n"; continue; }
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	echo "OK $file -> $id\n";
}
echo "DONE\n";
