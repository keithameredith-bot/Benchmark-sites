<?php
// Set Local SEO business type to GeneralContractor + fill about/contact entity URLs. Idempotent.
$raw = get_option( 'aioseo_options_pro' );
$o   = json_decode( $raw );
$b   = $o->localBusiness->locations->business ?? null;
if ( ! $b ) { echo "ABORT: business object not found\n"; exit; }
$b->businessType      = 'GeneralContractor';
$b->urls->aboutPage   = home_url( '/about-us/' );
$b->urls->contactPage = home_url( '/contact/' );
update_option( 'aioseo_options_pro', wp_json_encode( $o ) );
echo "businessType => {$b->businessType}\naboutPage => {$b->urls->aboutPage}\ncontactPage => {$b->urls->contactPage}\n";
