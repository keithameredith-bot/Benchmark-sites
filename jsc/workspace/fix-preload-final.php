<?php
// Final preload config: montage pair sitewide (device-split); drop the barndo pair (Perfmatters'
// locations field didn't take our syntax, and a sitewide 75KB extra preload isn't worth it).
$opts = get_option( 'perfmatters_options' );
$opts['preload']['preload'] = array_values( array_filter( $opts['preload']['preload'], function ( $p ) {
	return false === strpos( $p['url'], 'barndo' ) && false === strpos( $p['url'], 'best-barndominium' );
} ) );
update_option( 'perfmatters_options', $opts );
echo "preloads now: " . count( $opts['preload']['preload'] ) . "\n";
foreach ( $opts['preload']['preload'] as $p ) { echo "  [{$p['device']}] " . basename( $p['url'] ) . "\n"; }
