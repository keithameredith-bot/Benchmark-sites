<?php
/**
 * Plugin Name: Tire Express Customizations
 * Description: Redirect map + Service schema for service pages (references AIOSEO's org node by @id — never redefines it).
 *
 * mu-plugin because the site has no child theme; deploys inside wp-content with the site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** 301 redirect map for slugs deliberately changed. Old path (no trailing slash) => new path. */
add_action( 'template_redirect', function () {
	$map = array(
		'/our-testimonial' => '/testimonials/',
	);
	$path = rtrim( (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}
} );

/** page ID => Service definition. areaServed mirrors the AIOSEO Local "area served" list. */
function te_schema_service_map() {
	return array(
		226006 => 'New Tire Sales & Installation',
		227941 => 'Used Tire Sales',
		227942 => 'Tire Repair',
		227950 => 'Tire Installation',
		226003 => 'Tire Balancing & Rotation',
		227943 => 'Wheel Alignment',
		227951 => 'Lifted Truck & Off-Road Tires',
		226005 => 'Oil Change',
		226004 => 'Brake Repair',
		227931 => 'Car & Truck Battery Replacement',
		226007 => 'Engine Tune-Up & Diagnostics',
		226001 => 'Car A/C Repair & Recharge',
		227952 => 'CV Axle Replacement',
		227932 => 'Fleet Vehicle Maintenance',
	);
}

add_action( 'wp_head', function () {
	if ( ! is_page() ) {
		return;
	}
	$id  = get_queried_object_id();
	$map = te_schema_service_map();
	if ( ! isset( $map[ $id ] ) ) {
		return;
	}
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'@id'         => get_permalink( $id ) . '#service',
		'name'        => get_the_title( $id ),
		'serviceType' => $map[ $id ],
		'url'         => get_permalink( $id ),
		'provider'    => array( '@id' => home_url( '/#organization' ) ),
		'areaServed'  => array_map( function ( $a ) {
			return array( '@type' => 'AdministrativeArea', 'name' => $a );
		}, array( 'Ocala FL', 'Silver Springs FL', 'Belleview FL', 'Dunnellon FL', 'Marion County FL' ) ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 20 );

/**
 * Hand-rolled share buttons on single posts — plain intent links, zero third-party JS
 * (same pattern as JSC). Styles ship inline because the site has no child theme.
 */
add_filter( 'the_content', function ( $content ) {
	if ( ! in_the_loop() || ! is_main_query() || ! is_singular( 'post' ) ) {
		return $content;
	}
	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );
	$plain = esc_js( get_permalink() );
	$icons = array(
		'facebook' => array(
			'href'  => "https://www.facebook.com/sharer/sharer.php?u={$url}",
			'label' => 'Facebook',
			'svg'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.5h-2.8V24C19.62 23.1 24 18.1 24 12.07z"/></svg>',
		),
		'x' => array(
			'href'  => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
			'label' => '', // icon-only — "X" text next to the X logo reads as a double-X
			'svg'   => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.41l-5.8-7.58-6.64 7.58H.47l8.6-9.83L0 1.15h7.59l5.24 6.93 6.07-6.93zm-1.29 19.5h2.04L6.49 3.24H4.3l13.31 17.41z"/></svg>',
		),
		'email' => array(
			'href'  => "mailto:?subject={$title}&body={$url}",
			'label' => 'Email',
			'svg'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 6L2 7"></path></svg>',
		),
	);
	$bar = '<style>.te-share{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin:36px 0 8px;padding-top:20px;border-top:1px solid #e6e8ec}.te-share-label{font-weight:800;font-size:14px;color:#16181d;margin-right:4px}.te-share-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;font-size:13.5px;color:#16181d;background:#fff;border:1px solid #e6e8ec;border-radius:99px;padding:8px 16px;text-decoration:none;cursor:pointer;transition:all .15s ease}.te-share-btn:hover{border-color:#1248d7;color:#1248d7;transform:translateY(-1px)}</style>';
	$bar .= '<div class="te-share"><span class="te-share-label">Share this:</span>';
	foreach ( $icons as $key => $i ) {
		$span = $i['label'] ? '<span>' . $i['label'] . '</span>' : '';
		$aria = $i['label'] ? '' : ' aria-label="Share on X"';
		$bar .= '<a class="te-share-btn" href="' . esc_url( $i['href'] ) . '" target="_blank" rel="noopener nofollow"' . $aria . '>' . $i['svg'] . $span . '</a>';
	}
	$bar .= '<button type="button" class="te-share-btn" onclick="navigator.clipboard.writeText(\'' . $plain . '\');this.querySelector(\'span\').textContent=\'Copied!\';"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy Link</span></button>';
	$bar .= '</div>';
	return $content . $bar;
}, 0 );
