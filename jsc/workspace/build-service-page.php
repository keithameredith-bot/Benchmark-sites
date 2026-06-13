<?php
/**
 * Generic JSC service-page builder (Kadence template per approved barndominium mockup).
 * Usage: wp eval-file build-service-page.php specs/<slug>.php
 * Spec file returns an array — see specs/ for the shape.
 * Idempotent: re-run after editing a spec.
 */

if ( empty( $args[0] ) ) {
	echo "usage: wp eval-file build-service-page.php <spec-file>\n";
	exit( 1 );
}
$spec_path = $args[0];
if ( ! file_exists( $spec_path ) ) {
	$spec_path = 'C:/Users/keith/Desktop/jsc-kadence-mockup/' . $args[0];
}
$spec = include $spec_path;
if ( ! is_array( $spec ) || empty( $spec['page_id'] ) ) {
	echo "ABORT: bad spec\n";
	exit( 1 );
}

function jsc_att_id_by_url( $url ) {
	global $wpdb;
	$f = basename( parse_url( $url, PHP_URL_PATH ) );
	return (int) $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $f ) );
}

function jsc_img_block( $url, $alt ) {
	$id  = jsc_att_id_by_url( $url );
	$cls = $id ? ' wp-image-' . $id : '';
	return '<!-- wp:image {"id":' . ( $id ? $id : 'null' ) . ',"sizeSlug":"full","className":"jsc-side-img"} -->' . "\n"
		. '<figure class="wp-block-image size-full jsc-side-img"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" class="' . trim( 'wp-image-' . $id ) . '"/></figure>' . "\n"
		. '<!-- /wp:image -->';
}

function jsc_button_block() {
	return '<!-- wp:buttons -->' . "\n" . '<div class="wp-block-buttons"><!-- wp:button -->' . "\n"
		. '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/get-a-free-quote/">GET A FREE QUOTE</a></div>' . "\n"
		. '<!-- /wp:button --></div>' . "\n" . '<!-- /wp:buttons -->';
}

$c = array();

// ---------- HERO ----------
$c[] = '<!-- wp:html -->
<div class="jsc-hero">
<div class="jsc-hero-bg" style="background-image:url(\'' . $spec['hero_bg'] . '\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Services</span>
<h1>' . $spec['h1'] . '</h1>
<p class="jsc-sub">' . $spec['sub'] . '</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
<a class="jsc-btn jsc-btn-ghost" href="tel:3526872030">CALL 352.687.2030</a>
</div>
<div class="jsc-trust">
[bwd_stars]
<span><b>✓</b> 25+ Years Experience</span>
<span><b>✓</b> FL Certified Residential Contractor <b>CRC1332267</b></span>
<span><b>✓</b> We Build Statewide</span>
</div>
</div>
</div>
<!-- /wp:html -->';

