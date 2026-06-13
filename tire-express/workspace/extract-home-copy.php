<?php
// Extract human copy + shortcodes from the old Divi home page (7).
$c = get_post( 7 )->post_content;
// shortcodes (reviews widget etc.)
preg_match_all( '/\[[a-zA-Z0-9_-]+[^\]]*\]/', $c, $sc );
echo "SHORTCODES: " . implode( ' | ', array_unique( $sc[0] ) ) . "\n\n";
$out = array();
preg_match_all( '/"value":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
foreach ( $m[1] as $v ) {
	$v = json_decode( '"' . $v . '"' );
	if ( ! is_string( $v ) ) { continue; }
	$t = trim( wp_strip_all_tags( $v ) );
	if ( strlen( $t ) > 20 && ! preg_match( '/^(http|#|\d|rgba|var\(|[A-Za-z-]+:)/', $t ) && false === strpos( $t, '{' ) ) {
		$out[ md5( $t ) ] = $t;
	}
}
file_put_contents( 'C:/Users/keith/Desktop/tire-express-workspace/divi-copy-home.txt', implode( "\n\n", $out ) );
echo count( $out ) . " text chunks -> divi-copy-home.txt\n";
