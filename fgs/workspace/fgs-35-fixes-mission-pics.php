<?php
/**
 * fgs-35-fixes-mission-pics.php — Keith 2026-06-12 (round N):
 * 1. Home hero "Get a Quote" kadence singlebtn had NO link -> /free-quote/, bold text.
 * 2. CTA outline-button hover was filling charcoal on maroon panels ("bleeds out") ->
 *    inside dark panels outline buttons now fill WHITE with maroon text.
 * 3. Mission page gets two of the live site's AI images (Keith-approved): sunrise crew
 *    banner after the lede, soil-inspection banner before the CTA.
 * Idempotent. Usage: wp eval-file fgs-35-fixes-mission-pics.php
 */

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// ---------- 1. home hero button ----------
$p = get_post( 90 );
$c = $p->post_content;
if ( false !== strpos( $c, '"uniqueID":"90_394504-63","text":"Get a Quote","link":"/free-quote/"' ) ) {
	WP_CLI::log( 'hero button already linked.' );
} else {
	$c2 = str_replace(
		'"uniqueID":"90_394504-63","text":"Get a Quote","inheritStyles":"inherit"',
		'"uniqueID":"90_394504-63","text":"Get a Quote","link":"/free-quote/","inheritStyles":"inherit"',
		$c, $n
	);
	if ( $n ) {
		wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $c2 ) ), true );
		WP_CLI::log( 'hero Get a Quote button -> /free-quote/.' );
	} else {
		WP_CLI::warning( 'hero singlebtn pattern not found.' );
	}
}

// ---------- 3. mission images ----------
$imgs = array(
	'fgs-mission-crew-sunrise-jobsite.webp'      => array(
		'src' => 'C:/Users/keith/Desktop/fgs-workspace/_la-image-2.0-vNLivs_1IMv6V.webp',
		'alt' => 'FGS field crew walking onto a Florida job site at sunrise',
	),
	'fgs-mission-engineer-soil-inspection.webp' => array(
		'src' => 'C:/Users/keith/Desktop/fgs-workspace/_la-photo.CLms6QbG_Z25px33.webp',
		'alt' => 'Engineer examining a soil sample during a Florida site inspection',
	),
);
global $wpdb;
$urls = array();
foreach ( $imgs as $name => $cfg ) {
	$aid = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $wpdb->esc_like( $name ) ) );
	if ( ! $aid ) {
		$tmp = wp_tempnam( $name );
		copy( $cfg['src'], $tmp );
		$aid = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), 0 );
		if ( is_wp_error( $aid ) ) {
			WP_CLI::error( "{$name}: " . $aid->get_error_message() );
		}
		update_post_meta( $aid, '_wp_attachment_image_alt', $cfg['alt'] );
		WP_CLI::log( "imported {$name} (ID {$aid})" );
	}
	$urls[ $name ] = str_replace( home_url(), '', wp_get_attachment_url( $aid ) );
}

$m  = get_post( 96 );
$mc = $m->post_content;
if ( false === strpos( $mc, 'fgs-mission-crew-sunrise' ) ) {
	$img_row = function ( $uid, $colid, $url, $alt ) {
		return '<!-- wp:kadence/rowlayout {"uniqueID":"' . $uid . '","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[8,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"' . $colid . '","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column' . $colid . ' inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","align":"center","style":{"border":{"radius":"20px"}}} -->
<figure class="wp-block-image aligncenter size-large has-custom-border"><img src="' . $url . '" alt="' . esc_attr( $alt ) . '" style="border-radius:20px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

';
	};
	// after the lede row
	$anchor1 = '<!-- wp:kadence/rowlayout {"uniqueID":"96_drvn-r3"';
	$pos     = strpos( $mc, $anchor1 );
	$mc      = substr( $mc, 0, $pos ) . $img_row( '96_img1-r2b', '_msnimg1_c1', $urls['fgs-mission-crew-sunrise-jobsite.webp'], 'FGS field crew walking onto a Florida job site at sunrise' ) . substr( $mc, $pos );
	// before the CTA row
	$anchor2 = '<!-- wp:kadence/rowlayout {"uniqueID":"96_cta-r5"';
	$pos     = strpos( $mc, $anchor2 );
	$mc      = substr( $mc, 0, $pos ) . $img_row( '96_img2-r4b', '_msnimg2_c1', $urls['fgs-mission-engineer-soil-inspection.webp'], 'Engineer examining a soil sample during a Florida site inspection' ) . substr( $mc, $pos );
	wp_update_post( array( 'ID' => 96, 'post_content' => wp_slash( $mc ) ), true );
	WP_CLI::log( 'mission images inserted.' );
} else {
	WP_CLI::log( 'mission images already present.' );
}

// ---------- 2. CSS: hover fixes + hero button bold ----------
$ms  = '/* fgs-hoverfix:start */';
$me  = '/* fgs-hoverfix:end */';
$new = <<<'CSS'
/* outline buttons inside DARK panels: hover fills white (not charcoal) — no more bleed-out */
.fgs-cta .wp-block-button.is-style-outline .wp-block-button__link:hover,
.wp-block-group.has-background:has(h1) .wp-block-button.is-style-outline .wp-block-button__link:hover{
  background:#ffffff !important;color:#7c0e0d !important;border-color:#ffffff !important;
}
/* kadence advancedbtn (home hero Get a Quote): bold + hover */
.wp-block-kadence-advancedbtn .kb-button{font-weight:800 !important}
.wp-block-kadence-advancedbtn .kb-button:hover{transform:translateY(-2px)}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'hover-fix CSS written.' );

WP_CLI::success( 'Hero button, hover bleed, mission pics — done.' );
