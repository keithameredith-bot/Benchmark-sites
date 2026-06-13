<?php
// Extract human copy from the 4 old Divi pages (text/heading values inside divi block JSON + shortcode content).
foreach ( array( 226001 => 'ac', 226004 => 'brakes', 226007 => 'tuneup', 226003 => 'balance' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	$out = array();
	// divi 5 block JSON: "content":{"desktop":{"value":"..."}}  and heading "text" values
	preg_match_all( '/"value":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
	foreach ( $m[1] as $v ) {
		$v = json_decode( '"' . $v . '"' );
		if ( ! is_string( $v ) ) { continue; }
		$t = trim( wp_strip_all_tags( $v ) );
		// keep only human-looking text
		if ( strlen( $t ) > 25 && ! preg_match( '/^(http|#|\d|rgba|var\()/', $t ) && false === strpos( $t, '{' ) ) {
			$out[ md5( $t ) ] = $t;
		}
	}
	$f = 'C:/Users/keith/Desktop/tire-express-workspace/divi-copy-' . $label . '.txt';
	file_put_contents( $f, implode( "\n\n", $out ) );
	echo "$label: " . count( $out ) . " text chunks -> $f\n";
}
