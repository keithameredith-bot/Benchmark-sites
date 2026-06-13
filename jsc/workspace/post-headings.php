<?php
// Fence post: text of each material section (for accurate table numbers).
$c = get_post( 101890 )->post_content;
foreach ( array( 'Wood &mdash; Pressure-Treated Pine', 'Vinyl / PVC', 'Chain Link', 'Aluminum' ) as $h ) {
	$i = strpos( $c, $h );
	if ( false === $i ) { echo "MISS $h\n"; continue; }
	$chunk = substr( $c, $i, 900 );
	echo "=== $h ===\n" . trim( wp_strip_all_tags( $chunk ) ) . "\n\n";
}
