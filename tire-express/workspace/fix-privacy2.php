<?php
// Set privacy policy content from the live-site extraction. Idempotent (guards on length).
$p = get_page_by_path( 'privacy-policy' );
$html = file_get_contents( 'C:/Users/keith/Desktop/tire-express-workspace/privacy-live.html' );
if ( ! $html ) { echo "ABORT: no source\n"; exit; }
$h1 = ( false === stripos( $html, '<h1' ) ) ? "<h1>Privacy Policy</h1>\n" : '';
$content = "<!-- wp:html -->\n" . $h1 . trim( $html ) . "\n<!-- /wp:html -->";
wp_update_post( array( 'ID' => $p->ID, 'post_content' => wp_slash( $content ) ) );
echo "privacy set: " . strlen( $content ) . "B, added-h1=" . ( $h1 ? 'yes' : 'no' ) . "\n";
