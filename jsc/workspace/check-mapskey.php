<?php
foreach ( array( 'aioseo_options', 'aioseo_options_pro', 'aioseo_options_local_business' ) as $name ) {
	$raw = get_option( $name );
	if ( ! $raw ) { continue; }
	$s = is_string( $raw ) ? $raw : wp_json_encode( $raw );
	preg_match_all( '/.{20}[Mm]aps?[A-Za-z]*[Kk]ey.{80}/', $s, $m );
	foreach ( $m[0] as $hit ) { echo "$name: ...$hit...\n"; }
}
echo "done\n";
