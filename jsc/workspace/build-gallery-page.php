<?php
/**
 * Rebuild the 8 service gallery pages in Kadence (lightbox photo grids).
 * First run extracts images from the page's Divi content into specs/gallery-<slug>.json;
 * later runs read the spec (edit the JSON to curate, then rerun).
 * Run: wp eval-file build-gallery-page.php           (all)
 *      wp eval-file build-gallery-page.php <slug>    (one)
 */

// 'hero' = same image as the matching service page's hero (Keith 2026-06-09); default jsc-short-2.
$cfg = array(
	'barndominium-gallery' => array(
		'hero' => '/wp-content/uploads/2026/06/best-barndominium-builders-in-florida-hero.webp',
		'service' => '/barndominium-builders-in-florida/', 'service_label' => 'our barndominium crew',
		'noun' => 'barndominium project', 'default_alt' => 'Barndominium built by JSC Contracting in Florida',
	),
	'dock-gallery' => array(
		'h1' => 'Dock Gallery', // FIX: live H1 was "Boathouse Gallery" (copy-paste error, baseline issue #1)
		'service' => '/central-florida-dock-builder/', 'service_label' => 'our dock crew',
		'noun' => 'dock project', 'default_alt' => 'Dock built by JSC Contracting in Central Florida',
	),
	'boathouse-gallery' => array(
		'service' => '/boathouse-builder/', 'service_label' => 'our boathouse crew',
		'noun' => 'boathouse project', 'default_alt' => 'Boathouse built by JSC Contracting in Central Florida',
	),
	'seawall-gallery' => array(
		'service' => '/seawall-construction-and-repair/', 'service_label' => 'our seawall crew',
		'noun' => 'seawall project', 'default_alt' => 'Seawall built by JSC Contracting in Central Florida',
	),
	'pole-barn-gallery' => array(
		'hero' => '/wp-content/uploads/2026/01/pole-barn-more.webp',
		'service' => '/pole-barn-builder/', 'service_label' => 'our pole barn crew',
		'noun' => 'pole barn project', 'default_alt' => 'Pole barn built by JSC Contracting in Central Florida',
	),
	'new-fencing-gallery' => array(
		'hero' => '/wp-content/uploads/2026/02/central-florida-fence-builder.webp',
		'service' => '/central-florida-fence-builder/', 'service_label' => 'our fencing crew',
		'noun' => 'fencing project', 'default_alt' => 'Fencing installed by JSC Contracting in Central Florida',
	),
	'new-home-gallery' => array(
		'hero' => '/wp-content/uploads/2026/02/custom-new-construction-home-builder-in-central-florida.webp',
		'service' => '/custom-new-construction-builder-in-central-florida/', 'service_label' => 'our home building crew',
		'noun' => 'new construction project', 'default_alt' => 'New construction home built by JSC Contracting',
	),
	// marine-construction-gallery removed 2026-06-09: consolidated (drafted + 301 → /galleries/)
);

$only = ! empty( $args[0] ) ? $args[0] : null;
$specdir = 'C:/Users/keith/Desktop/jsc-kadence-mockup/specs';

function jsc_gal_extract( $blocks, &$spec ) {
	foreach ( $blocks as $b ) {
		$attrs = isset( $b['attrs'] ) && is_array( $b['attrs'] ) ? $b['attrs'] : array();
		$html = $attrs['content']['innerContent']['desktop']['value'] ?? '';
		if ( $html && is_string( $html ) ) {
			if ( preg_match( '#<h1[^>]*>(.*?)</h1>#s', $html, $m ) && empty( $spec['h1'] ) ) {
				$spec['h1'] = trim( wp_strip_all_tags( $m[1] ) );
			} elseif ( preg_match( '#<p[^>]*>(.*?)</p>#s', $html, $m ) ) {
				$t = trim( wp_strip_all_tags( $m[1] ) );
				$skip = array( 'Get a Free Quote', 'Make an Appointment', 'Our work speaks', 'Services', 'Service' );
				$ok = strlen( $t ) > 15;
				foreach ( $skip as $s ) { if ( stripos( $t, $s ) === 0 ) { $ok = false; } }
				if ( $ok && empty( $spec['intro'] ) ) { $spec['intro'] = $t; }
			}
		}
		$src = $attrs['image']['innerContent']['desktop']['value']['src'] ?? '';
		if ( $src ) {
			$alt = '';
			foreach ( ( $attrs['module']['decoration']['attributes']['desktop']['value']['attributes'] ?? array() ) as $a ) {
				if ( ( $a['name'] ?? '' ) === 'alt' ) { $alt = $a['value']; }
			}
			$spec['images'][] = array( 'url' => str_replace( 'http://jsc.local', '', $src ), 'alt' => $alt );
		}
		if ( ! empty( $b['innerBlocks'] ) ) { jsc_gal_extract( $b['innerBlocks'], $spec ); }
	}
}

