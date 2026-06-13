<?php
// Apply the approved (round-1) hero gradient to oil-change + new-tires (embedded CSS, not on te-np.css). Idempotent.
global $wpdb;
$old = 'rgba(13,38,96,.62) 72%,rgba(18,72,215,.42) 100%';
$new = 'rgba(13,38,96,.38) 72%,rgba(18,72,215,.18) 100%';
foreach ( array( 226005 => 'oil-change', 226006 => 'new-tires' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	if ( false !== strpos( $c, $new ) ) { echo "$label already updated\n"; continue; }
	if ( false === strpos( $c, $old ) ) { echo "$label: gradient string not found — inspect\n"; continue; }
	$c = str_replace( $old, $new, $c );
	$wpdb->update( $wpdb->posts, array( 'post_content' => $c ), array( 'ID' => $id ) );
	clean_post_cache( $id );
	echo "$label updated\n";
}
