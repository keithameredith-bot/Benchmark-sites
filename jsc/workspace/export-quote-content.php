<?php
// Dump the quote page's raw post_content for the REST push-live step.
$p = get_page_by_path( 'get-a-free-quote', OBJECT, 'page' );
file_put_contents( 'C:/Users/keith/Desktop/jsc-kadence-mockup/quote-content.txt', $p->post_content );
echo strlen( $p->post_content ) . " bytes exported\n";
