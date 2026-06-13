<?php
/**
 * fgs-28-media-gallery.php — Client photo drop (Keith 2026-06-12):
 * 1. Import curated photos (bland/redundant ones excluded per Keith) into the media library
 *    with filename-derived alt text. Skips files already imported.
 * 2. Rebuild the Gallery page (99) in the JSC gallery style: torn maroon hero (via template CSS),
 *    "REAL JOBS ONLY" note, Kadence advancedgallery lightbox grid, free-quote CTA.
 * 3. Fill hero-banner placeholder slots on 10 pages + 4 services-list hover slots with
 *    MATCHED photos, with crop CSS so banners are uniformly sized (Keith's earlier objection).
 * Idempotent. Usage: wp eval-file fgs-28-media-gallery.php
 */

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$src    = 'C:/Users/keith/OneDrive/openclaw-workspace/pics/clients/FGS/';
$tmpdir = 'C:/Users/keith/Desktop/fgs-workspace/_import/';

// curated set: gallery order tells a story (drama -> work -> lab/brand)
$gallery_files = array(
	'fgs-deep-sinkhole-throat-karst-cavity-florida-geotechnical-evaluation.jpg',
	'fgs-open-sinkhole-throat-residential-yard-florida.jpg',
	'fgs-cat-excavator-deep-sinkhole-excavation-soil-stratigraphy-florida.jpg',
	'fgs-technician-inside-karst-excavation-orange-clay-florida.jpg',
	'fgs-karst-limestone-void-fissure-bedrock-florida-investigation.jpg',
	'fgs-sinkhole-vertical-void-karst-cavity-limestone-florida.jpg',
	'fgs-sinkhole-excavation-orange-clay-subsurface-void-concrete-pipe.jpg',
	'fgs-residential-sinkhole-caution-tape-standing-water-florida.jpg',
	'fgs-sinkhole-remediation-cat-excavator-residential-florida.jpg',
	'fgs-john-deere-skid-steer-geomembrane-liner-sinkhole-remediation-florida.jpg',
	'fgs-bobcat-case-excavator-sinkhole-remediation-residential-florida.jpg',
	'fgs-large-limestone-boulder-excavation-subsurface-obstruction-florida.jpg',
	'fgs-technician-limestone-boulder-scale-subsurface-excavation-florida.jpg',
	'fgs-exploratory-test-pit-karst-soil-stratigraphy-florida.jpg',
	'fgs-mini-excavator-test-pit-geotechnical-site-investigation-florida.jpg',
	'fgs-pile-driving-rig-deep-foundation-residential-florida.jpg',
	'fgs-pile-driver-crew-precast-concrete-piles-florida.jpg',
	'fgs-pile-driving-precast-concrete-coastal-home-florida.jpg',
	'fgs-drilled-pier-caisson-excavation-muck-soil-florida.jpg',
	'fgs-sany-wheel-loader-soil-remediation-action-florida.jpg',
	'fgs-vibratory-roller-structural-fill-compaction-sandy-soil-florida.jpg',
	'fgs-pavement-coring-asphalt-roadway-materials-testing-florida.jpg',
	'fgs-concrete-core-drilling-culvert-team-florida-geotechnical.jpg',
	'fgs-horizontal-core-drilling-precast-culvert-interior-florida.jpg',
	'fgs-concrete-core-drilling-retaining-wall-team-florida.jpg',
	'fgs-concrete-core-drilling-industrial-silos-florida.jpg',
	'fgs-concrete-core-drilling-precast-structure-team-florida.jpg',
	'fgs-concrete-core-drilling-wall-workers-florida-geotechnical-services.jpg',
	'fgs-roadway-materials-testing-crew-truck-compaction-florida.jpg',
	'fgs-company-trucks-concrete-coring-equipment-site-florida.jpg',
	'fgs-company-truck-excavator-site-investigation-florida-geotechnical.jpg',
	'fgs-materials-testing-laboratory-fdot-certified-load-frame-equipment.jpg',
	'fgs-roadside-business-sign-compaction-testing-florida-geotechnical.jpg',
);
// imported but not in the gallery (used in slots only)
$extra_files = array( 'fgs-aerial-earthwork-site-preparation-grading-florida.jpg' );

