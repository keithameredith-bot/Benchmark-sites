<?php
/**
 * fgs-11b-comment-sweep.php — Two cleanups after the body rollout:
 * 1. Remove pre-existing template authoring comments (`<p><!-- ==== SECTION ==== --></p>`)
 *    that render as empty paragraphs, across all pages.
 * 2. De-band Contact row 94_34bd44-62 ("two-grid" layout, missed by the columns-based regex).
 * Idempotent. Usage: wp eval-file fgs-11b-comment-sweep.php
 */

global $wpdb;
$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type='page' AND post_status IN ('publish','draft')" );

foreach ( $ids as $id ) {
	$p   = get_post( $id );
	$new = preg_replace( '#\n?<p><!-- ={2,}[^\n]*?={2,} --></p>\n?#', "\n", $p->post_content, -1, $n );
	if ( $n ) {
		$r = wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $new ) ), true );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( "{$id}: " . $r->get_error_message() );
		}
		WP_CLI::log( "{$id} ({$p->post_title}): removed {$n} comment paragraphs." );
	}
}

// Contact two-grid row de-band.
$p   = get_post( 94 );
$new = str_replace(
	'<!-- wp:kadence/rowlayout {"uniqueID":"94_34bd44-62","colLayout":"two-grid","bgColor":"#f3f3f3","align":"full",',
	'<!-- wp:kadence/rowlayout {"uniqueID":"94_34bd44-62","colLayout":"two-grid","bgColor":"#ffffff",',
	$p->post_content,
	$n
);
if ( $n ) {
	$new = preg_replace(
		'#(<!-- wp:kadence/rowlayout \{"uniqueID":"94_34bd44-62".*?"className":"wp-block-kadence-rowlayout) alignfull(")#s',
		'$1 alignnone$2',
		$new
	);
	wp_update_post( array( 'ID' => 94, 'post_content' => wp_slash( $new ) ), true );
	WP_CLI::log( '94: two-grid row de-banded.' );
} else {
	WP_CLI::log( '94: two-grid row already de-banded.' );
}

WP_CLI::success( 'Sweep done.' );
