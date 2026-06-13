<?php
/**
 * Kadence Child — JSC Contracting
 * All JSC custom code lives in this child theme (never the parent / plugins).
 */

// Child styles after the parent stylesheet.
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'kadence-child',
		get_stylesheet_uri(),
		array( 'kadence-global' ),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

// Site fonts per approved mockup: Fira Sans (headings) + Nunito Sans (body).
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'jsc-google-fonts',
		'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@600;700;800&family=Nunito+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap',
		array(),
		null
	);
}, 5 );

// Google review badge shortcodes: [bwd_stars] [bwd_rating] [bwd_review_count].
require_once get_stylesheet_directory() . '/bwd-review-shortcodes.php';

// Service + FAQPage schema (references AIOSEO's org node by @id — never redefines it).
require_once get_stylesheet_directory() . '/jsc-schema.php';

/**
 * 301 redirect map for slugs deliberately changed during the Kadence migration.
 * Old path (no trailing slash) => new path.
 */
add_action( 'template_redirect', function () {
	$map = array(
		'/central-florida-fence-builder-2'  => '/central-florida-fence-builder/',
		// "near me" intent consolidated into the dock service page (article body was lost pre-migration)
		'/blog/dock-builder-near-me'        => '/central-florida-dock-builder/',
		// redundant gallery (all photos duplicated in dock/boathouse/seawall galleries)
		'/marine-construction-gallery'      => '/galleries/',
	);
	$path = rtrim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}
} );

/**
 * Serve Alex's real headshot (attachment 100841, alex-400.webp) as his avatar
 * everywhere get_avatar() is used — he has no Gravatar account.
 */
add_filter( 'pre_get_avatar_data', function ( $args, $id_or_email ) {
	$alex = get_user_by( 'login', 'alex' );
	if ( ! $alex ) {
		return $args;
	}
	$user = false;
	if ( is_numeric( $id_or_email ) ) {
		$user = get_user_by( 'id', (int) $id_or_email );
	} elseif ( is_string( $id_or_email ) ) {
		$user = get_user_by( 'email', $id_or_email );
	} elseif ( $id_or_email instanceof WP_User ) {
		$user = $id_or_email;
	} elseif ( $id_or_email instanceof WP_Post ) {
		$user = get_user_by( 'id', (int) $id_or_email->post_author );
	} elseif ( $id_or_email instanceof WP_Comment && $id_or_email->user_id ) {
		$user = get_user_by( 'id', (int) $id_or_email->user_id );
	}
	if ( $user && $user->ID === $alex->ID ) {
		$url = wp_get_attachment_image_url( 100841, array( $args['size'], $args['size'] ) );
		if ( $url ) {
			$args['url']          = $url;
			$args['found_avatar'] = true;
		}
	}
	return $args;
}, 10, 2 );

/**
 * Hand-rolled share buttons on single posts — plain intent links, zero third-party JS
 * (per the performance playbook). Appends before the AIOSEO author bio box.
 */
add_filter( 'the_content', function ( $content ) {
	if ( ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	// posts + the service pages (people share contractor pages); never utility/info pages
	$is_service_page = is_page() && array_key_exists( get_queried_object_id(), jsc_schema_service_map() );
	if ( ! is_singular( 'post' ) && ! $is_service_page ) {
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
			'label' => '', // icon-only — "X" text next to the X logo read as a double-X
			'svg'   => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.41l-5.8-7.58-6.64 7.58H.47l8.6-9.83L0 1.15h7.59l5.24 6.93 6.07-6.93zm-1.29 19.5h2.04L6.49 3.24H4.3l13.31 17.41z"/></svg>',
		),
		'email' => array(
			'href'  => "mailto:?subject={$title}&body={$url}",
			'label' => 'Email',
			'svg'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 6L2 7"></path></svg>',
		),
	);
	$bar = '<div class="jsc-share"><span class="jsc-share-label">Share this:</span>';
	foreach ( $icons as $key => $i ) {
		$span = $i['label'] ? '<span>' . $i['label'] . '</span>' : '';
		$aria = $i['label'] ? '' : ' aria-label="Share on X"';
		$bar .= '<a class="jsc-share-btn" href="' . esc_url( $i['href'] ) . '" target="_blank" rel="noopener nofollow"' . $aria . '>' . $i['svg'] . $span . '</a>';
	}
	$bar .= '<button type="button" class="jsc-share-btn" onclick="navigator.clipboard.writeText(\'' . $plain . '\');this.querySelector(\'span\').textContent=\'Copied!\';"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy Link</span></button>';
	$bar .= '</div>';
	return $content . $bar;
}, 0 ); // before AIOSEO's author bio box appends

/**
 * Noindex author archives — single-author site, the archive duplicates /blog/.
 * The AIOSEO setting (Archives > Author > noindex) is set but never applies here:
 * with the posts page at /blog/, its meta wins over the author branch in
 * AIOSEO's Robots::meta(). Enforce via AIOSEO's own filter instead.
 */
add_filter( 'aioseo_robots_meta', function ( $attributes ) {
	if ( is_author() ) {
		$attributes['noindex'] = 'noindex';
	}
	return $attributes;
} );
