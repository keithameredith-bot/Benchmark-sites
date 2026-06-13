<?php
// What is actually inside the AC / brake / tune-up / new-tires / balancing pages?
foreach ( array( 226001 => 'AC', 226004 => 'BRAKES', 226007 => 'TUNEUP', 226006 => 'NEWTIRES', 226003 => 'BALANCE' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	echo "=== $label (len " . strlen( $c ) . ") first 700 chars ===\n" . substr( $c, 0, 700 ) . "\n\n";
	echo "--- block names: " . implode( ', ', array_slice( array_unique( array_filter( array_map( function ( $b ) { return $b['blockName']; }, parse_blocks( $c ) ) ) ), 0, 10 ) ) . "\n";
	echo "--- contains te-np: " . ( strpos( $c, 'te-np' ) !== false ? 'YES' : 'no' ) . " | contains <h1: " . ( stripos( $c, '<h1' ) !== false ? 'YES' : 'no' ) . "\n\n";
}
