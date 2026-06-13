<?php
/**
 * Plugin Name: FGS Head Meta
 * Description: Adds theme-color meta for browser UI / iMessage link-preview tinting.
 */

add_action( 'wp_head', function () {
	echo '<meta name="theme-color" content="#a91513">' . "\n";
}, 1 );
