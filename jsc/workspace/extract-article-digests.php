<?php
/**
 * Extract clean article digests from the revisions that hold the REAL blog article copy
 * (the Divi "All Posts Body Layout" was overwritten per post — live serves one article on all posts).
 * Run: wp eval-file extract-article-digests.php
 */

$targets = array(
	102019 => 'lake-george',     // → post 102014
	101898 => 'fence-2026',      // → post 101890
	101884 => 'barndo-cost',     // → post 101875
	101849 => 'seawall-checklist', // → post 101827
	101408 => 'dock-near-me',    // → post 101393 (own revision)
);

$outdir = 'C:/Users/keith/Desktop/jsc-kadence-mockup/digests';

function jsc_walk_blocks2( $blocks, &$out ) {
	foreach ( $blocks as $b ) {
		$attrs = isset( $b['attrs'] ) && is_array( $b['attrs'] ) ? $b['attrs'] : array();
		$html = $attrs['content']['innerContent']['desktop']['value'] ?? '';
		if ( $html && is_string( $html ) ) {
			$out[] = 'TEXT: ' . preg_replace( '/\s+/', ' ', $html );
		}
		// divi code modules hold raw html
		if ( 'divi/code' === $b['blockName'] ) {
			$code = $attrs['code']['innerContent']['desktop']['value'] ?? '';
			if ( $code ) { $out[] = 'CODE: ' . preg_replace( '/\s+/', ' ', $code ); }
		}
		$src = $attrs['image']['innerContent']['desktop']['value']['src'] ?? '';
		if ( $src ) {
			$alt = '';
			foreach ( ( $attrs['module']['decoration']['attributes']['desktop']['value']['attributes'] ?? array() ) as $a ) {
				if ( ( $a['name'] ?? '' ) === 'alt' ) { $alt = $a['value']; }
			}
			$out[] = 'IMG: ' . $src . ' | alt=' . $alt;
		}
		if ( ! empty( $b['innerBlocks'] ) ) { jsc_walk_blocks2( $b['innerBlocks'], $out ); }
	}
}

global $wpdb;
foreach ( $targets as $rev_id => $name ) {
	$content = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $rev_id ) );
	if ( ! $content ) { echo "MISSING rev $rev_id\n"; continue; }
	$out = array( "== revision $rev_id ($name) ==" );
	jsc_walk_blocks2( parse_blocks( $content ), $out );
	file_put_contents( "$outdir/blog-$name.digest.txt", implode( "\n\n", $out ) );
	echo "$name: " . count( $out ) . " items, " . strlen( $content ) . "b raw\n";
}
