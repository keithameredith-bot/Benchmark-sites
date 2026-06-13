<?php
// Mark Sat/Sun closed in AIOSEO Local opening hours (site copy: weekends by appointment). Idempotent.
$raw = get_option( 'aioseo_options_pro' );
$o   = json_decode( $raw );
$oh  = $o->localBusiness->openingHours ?? null;
if ( ! $oh ) { echo "ABORT: openingHours not found\n"; exit; }
echo "openingHours keys: " . implode( ', ', array_keys( (array) $oh ) ) . "\n";
echo "BEFORE: " . wp_json_encode( $oh ) . "\n";
foreach ( array( 'saturday', 'sunday' ) as $day ) {
	if ( isset( $oh->days->$day ) ) {
		$oh->days->$day->closed = true;
	}
}
update_option( 'aioseo_options_pro', wp_json_encode( $o ) );
echo "AFTER: " . wp_json_encode( $oh->days->saturday ?? null ) . " / " . wp_json_encode( $oh->days->sunday ?? null ) . "\n";
