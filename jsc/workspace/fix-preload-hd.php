<?php
$o = get_option( 'perfmatters_options' );
foreach ( $o['preload']['preload'] as &$p ) {
	$p['url'] = str_replace( 'montage-mobile.webp', 'montage-mobile-hd.webp', $p['url'] );
}
unset( $p );
update_option( 'perfmatters_options', $o );
foreach ( $o['preload']['preload'] as $p ) { echo "[{$p['device']}] " . basename( $p['url'] ) . "\n"; }
