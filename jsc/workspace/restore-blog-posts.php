<?php
/**
 * BLOG CONTENT RECOVERY — the live site has every blog post rendering the SAME article
 * because each article was pasted into the Divi "All Posts Body Layout" (91300), overwriting
 * the previous one. The real copy survives in that layout's revisions. This script writes each
 * article into ITS OWN post_content (clean wp:html block) so posts are self-contained.
 *
 * Cleanups per article:
 *  - in-content <h1> removed (Kadence renders the post title as the H1; baseline H1s = post titles)
 *  - leading hero <figure> removed (Kadence shows the featured image; all posts have one)
 *  - http://jsc.local links → relative; /meet-the-team → /our-team/; bare /services|/contact → trailing slash
 *  - Article JSON-LD dropped (AIOSEO emits Article schema — duplicate); FAQPage JSON-LD KEPT
 * Run: wp eval-file restore-blog-posts.php
 */

$map = array(
	101875 => 101884, // barndominium-cost-central-florida-2026
	101890 => 101898, // fence-installation-in-central-florida-2026
	101827 => 101849, // seawall checklist
	102014 => 102019, // lake george
);

function jsc_collect_html( $blocks, &$buf ) {
	foreach ( $blocks as $b ) {
		$attrs = isset( $b['attrs'] ) && is_array( $b['attrs'] ) ? $b['attrs'] : array();
		$html  = $attrs['content']['innerContent']['desktop']['value'] ?? '';
		if ( $html && is_string( $html ) ) { $buf .= $html . "\n"; }
		if ( 'divi/code' === $b['blockName'] ) {
			$code = $attrs['code']['innerContent']['desktop']['value'] ?? '';
			if ( $code ) { $buf .= $code . "\n"; }
		}
		if ( ! empty( $b['innerBlocks'] ) ) { jsc_collect_html( $b['innerBlocks'], $buf ); }
	}
}

global $wpdb;
foreach ( $map as $post_id => $rev_id ) {
	$raw = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $rev_id ) );
	if ( ! $raw ) { echo "MISSING rev $rev_id\n"; continue; }
	$html = '';
	jsc_collect_html( parse_blocks( $raw ), $html );
	if ( strlen( $html ) < 5000 ) { echo "SKIP $post_id: extracted only " . strlen( $html ) . "b\n"; continue; }

	// drop in-content H1 (theme provides it from post title)
	$html = preg_replace( '#<h1[^>]*>.*?</h1>#s', '', $html, 1 );
	// drop the leading hero figure (featured image covers it)
	$html = preg_replace( '#<figure[^>]*>\s*<img[^>]*>\s*</figure>#s', '', $html, 1 );
	// drop Article JSON-LD blocks, keep FAQPage
	$html = preg_replace_callback( '#<script type="application/ld\+json">.*?</script>#s', function ( $m ) {
		return ( strpos( $m[0], '"@type": "Article"' ) !== false ) ? '' : $m[0];
	}, $html );
	// link cleanup
	$html = str_replace( array( 'http://jsc.local', 'https://jscfla.com' ), '', $html );
	$html = str_replace( '/meet-the-team', '/our-team/', $html );
	$html = preg_replace( '#href="/(services|contact)"#', 'href="/$1/"', $html );

	$content = "<!-- wp:html -->\n" . trim( $html ) . "\n<!-- /wp:html -->";
	$r = wp_update_post( array( 'ID' => $post_id, 'post_content' => $content ), true );
	echo is_wp_error( $r )
		? "ERR $post_id: " . $r->get_error_message() . "\n"
		: "RESTORED $post_id (" . get_post_field( 'post_name', $post_id ) . "): " . strlen( $content ) . "b\n";
}
