<?php
// Extract copy from the 7 remaining Divi pages + blog/posts state.
foreach ( array( 226138 => 'about', 15 => 'services', 858 => 'faqs', 711 => 'team', 226144 => 'testimonials', 226141 => 'blogs', 533 => 'gallery' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	$out = array();
	preg_match_all( '/"value":"((?:[^"\\\\]|\\\\.)*)"/', $c, $m );
	foreach ( $m[1] as $v ) {
		$v = json_decode( '"' . $v . '"' );
		if ( is_string( $v ) ) {
			$t = trim( wp_strip_all_tags( $v ) );
			if ( strlen( $t ) > 12 && ! preg_match( '/^(http|#|\d+px|rgba|var\(|[a-z-]+:)/', $t ) && false === strpos( $t, '{' ) ) { $out[ md5( $t ) ] = $t; }
		}
	}
	// also collect image URLs referenced (for team/gallery)
	preg_match_all( '/https?:\\\\\/\\\\\/[^"]+\.(?:jpg|jpeg|png|webp)/', $c, $imgs );
	$img_list = array_slice( array_unique( array_map( function ( $u ) { return basename( str_replace( '\\/', '/', $u ) ); }, $imgs[0] ) ), 0, 20 );
	file_put_contents( "C:/Users/keith/Desktop/tire-express-workspace/divi-copy-$label.txt", implode( "\n\n", $out ) . "\n\n=== IMAGES ===\n" . implode( "\n", $img_list ) );
	echo "$label: " . count( $out ) . " chunks, " . count( $img_list ) . " imgs\n";
}
echo "--- blog state ---\n";
echo "page_for_posts: " . get_option( 'page_for_posts' ) . "\n";
$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1 ) );
echo "published posts: " . count( $posts ) . "\n";
foreach ( array_slice( $posts, 0, 10 ) as $p ) { echo "  {$p->ID} /{$p->post_name}/ (" . ( false !== strpos( $p->post_content, 'wp:divi' ) ? 'DIVI' : 'ok' ) . ")\n"; }
