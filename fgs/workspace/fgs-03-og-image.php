<?php
/**
 * fgs-03-og-image.php — Generate branded 1200x630 OG image (GD + Urbanist TTFs),
 * sideload into media library. Idempotent: skips if an attachment titled
 * "FGS OG Image" already exists.
 * Usage: wp eval-file fgs-03-og-image.php
 */

$existing = get_posts(
	array(
		'post_type'   => 'attachment',
		'title'       => 'FGS OG Image',
		'post_status' => 'inherit',
		'numberposts' => 1,
	)
);
if ( $existing ) {
	WP_CLI::success( 'OG image already exists: ' . wp_get_attachment_url( $existing[0]->ID ) . ' (ID ' . $existing[0]->ID . ')' );
	return;
}

$font_bold = 'C:/Users/keith/Desktop/fgs-workspace/_urbanist-800.ttf';
$font_med  = 'C:/Users/keith/Desktop/fgs-workspace/_urbanist-500.ttf';
if ( ! file_exists( $font_bold ) || ! file_exists( $font_med ) ) {
	WP_CLI::error( 'Urbanist TTFs not found.' );
}

$w   = 1200;
$h   = 630;
$img = imagecreatetruecolor( $w, $h );

$charcoal = imagecolorallocate( $img, 0x2d, 0x2d, 0x2d );
$dark     = imagecolorallocate( $img, 0x24, 0x24, 0x24 );
$red      = imagecolorallocate( $img, 0xa9, 0x15, 0x13 );
$white    = imagecolorallocate( $img, 0xff, 0xff, 0xff );
$gray     = imagecolorallocate( $img, 0xad, 0xad, 0xad );

imagefilledrectangle( $img, 0, 0, $w, $h, $charcoal );
// subtle diagonal band for depth
imagefilledpolygon( $img, array( 760, 0, 1200, 0, 1200, 630, 980, 630 ), $dark );
// red accent bar, left edge
imagefilledrectangle( $img, 0, 0, 14, $h, $red );

// kicker
imagettftext( $img, 22, 0, 80, 150, $red, $font_bold, 'FLORIDA GEOTECHNICAL SERVICES' );
// headline (two lines)
imagettftext( $img, 58, 0, 80, 260, $white, $font_bold, 'From Soil' );
imagettftext( $img, 58, 0, 80, 350, $white, $font_bold, 'to Structure.' );
// divider
imagefilledrectangle( $img, 84, 400, 364, 404, $red );
// sub-lines
imagettftext( $img, 24, 0, 80, 470, $gray, $font_med, 'Geotechnical Engineering · Soil & Materials Testing' );
imagettftext( $img, 24, 0, 80, 515, $gray, $font_med, 'Sinkhole Investigation · Statewide Florida' );
imagettftext( $img, 22, 0, 80, 580, $white, $font_med, '(352) 619-9292  ·  Ocala, FL' );

$tmp = get_temp_dir() . 'fgs-og-image.png';
imagepng( $img, $tmp, 9 );
imagedestroy( $img );

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$file_array = array(
	'name'     => 'fgs-og-image.png',
	'tmp_name' => $tmp,
);
$id = media_handle_sideload( $file_array, 0, 'FGS OG Image' );
if ( is_wp_error( $id ) ) {
	WP_CLI::error( 'Sideload failed: ' . $id->get_error_message() );
}
update_post_meta( $id, '_wp_attachment_image_alt', 'Florida Geotechnical Services — geotechnical engineering, soil and materials testing, statewide Florida' );
WP_CLI::success( 'OG image created: ' . wp_get_attachment_url( $id ) . ' (ID ' . $id . ')' );
