<?php
// new-tires page was applied pre-wp_slash-fix in an earlier session: CSS content:"2212" lost its backslash.
global $wpdb;
foreach ( array( 226006, 226005 ) as $id ) {
	$c = get_post( $id )->post_content;
	if ( false !== strpos( $c, 'content:"\\2212"' ) ) { echo "$id ok already\n"; continue; }
	if ( false === strpos( $c, 'content:"2212"' ) ) { echo "$id has neither form — inspect manually\n"; continue; }
	$c = str_replace( 'content:"2212"', 'content:"\\2212"', $c );
	$wpdb->update( $wpdb->posts, array( 'post_content' => $c ), array( 'ID' => $id ) );
	clean_post_cache( $id );
	echo "$id fixed\n";
}
