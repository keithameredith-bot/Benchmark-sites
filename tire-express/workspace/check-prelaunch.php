<?php
// 1. privacy page state
$p = get_page_by_path( 'privacy-policy' );
echo "PRIVACY: id={$p->ID} len=" . strlen( $p->post_content ) . " has_h1=" . ( stripos( $p->post_content, '<h1' ) !== false ? 'yes' : 'NO' ) . " divi=" . ( strpos( $p->post_content, 'wp:divi' ) !== false ? 'YES' : 'no' ) . "\n";
echo "  first 200: " . substr( wp_strip_all_tags( $p->post_content ), 0, 200 ) . "\n";
// 2. AIOSEO local business settings
$o = json_decode( get_option( 'aioseo_options_pro' ) );
$b = $o->localBusiness->locations->business ?? null;
echo "LOCAL BIZ: " . ( $b ? wp_json_encode( array( 'type' => $b->businessType, 'name' => $b->name, 'addr' => $b->address->streetLine1 ?? '', 'phone' => $b->contact->phone ?? '', 'area' => $b->areaServed ?? '' ) ) : 'NOT SET' ) . "\n";
$oh = $o->localBusiness->openingHours->days ?? null;
echo "HOURS: " . ( $oh ? wp_json_encode( array( 'mon' => $oh->monday, 'sat' => $oh->saturday ) ) : 'NOT SET' ) . "\n";
