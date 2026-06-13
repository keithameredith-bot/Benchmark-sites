<?php
// Extract ordered HTML content from the 3 Divi blog posts for reassembly.
foreach ( array( 227830 => 'post-heat', 227099 => 'post-ac', 227048 => 'post-rotation' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	$out = array();
	preg_match_all( '/"(?:value|text|title|content)":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
	foreach ( $m[1] as $v ) {
		$v = json_decode( '"' . $v . '"' );
		if ( ! is_string( $v ) ) { continue; }
		$plain = trim( wp_strip_all_tags( $v ) );
		if ( strlen( $plain ) > 8 && ! preg_match( '/^(http|#|\d+px|rgba|var\(|[a-z-]+:[^\/])/', $plain ) && false === strpos( $v, '{' ) ) {
			$out[] = trim( $v ); // keep HTML, keep order, allow duplicates (order matters)
		}
	}
	file_put_contents( "C:/Users/keith/Desktop/tire-express-workspace/divi-$label.txt", implode( "\n\n-----\n\n", $out ) );
	echo "$label: " . count( $out ) . " ordered chunks\n";
}
