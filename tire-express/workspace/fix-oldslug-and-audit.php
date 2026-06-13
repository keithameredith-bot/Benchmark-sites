<?php
// 1. old-slug redirect for the testimonials rename
update_post_meta( 226144, '_wp_old_slug', 'our-testimonial' );
echo "old slug meta set: " . implode( ',', get_post_meta( 226144, '_wp_old_slug' ) ) . "\n\n";

// 2. which core pages still hold Divi content (renders blank on Kadence)?
foreach ( array( 7 => 'home', 226138 => 'about-us', 18 => 'contact-us', 15 => 'services', 858 => 'our-faqs', 711 => 'our-team', 226144 => 'testimonials', 226141 => 'blogs', 533 => 'our-gallery', 226005 => 'oil-change(ref)' ) as $id => $label ) {
	$p = get_post( $id );
	if ( ! $p ) { echo "$label: MISSING\n"; continue; }
	$c = $p->post_content;
	$divi = ( false !== strpos( $c, 'wp:divi/' ) ) ? 'DIVI-BLOCKS' : ( ( false !== strpos( $c, '[et_pb_' ) ) ? 'DIVI-SHORTCODES' : 'ok' );
	printf( "%-18s %-7d len=%-8d %s\n", $label, $id, strlen( $c ), $divi );
}
