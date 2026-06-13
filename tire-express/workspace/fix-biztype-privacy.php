<?php
// 1. businessType LocalBusiness -> TireShop (matches GBP identity + the 165k/mo market)
$raw = get_option( 'aioseo_options_pro' );
$o   = json_decode( $raw );
if ( isset( $o->localBusiness->locations->business ) ) {
	$o->localBusiness->locations->business->businessType = 'TireShop';
	update_option( 'aioseo_options_pro', wp_json_encode( $o ) );
	echo "businessType => TireShop\n";
}

// 2. privacy policy: extract legal text from the dead Divi content, rebuild clean with H1
$p = get_page_by_path( 'privacy-policy' );
$c = $p->post_content;
if ( false !== strpos( $c, 'wp:divi' ) ) {
	$out = array();
	preg_match_all( '/"(?:value|text|title|content)":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
	foreach ( $m[1] as $v ) {
		$v = json_decode( '"' . $v . '"' );
		if ( ! is_string( $v ) ) { continue; }
		$plain = trim( wp_strip_all_tags( $v ) );
		if ( strlen( $plain ) > 40 && false === strpos( $v, '{' ) && ! preg_match( '/^(http|#|\d+px|rgba|var\()/', $plain ) ) {
			$out[ md5( $v ) ] = trim( $v );
		}
	}
	$html = "<!-- wp:html -->\n<h1>Privacy Policy</h1>\n" . implode( "\n", $out ) . "\n<!-- /wp:html -->";
	$html = str_replace( array( 'http://tire-express.local', 'https://www.tireexpressandservice.com' ), '', $html );
	wp_update_post( array( 'ID' => $p->ID, 'post_content' => wp_slash( $html ) ) );
	echo "privacy rebuilt: " . strlen( $html ) . "B from " . count( $out ) . " chunks\n";
} else {
	echo "privacy already clean (" . strlen( $c ) . "B)\n";
}
