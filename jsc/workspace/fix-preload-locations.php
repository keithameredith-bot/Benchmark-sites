<?php
// Preloads not rendering with locations set — blank them (BRM-style sitewide) and retest.
$opts = get_option( 'perfmatters_options' );
foreach ( $opts['preload']['preload'] as &$p ) { $p['locations'] = ''; }
unset( $p );
update_option( 'perfmatters_options', $opts );
echo "locations blanked on " . count( $opts['preload']['preload'] ) . " entries\n";
echo wp_json_encode( $opts['preload']['preload'][0] ) . "\n";
