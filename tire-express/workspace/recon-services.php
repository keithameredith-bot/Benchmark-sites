<?php
// State of the service pages: content length, builder type, price mentions, status.
$ids = array( 226001, 226003, 226004, 226005, 226006, 226007, 226008, 226009, 226010, 7, 15 );
foreach ( $ids as $id ) {
	$p = get_post( $id );
	if ( ! $p ) { echo "$id: MISSING\n"; continue; }
	$c   = $p->post_content;
	$len = strlen( $c );
	$builder = ( false !== strpos( $c, 'et_pb_' ) ) ? 'DIVI' : ( ( false !== strpos( $c, 'wp:kadence' ) ) ? 'KADENCE' : ( ( false !== strpos( $c, 'wp:' ) ) ? 'blocks' : 'classic/empty' ) );
	preg_match_all( '/\$\s?\d[\d,.]*/', $c, $m );
	$prices = $m[0] ? implode( ' ', array_slice( $m[0], 0, 12 ) ) : '—';
	printf( "%-7d %-38s %-9s len=%-7d %-10s prices: %s\n", $id, $p->post_name, $p->post_status, $len, $builder, $prices );
}
