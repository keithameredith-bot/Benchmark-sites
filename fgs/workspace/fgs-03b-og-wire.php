<?php
/**
 * fgs-03b-og-wire.php — Point AIOSEO at the generated OG image:
 * 1. Global default social image (Facebook + Twitter) -> fgs-og-image.png
 * 2. Homepage (page 90) og image -> custom_image with that URL
 * Idempotent. Usage: wp eval-file fgs-03b-og-wire.php
 */

$att = get_posts(
	array(
		'post_type'   => 'attachment',
		'title'       => 'FGS OG Image',
		'post_status' => 'inherit',
		'numberposts' => 1,
	)
);
if ( ! $att ) {
	WP_CLI::error( 'OG image attachment not found — run fgs-03-og-image.php first.' );
}
$url = wp_get_attachment_url( $att[0]->ID );

if ( ! function_exists( 'aioseo' ) ) {
	WP_CLI::error( 'AIOSEO not loaded.' );
}

// Global defaults.
aioseo()->options->social->facebook->general->defaultImageSourcePosts = 'default';
aioseo()->options->social->facebook->general->defaultImagePosts       = $url;
aioseo()->options->social->twitter->general->defaultImageSourcePosts  = 'default';
aioseo()->options->social->twitter->general->defaultImagePosts        = $url;
WP_CLI::log( 'AIOSEO global default social image set: ' . $url );

// Homepage row.
global $wpdb;
$table = $wpdb->prefix . 'aioseo_posts';
$row   = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM {$table} WHERE post_id = %d", 90 ) );
if ( $row ) {
	$wpdb->update(
		$table,
		array(
			'og_image_type'       => 'custom_image',
			'og_image_custom_url' => $url,
		),
		array( 'post_id' => 90 )
	);
	WP_CLI::log( 'Homepage (90) og_image set.' );
} else {
	$wpdb->insert(
		$table,
		array(
			'post_id'             => 90,
			'og_image_type'       => 'custom_image',
			'og_image_custom_url' => $url,
			'created'             => current_time( 'mysql' ),
			'updated'             => current_time( 'mysql' ),
		)
	);
	WP_CLI::log( 'Homepage (90) aioseo row created with og_image.' );
}

// Verify readback.
$check = aioseo()->options->social->facebook->general->defaultImagePosts;
WP_CLI::success( 'Readback default image: ' . $check );
