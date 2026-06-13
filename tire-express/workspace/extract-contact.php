<?php
// Contact page (18): shortcodes + copy; also hunt for the Google listing URL (Trustindex options).
$c = get_post( 18 )->post_content;
preg_match_all( '/\[[a-zA-Z0-9_-]+[^\]]*\]/', $c, $sc );
echo "SHORTCODES: " . implode( ' | ', array_unique( $sc[0] ) ) . "\n";
$out = array();
preg_match_all( '/"value":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
foreach ( $m[1] as $v ) {
	$v = json_decode( '"' . $v . '"' );
	if ( is_string( $v ) ) {
		$t = trim( wp_strip_all_tags( $v ) );
		if ( strlen( $t ) > 15 && ! preg_match( '/^(http|#|\d|rgba|var\(|[A-Za-z-]+:)/', $t ) && false === strpos( $t, '{' ) ) { $out[ md5( $t ) ] = $t; }
	}
}
echo "--- COPY ---\n" . implode( "\n\n", $out ) . "\n";
// google maps/place URL anywhere in trustindex or old content
global $wpdb;
$rows = $wpdb->get_results( "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'trustindex%' AND (option_value LIKE '%maps%' OR option_value LIKE '%place%' OR option_value LIKE '%g.page%')" );
foreach ( $rows as $r ) {
	preg_match_all( '/https?:[^"\' ]+/', $r->option_value, $u );
	echo "TI {$r->option_name}: " . implode( ' ', array_slice( array_unique( $u[0] ), 0, 3 ) ) . "\n";
}
preg_match_all( '/https?:\\\\?\/\\\\?\/[^"]*(maps|g\.page)[^"]*/', $c, $mm );
echo "MAPS URLS IN CONTACT: " . implode( "\n", array_slice( array_unique( $mm[0] ), 0, 3 ) ) . "\n";