function fgs28_alt( $file ) {
	$t = preg_replace( '/^fgs-|\.jpg$/', '', $file );
	$t = str_replace( '-', ' ', $t );
	$t = preg_replace( '/\bflorida\b/i', 'Florida', ucfirst( $t ) );
	return $t . ' — Florida Geotechnical Services';
}

function fgs28_find( $file ) {
	global $wpdb;
	return (int) $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1",
		'%/' . $wpdb->esc_like( $file )
	) );
}

$id_map = array();
foreach ( array_merge( $gallery_files, $extra_files ) as $file ) {
	$existing = fgs28_find( $file );
	if ( $existing ) {
		$id_map[ $file ] = $existing;
		continue;
	}
	$path = file_exists( $tmpdir . $file ) ? $tmpdir . $file : $src . $file;
	if ( ! file_exists( $path ) ) {
		WP_CLI::warning( "missing source: {$file}" );
		continue;
	}
	$tmp = wp_tempnam( $file );
	copy( $path, $tmp );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0 );
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "{$file}: " . $id->get_error_message() );
		continue;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', fgs28_alt( $file ) );
	$id_map[ $file ] = $id;
	WP_CLI::log( "imported {$file} (ID {$id})" );
}
WP_CLI::log( 'media ready: ' . count( $id_map ) . ' attachments.' );

// ---------- 2. Gallery page (99) ----------
$imgs = array();
$ids  = array();
foreach ( $gallery_files as $file ) {
	if ( empty( $id_map[ $file ] ) ) {
		continue;
	}
	$id   = $id_map[ $file ];
	$full = wp_get_attachment_url( $id );
	$ml   = wp_get_attachment_image_src( $id, 'medium_large' );
	$ids[]  = $id;
	$imgs[] = array(
		'id'       => $id,
		'url'      => str_replace( home_url(), '', $ml ? $ml[0] : $full ),
		'lightUrl' => str_replace( home_url(), '', $full ),
		'alt'      => get_post_meta( $id, '_wp_attachment_image_alt', true ),
	);
}
$gallery_attrs = array(
	'uniqueID'      => '99_gal01',
	'kbVersion'     => 2,
	'type'          => 'grid',
	'imageRatio'    => 'land43',
	'columns'       => array( 3, 3, 3, 2, 2, 2 ),
	'gutter'        => array( 14, 14, 10 ),
	'showCaption'   => false,
	'linkTo'        => 'media',
	'lightbox'      => 'magnific',
	'lazyLoad'      => true,
	'className'     => 'fgs-photo-grid',
	'ids'           => $ids,
	'imagesDynamic' => $imgs,
);

$content = '<!-- wp:kadence/rowlayout {"uniqueID":"99_hero-r1","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_galhero_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_galhero_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">OUR WORK SPEAKS FOR ITSELF</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">Project Gallery</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">Sinkhole excavations, drilling, coring, compaction, and the lab — field photos from real FGS projects across Florida.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"99_grid-r2","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[40,"",40,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_galgrid_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_galgrid_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:paragraph {"align":"center","className":"fgs-real-jobs-note","style":{"color":{"text":"#676767"},"typography":{"fontSize":"15px"}}} -->
<p class="has-text-align-center fgs-real-jobs-note has-text-color" style="color:#676767;font-size:15px"><strong style="color:#a91513">REAL JOBS ONLY</strong> &nbsp;Every photo is a real FGS project — no stock photos, no AI images.</p>
<!-- /wp:paragraph -->

<!-- wp:kadence/advancedgallery ' . wp_json_encode( $gallery_attrs ) . ' /--></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"99_cta-r3","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[16,"",64,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_galcta_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_galcta_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"className":"fgs-cta","style":{"color":{"background":"#ffffff"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"56px","right":"48px","bottom":"56px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group fgs-cta has-background" style="border-radius:24px;background-color:#ffffff;padding-top:56px;padding-right:48px;padding-bottom:56px;padding-left:48px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"34px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"16px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;margin-top:0;margin-bottom:16px;font-size:34px;font-weight:800">Your Site Could Be Next</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#adadad"},"typography":{"fontSize":"17px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#adadad;font-size:17px;line-height:1.6">Tell us what you\'re building and where — an engineer reviews every request.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:28px"><!-- wp:button {"style":{"color":{"background":"#a91513","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="/free-quote/" style="border-radius:8px;color:#ffffff;background-color:#a91513;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Get a Free Quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->';