function jsc_att_id_by_url2( $url ) {
	global $wpdb;
	$f = basename( parse_url( $url, PHP_URL_PATH ) );
	// strip -scaled / -123x456 suffixes for matching
	$base = preg_replace( '/(-scaled|-\d+x\d+)(?=\.\w+$)/', '', $f );
	$id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $base ) );
	if ( ! $id ) {
		$id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $f ) );
	}
	return $id;
}

foreach ( $cfg as $slug => $c ) {
	if ( $only && $only !== $slug ) { continue; }
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! $page ) { echo "MISSING $slug\n"; continue; }

	$spec_file = "$specdir/gallery-$slug.json";
	if ( file_exists( $spec_file ) ) {
		$spec = json_decode( file_get_contents( $spec_file ), true );
	} else {
		$spec = array( 'h1' => '', 'intro' => '', 'images' => array() );
		jsc_gal_extract( parse_blocks( $page->post_content ), $spec );
		file_put_contents( $spec_file, wp_json_encode( $spec, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );
	}

	$h1    = ! empty( $c['h1'] ) ? $c['h1'] : ( $spec['h1'] ?: $page->post_title );
	$intro = $spec['intro'] ?: 'Real JSC jobs — browse the photos, then get a free quote for yours.';

	// gallery items: grid uses medium_large when available, lightbox opens full size
	$imgs = array(); $ids = array();
	foreach ( $spec['images'] as $im ) {
		$id  = jsc_att_id_by_url2( $im['url'] );
		$alt = $im['alt'] !== '' ? $im['alt'] : $c['default_alt'];
		if ( $id ) {
			if ( $im['alt'] === '' && ! get_post_meta( $id, '_wp_attachment_image_alt', true ) ) {
				update_post_meta( $id, '_wp_attachment_image_alt', $alt );
			}
			$full = wp_get_attachment_url( $id );
			$ml   = wp_get_attachment_image_src( $id, 'medium_large' );
			$grid = $ml ? $ml[0] : $full;
			$item = array(
				'id'  => $id,
				'url' => str_replace( home_url(), '', $grid ),
				'lightUrl' => str_replace( home_url(), '', $full ),
				'alt' => $alt,
			);
		} else {
			$item = array( 'id' => 0, 'url' => $im['url'], 'lightUrl' => $im['url'], 'alt' => $alt );
		}
		$ids[] = $item['id'];
		$imgs[] = $item;
	}

	$gallery_attrs = array(
		'uniqueID'      => $page->ID . '_gal01',
		'kbVersion'     => 2,
		'type'          => 'grid',
		'imageRatio'    => 'land43',
		'columns'       => array( 3, 3, 3, 2, 2, 2 ),
		'gutter'        => array( 14, 14, 10 ),
		'showCaption'   => false,
		'linkTo'        => 'media',
		'lightbox'      => 'magnific',
		'lazyLoad'      => true,
		'className'     => 'jsc-photo-grid',
		'ids'           => $ids,
		'imagesDynamic' => $imgs,
	);

	$hero_bg = ! empty( $c['hero'] ) ? $c['hero'] : '/wp-content/uploads/2025/12/jsc-short-2.webp';
	$content = '<!-- wp:html -->
<div class="jsc-hero">
<div class="jsc-hero-bg" style="background-image:url(\'' . $hero_bg . '\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Our Work Speaks For Itself</span>
<h1>' . esc_html( $h1 ) . '</h1>
<p class="jsc-sub">' . esc_html( $intro ) . '</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
<a class="jsc-btn jsc-btn-ghost" href="tel:3526872030">CALL 352.687.2030</a>
</div>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:paragraph {"className":"jsc-real-jobs-note"} -->
<p class="jsc-real-jobs-note"><span class="jsc-tag">REAL JOBS ONLY</span> Every photo is a real JSC job — no stock photos. Built by <a href="' . $c['service'] . '">' . $c['service_label'] . '</a>.</p>
<!-- /wp:paragraph -->

<!-- wp:kadence/advancedgallery ' . wp_json_encode( $gallery_attrs ) . ' /--></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:html -->
<div class="jsc-cta-band" id="appt">
<h2>Get Your Free Quote Today!</h2>
<p>Call <a class="jsc-tel" href="tel:3526872030">352.687.2030</a> or send us your project details online — we\'ll review your ' . $c['noun'] . ' and get you a free price quote.</p>
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<!-- /wp:html -->';

	$r = wp_update_post( array( 'ID' => $page->ID, 'post_content' => $content ), true );
	if ( is_wp_error( $r ) ) { echo "ERR $slug: " . $r->get_error_message() . "\n"; continue; }
	update_post_meta( $page->ID, '_kad_post_title', 'hide' );
	update_post_meta( $page->ID, '_kad_post_layout', 'fullwidth' );
	update_post_meta( $page->ID, '_kad_post_content_style', 'unboxed' );
	update_post_meta( $page->ID, '_kad_post_vertical_padding', 'hide' );
	echo "OK $slug: " . count( $imgs ) . " images, H1='$h1'\n";
}
