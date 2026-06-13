<?php
// Import the optimized map webp. Idempotent.
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
global $wpdb;
$file = 'tire-express-map.webp';
$exists = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $file ) );
if ( $exists ) { echo "SKIP (att $exists)\n"; exit; }
$tmpfile = wp_tempnam( $file );
copy( 'C:/Users/keith/Desktop/tire-express-workspace/processed-pics/' . $file, $tmpfile );
$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmpfile ), 0, null );
if ( is_wp_error( $id ) ) { echo "ERR: " . $id->get_error_message() . "\n"; exit; }
update_post_meta( $id, '_wp_attachment_image_alt', 'Map showing Tire Express and Complete Auto Service at 1708 E Silver Springs Blvd, Ocala, FL' );
echo "OK $file -> $id\n";