// ---------- SECTIONS ----------
$first = true;
foreach ( $spec['sections'] as $s ) {
	$warm  = ! empty( $s['warm'] ) ? ' jsc-warm' : '';
	$inner = '';

	if ( $first ) {
		$inner .= '<!-- wp:paragraph {"className":"jsc-kicker"} -->' . "\n" . '<p class="jsc-kicker">Service</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n\n";
	}

	if ( empty( $s['type'] ) || 'full' === $s['type'] ) {
		$inner .= '<!-- wp:html -->' . "\n" . $s['html'] . "\n" . '<!-- /wp:html -->';
		if ( $first && ! empty( $spec['gallery'] ) ) {
			$imgs = array();
			$ids  = array();
			$has_captions = false;
			foreach ( $spec['gallery'] as $g ) {
				$id    = jsc_att_id_by_url( $g['url'] );
				$ids[] = $id;
				$item  = array( 'id' => $id, 'url' => $g['url'], 'alt' => $g['alt'] );
				if ( ! empty( $g['caption'] ) ) {
					$item['caption'] = $g['caption'];
					$has_captions = true;
				}
				$imgs[] = $item;
			}
			$cols = count( $imgs ) <= 2 ? array( 2, 2, 2, 2, 1, 1 ) : ( count( $imgs ) === 4 ? array( 2, 2, 2, 2, 2, 2 ) : array( 3, 3, 3, 2, 2, 2 ) );
			$gallery_attrs = array(
				'uniqueID'      => $spec['page_id'] . '_grid01',
				'kbVersion'     => 2,
				'type'          => 'grid',
				'imageRatio'    => 'land43',
				'columns'       => $cols,
				'gutter'        => array( 14, 14, 10 ),
				'showCaption'   => $has_captions,
				'captionStyle'  => 'bottom',
				'linkTo'        => 'none',
				'lazyLoad'      => true,
				'className'     => 'jsc-photo-grid',
				'ids'           => $ids,
				'imagesDynamic' => $imgs,
			);
			$inner .= "\n\n" . '<!-- wp:kadence/advancedgallery ' . wp_json_encode( $gallery_attrs ) . ' /-->';
			$glink  = ! empty( $spec['gallery_link'] ) ? ' <a href="' . $spec['gallery_link']['url'] . '">' . $spec['gallery_link']['text'] . '</a>' : '';
			$inner .= "\n\n" . '<!-- wp:paragraph {"className":"jsc-real-jobs-note"} -->' . "\n"
				. '<p class="jsc-real-jobs-note"><span class="jsc-tag">REAL JOBS ONLY</span> Every photo on this page is a real JSC job — no stock photos.' . $glink . '</p>' . "\n"
				. '<!-- /wp:paragraph -->';
		}
		if ( ! empty( $s['button'] ) ) {
			$inner .= "\n\n" . jsc_button_block();
		}
	} else {
		// two-col: copy + stacked side images.
		$flip     = ( 'twocol-flip' === $s['type'] );
		$copy_col = '<!-- wp:column {"width":"55%","className":"jsc-copy-col"} -->' . "\n"
			. '<div class="wp-block-column jsc-copy-col" style="flex-basis:55%"><!-- wp:html -->' . "\n"
			. $s['html'] . "\n" . '<!-- /wp:html -->'
			. ( ! empty( $s['button'] ) ? "\n\n" . jsc_button_block() : '' )
			. '</div>' . "\n" . '<!-- /wp:column -->';
		$img_html = '';
		foreach ( (array) ( $s['images'] ?? array() ) as $im ) {
			$img_html .= jsc_img_block( $im['url'], $im['alt'] ) . "\n\n";
		}
		$side_col = '<!-- wp:column {"width":"45%","className":"jsc-side-col"} -->' . "\n"
			. '<div class="wp-block-column jsc-side-col" style="flex-basis:45%">' . trim( $img_html ) . '</div>' . "\n" . '<!-- /wp:column -->';
		$cols_inner = $flip ? $side_col . "\n\n" . $copy_col : $copy_col . "\n\n" . $side_col;
		$inner .= '<!-- wp:columns {"className":"jsc-two-col"} -->' . "\n"
			. '<div class="wp-block-columns jsc-two-col">' . $cols_inner . '</div>' . "\n" . '<!-- /wp:columns -->';
	}

	$c[] = '<!-- wp:group {"tagName":"section","className":"jsc-section' . $warm . '"} -->
<section class="wp-block-group jsc-section' . $warm . '"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap">' . $inner . '</div>
<!-- /wp:group --></section>
<!-- /wp:group -->';
	$first = false;
}

// ---------- CTA BAND ----------
$c[] = '<!-- wp:html -->
<div class="jsc-cta-band" id="appt">
<h2>Get Your Free Quote Today!</h2>
<p>Call <a class="jsc-tel" href="tel:3526872030">352.687.2030</a> or send us your project details online — we\'ll review your ' . $spec['cta_noun'] . ' and get you a free price quote.</p>
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<!-- /wp:html -->';

$content = implode( "\n\n", $c );

// ---------- APPLY ----------
$r = wp_update_post( array( 'ID' => $spec['page_id'], 'post_content' => $content ), true );
if ( is_wp_error( $r ) ) {
	echo 'ERROR: ' . $r->get_error_message() . "\n";
	exit( 1 );
}
update_post_meta( $spec['page_id'], '_kad_post_title', 'hide' );
update_post_meta( $spec['page_id'], '_kad_post_layout', 'fullwidth' );
update_post_meta( $spec['page_id'], '_kad_post_content_style', 'unboxed' );
update_post_meta( $spec['page_id'], '_kad_post_vertical_padding', 'hide' );

// Optional attachment alt fixes.
foreach ( (array) ( $spec['alt_fixes'] ?? array() ) as $url => $alt ) {
	$id = jsc_att_id_by_url( $url );
	if ( $id ) {
		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	}
}

// Optional AIOSEO description.
if ( ! empty( $spec['aioseo_description'] ) ) {
	global $wpdb;
	$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'description' => $spec['aioseo_description'] ), array( 'post_id' => $spec['page_id'] ) );
	echo "aioseo description set\n";
}

echo 'OK page ' . $spec['page_id'] . ' (' . get_post_field( 'post_name', $spec['page_id'] ) . ") rebuilt\n";
