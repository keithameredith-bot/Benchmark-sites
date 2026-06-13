<?php
foreach ( array( 226471, 226462, 227104, 227892, 227879 ) as $i ) {
	$u = wp_get_attachment_url( $i );
	$f = get_attached_file( $i );
	echo "$i  $u  " . ( $f && file_exists( $f ) ? 'OK' : 'MISSING' ) . "\n";
}
