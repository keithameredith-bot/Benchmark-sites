<?php
/**
 * fgs-07-revert-hero-photos.php — Keith feedback 2026-06-11: the real-photo hero swaps
 * (fgs-06) looked wrong (sizing/subject mismatch). Restore correctly-sized 1200x500
 * placeholders, in the new palette (blush bg / deep logo red text), until the client
 * sends properly shot hero images.
 * Idempotent. Usage: wp eval-file fgs-07-revert-hero-photos.php
 */

$map = array(
	167 => array( 'text' => 'FGS+Sinkhole+Investigation', 'alt' => 'Sinkhole investigation fieldwork in Central Florida — placeholder pending site photo' ),
	205 => array( 'text' => 'FGS+Geotechnical+Drilling', 'alt' => 'FGS drill rig performing SPT borings in Florida — placeholder pending site photo' ),
	202 => array( 'text' => 'FGS+Materials+Testing', 'alt' => 'FGS construction materials testing crew — placeholder pending site photo' ),
	225 => array( 'text' => 'FGS+Pavement+Design', 'alt' => 'Pavement evaluation and design in Florida — placeholder pending site photo' ),
	230 => array( 'text' => 'FGS+Concrete+%26+Asphalt+Testing', 'alt' => 'Concrete and asphalt testing in Florida — placeholder pending site photo' ),
	269 => array( 'text' => 'FGS+Foundation+Engineering', 'alt' => 'Foundation engineering on a Central Florida site — placeholder pending site photo' ),
);

foreach ( $map as $pid => $ph ) {
	$p       = get_post( $pid );
	$content = $p->post_content;
	$new_src = 'https://placehold.co/1200x500/f0e5e5/a91513?text=' . $ph['text'];

	// Replace the fgs-06 real-photo hero (uploads/2026/05/fgs-*.jpg inside the hero figure)
	$pattern = '#<img src="/wp-content/uploads/2026/05/fgs-[^"]+"([^>]*) alt="[^"]*"([^>]*)/?>#';
	$replace = '<img src="' . $new_src . '"$1 alt="' . esc_attr( $ph['alt'] ) . '"$2/>';
	$new     = preg_replace( $pattern, $replace, $content, 1, $n );

	if ( $n ) {
		$r = wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $new ) ), true );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( "{$pid}: " . $r->get_error_message() );
		}
		WP_CLI::log( "{$pid} ({$p->post_title}): reverted to sized placeholder." );
	} elseif ( false !== strpos( $content, 'placehold.co/1200x500/f0e5e5' ) ) {
		WP_CLI::log( "{$pid}: already on new placeholder — skip." );
	} else {
		WP_CLI::log( "{$pid}: no fgs-06 photo found — skip." );
	}
}

// Also refresh remaining ORIGINAL placeholders (old brand colors in URL) to new palette.
global $wpdb;
$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE '%placehold.co/%/e8e8e3/c8102e%' AND post_type='page'" );
foreach ( $ids as $id ) {
	$p   = get_post( $id );
	$new = str_replace( 'e8e8e3/c8102e', 'f0e5e5/a91513', $p->post_content );
	wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $new ) ), true );
	WP_CLI::log( "{$id} ({$p->post_title}): placeholder colors refreshed." );
}
WP_CLI::success( 'Hero placeholders restored/normalized.' );
