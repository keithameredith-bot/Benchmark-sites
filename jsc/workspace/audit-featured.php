<?php
// Featured image audit: every published page + post, its thumbnail, and the og:image AIOSEO would use.
foreach ( array( 'page', 'post' ) as $pt ) {
	echo "===== {$pt}s =====\n";
	$items = get_posts( array( 'post_type' => $pt, 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
	foreach ( $items as $p ) {
		$tid  = get_post_thumbnail_id( $p->ID );
		$file = $tid ? basename( get_attached_file( $tid ) ) : '—— NONE ——';
		$dim  = '';
		if ( $tid ) {
			$m = wp_get_attachment_metadata( $tid );
			$dim = isset( $m['width'] ) ? " ({$m['width']}x{$m['height']})" : '';
		}
		printf( "%-7d %-55s %s%s\n", $p->ID, '/' . $p->post_name . '/', $file, $dim );
	}
}
