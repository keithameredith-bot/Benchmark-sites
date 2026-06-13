<?php
/**
 * Extract a clean content digest from each Divi service page so the Kadence
 * rebuilds preserve copy exactly. Outputs digests/<slug>.digest.txt
 * Run: wp eval-file extract-divi-digests.php
 */

$slugs = array( 'home-page-93271',
	'central-florida-dock-builder',
	'boathouse-builder',
	'seawall-construction-and-repair',
	'central-florida-boat-lift-installation',
	'pole-barn-builder',
	'home-remodeling-central-florida',
	'custom-new-construction-builder-in-central-florida',
	'central-florida-fence-builder-2',
);

$outdir = 'C:/Users/keith/Desktop/jsc-kadence-mockup/digests';
if ( ! is_dir( $outdir ) ) {
	mkdir( $outdir, 0777, true );
}

function jsc_walk_blocks( $blocks, &$out ) {
	foreach ( $blocks as $b ) {
		$attrs = isset( $b['attrs'] ) && is_array( $b['attrs'] ) ? $b['attrs'] : array();

		// Section/row background images.
		$bg = $attrs['module']['decoration']['background']['desktop']['value']['image']['url'] ?? '';
		if ( $bg ) {
			$out[] = 'BG: ' . $bg;
		}

		// Text modules.
		$html = $attrs['content']['innerContent']['desktop']['value'] ?? '';
		if ( $html && is_string( $html ) ) {
			$out[] = 'TEXT: ' . preg_replace( '/\s+/', ' ', $html );
		}

		// Image modules (src + alt from attributes list).
		$src = $attrs['image']['innerContent']['desktop']['value']['src'] ?? '';
		if ( $src ) {
			$alt = '';
			$attr_list = $attrs['module']['decoration']['attributes']['desktop']['value']['attributes'] ?? array();
			foreach ( $attr_list as $a ) {
				if ( isset( $a['name'] ) && 'alt' === $a['name'] ) {
					$alt = $a['value'];
				}
			}
			$out[] = 'IMG: ' . $src . ' | alt=' . $alt;
		}

		// Buttons.
		$btn = $attrs['button']['innerContent']['desktop']['value'] ?? null;
		if ( is_array( $btn ) && ! empty( $btn['text'] ) ) {
			$out[] = 'BUTTON: ' . $btn['text'] . ' -> ' . ( $btn['linkUrl'] ?? '' );
		}

		// Galleries (Divi gallery module).
		$gallery_ids = $attrs['module']['advanced']['galleryIds']['desktop']['value'] ?? ( $attrs['gallery']['innerContent']['desktop']['value'] ?? null );
		if ( $gallery_ids ) {
			$out[] = 'GALLERY: ' . ( is_array( $gallery_ids ) ? implode( ',', $gallery_ids ) : $gallery_ids );
		}

		if ( ! empty( $b['innerBlocks'] ) ) {
			jsc_walk_blocks( $b['innerBlocks'], $out );
		}
	}
}

global $wpdb;
foreach ( $slugs as $slug ) {
	$post = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! $post ) {
		echo "MISSING: $slug\n";
		continue;
	}
	$out = array();
	$out[] = '== ' . $slug . ' (ID ' . $post->ID . ') ==';
	$out[] = 'POST_TITLE: ' . $post->post_title;

	$seo = $wpdb->get_row( $wpdb->prepare( "SELECT title, description FROM {$wpdb->prefix}aioseo_posts WHERE post_id = %d", $post->ID ) );
	$out[] = 'AIOSEO_TITLE: ' . ( $seo->title ?? '(default)' );
	$out[] = 'AIOSEO_DESC: ' . ( $seo->description ?? '(none)' );
	$out[] = '';

	jsc_walk_blocks( parse_blocks( $post->post_content ), $out );

	file_put_contents( $outdir . '/' . $slug . '.digest.txt', implode( "\n\n", $out ) );
	echo "$slug: " . count( $out ) . " items\n";
}
echo "DONE\n";
