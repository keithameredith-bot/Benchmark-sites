<?php
$o = get_option( 'perfmatters_options' );
echo wp_json_encode( array(
	'delay_js'   => $o['assets']['delay_js'] ?? '',
	'behavior'   => $o['assets']['delay_js_behavior'] ?? '',
	'exclusions' => $o['assets']['delay_js_exclusions'] ?? array(),
	'rucss'      => $o['assets']['remove_unused_css'] ?? '',
	'localfonts' => $o['fonts']['local_google_fonts'] ?? '',
	'preloads'   => count( $o['preload']['preload'] ?? array() ),
	'lazy'       => $o['lazyload']['lazy_loading'] ?? '',
	'defer'      => $o['assets']['defer_js'] ?? '',
) );
