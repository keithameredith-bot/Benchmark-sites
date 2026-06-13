<?php
$o = json_decode( get_option( 'aioseo_options_pro' ) );
$lb = $o->localBusiness ?? null;
if ( ! $lb ) { echo "no localBusiness key; keys: " . implode( ', ', array_keys( (array) $o ) ) . "\n"; exit; }
echo "localBusiness keys: " . implode( ', ', array_keys( (array) $lb ) ) . "\n";
if ( isset( $lb->locations->business ) ) {
	echo wp_json_encode( $lb->locations->business, JSON_PRETTY_PRINT ) . "\n";
} else {
	echo wp_json_encode( $lb, JSON_PRETTY_PRINT ) . "\n";
}