$r = wp_update_post( array( 'ID' => 99, 'post_content' => wp_slash( $content ) ), true );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'gallery page: ' . $r->get_error_message() );
}
WP_CLI::log( 'Gallery page rebuilt with ' . count( $imgs ) . ' photos.' );

// ---------- 3. banner slot fills ----------
$banners = array(
	90  => 'fgs-company-trucks-concrete-coring-equipment-site-florida.jpg',
	92  => 'fgs-technician-inside-karst-excavation-orange-clay-florida.jpg',
	167 => 'fgs-deep-sinkhole-throat-karst-cavity-florida-geotechnical-evaluation.jpg',
	205 => 'fgs-mini-excavator-test-pit-geotechnical-site-investigation-florida.jpg',
	216 => 'fgs-materials-testing-laboratory-fdot-certified-load-frame-equipment.jpg',
	202 => 'fgs-roadway-materials-testing-crew-truck-compaction-florida.jpg',
	225 => 'fgs-pavement-coring-asphalt-roadway-materials-testing-florida.jpg',
	230 => 'fgs-concrete-core-drilling-culvert-team-florida-geotechnical.jpg',
	269 => 'fgs-pile-driving-rig-deep-foundation-residential-florida.jpg',
	223 => 'fgs-exploratory-test-pit-karst-soil-stratigraphy-florida.jpg',
);
foreach ( $banners as $pid => $file ) {
	if ( empty( $id_map[ $file ] ) ) {
		continue;
	}
	$url = str_replace( home_url(), '', wp_get_attachment_url( $id_map[ $file ] ) );
	$alt = fgs28_alt( $file );
	$p   = get_post( $pid );
	$new = preg_replace(
		'#<img src="https://placehold\.co/1200x500/[^"]*"([^>]*) alt="[^"]*"([^>]*)/?>#',
		'<img src="' . $url . '"$1 alt="' . esc_attr( $alt ) . '"$2/>',
		$p->post_content, 1, $n
	);
	if ( $n ) {
		wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $new ) ), true );
		WP_CLI::log( "banner {$pid}: {$file}" );
	} else {
		WP_CLI::log( "banner {$pid}: no placeholder (already real?)." );
	}
}

// services-list hover slots on home
$slots = array(
	'/geotechnical-engineering-services-florida/' => 'fgs-aerial-earthwork-site-preparation-grading-florida.jpg',
	'/soil-testing-laboratory-services-florida/'  => 'fgs-materials-testing-laboratory-fdot-certified-load-frame-equipment.jpg',
	'/pavement-design-evaluation-florida/'        => 'fgs-pavement-coring-asphalt-roadway-materials-testing-florida.jpg',
	'/environmental-site-assessment-florida/'     => 'fgs-exploratory-test-pit-karst-soil-stratigraphy-florida.jpg',
);
$home = get_post( 90 )->post_content;
$hn   = 0;
foreach ( $slots as $href => $file ) {
	if ( empty( $id_map[ $file ] ) ) {
		continue;
	}
	$url  = str_replace( home_url(), '', wp_get_attachment_url( $id_map[ $file ] ) );
	$home = preg_replace(
		'#(<a class="fgs-svc" href="' . preg_quote( $href, '#' ) . '">.*?<img src=")https://placehold\.co/[^"]+(")#s',
		'$1' . $url . '$2',
		$home, 1, $c
	);
	$hn += $c;
}
if ( $hn ) {
	wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $home ) ), true );
	WP_CLI::log( "services-list slots filled: {$hn}" );
}

// ---------- 4. banner crop CSS ----------
$ms  = '/* fgs-media:start */';
$me  = '/* fgs-media:end */';
$new = <<<'CSS'
/* hero/banner figures crop to a uniform 12:5 band */
figure.wp-block-image.size-large.has-custom-border img{
  width:100%;aspect-ratio:12/5;object-fit:cover;height:auto;display:block;
}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'banner crop CSS written.' );

WP_CLI::success( 'Media import + gallery + slot fills complete.' );
