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
	$bar = '<style>.te-share{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin:36px 0 8px;padding-top:20px;border-top:1px solid #e6e8ec}.te-share-label{font-weight:800;font-size:14px;color:#16181d;margin-right:4px}.te-share-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;font-size:13.5px;color:#16181d;background:#fff;border:1px solid #e6e8ec;border-radius:99px;padding:8px 16px;text-decoration:none;cursor:pointer;transition:all .15s ease}.te-share-btn:hover{border-color:#1248d7;color:#1248d7;transform:translateY(-1px)}
.te-blog-tldr{background:#eef3ff;border-left:4px solid #1248d7;border-radius:10px;padding:20px 24px;margin:0 0 28px}
.te-blog-tldr p{margin:0;font-size:16.5px;line-height:1.6}
.te-blog-label{display:inline-block;font-weight:800;font-size:12.5px;letter-spacing:.08em;color:#1248d7;margin-bottom:8px}
.te-blog-table{width:100%;border-collapse:collapse;margin:8px 0 24px;font-size:15px}
.te-blog-table th{background:#f5f7fa;text-align:left;font-weight:800}
.te-blog-table th,.te-blog-table td{border:1px solid #e6e8ec;padding:10px 13px;vertical-align:top}
.te-blog-cta{background:#0f1626;border-radius:12px;padding:28px 30px;margin:32px 0;text-align:center;color:#fff}
.te-blog-cta h3{color:#fff;margin:0 0 8px;font-size:22px}
.te-blog-cta p{color:#c7cedb;margin:0 0 16px;font-size:15.5px}
.te-blog-cta a.te-blog-cta-btn{display:inline-block;background:#ff5a3c;color:#fff;font-weight:800;border-radius:8px;padding:13px 26px;text-decoration:none}
.te-blog-cta a.te-blog-cta-btn:hover{background:#ff7355}
.te-blog-cta .te-blog-cta-or{display:block;margin-top:12px;font-size:14.5px;color:#c7cedb}
.te-blog-cta .te-blog-cta-or a{color:#fff;font-weight:700}
.te-author-box{display:flex;gap:18px;align-items:center;background:#f5f7fa;border:1px solid #e6e8ec;border-radius:12px;padding:20px 22px;margin:24px 0 8px}
.te-author-box img{width:84px;height:84px;border-radius:50%;object-fit:cover;flex:none}
.te-author-box h4{margin:0 0 2px;font-size:17px}
.te-author-box .te-author-role{font-size:13px;font-weight:700;color:#1248d7;display:block;margin-bottom:6px}
.te-author-box p{margin:0;font-size:14.5px;line-height:1.55}
@media(max-width:540px){.te-author-box{flex-direction:column;text-align:center}}</style>';
	$bar .= '<div class="te-share"><span class="te-share-label">Share this:</span>';
	foreach ( $icons as $key => $i ) {
		$span = $i['label'] ? '<span>' . $i['label'] . '</span>' : '';
		$aria = $i['label'] ? '' : ' aria-label="Share on X"';
		$bar .= '<a class="te-share-btn" href="' . esc_url( $i['href'] ) . '" target="_blank" rel="noopener nofollow"' . $aria . '>' . $i['svg'] . $span . '</a>';
	}
	$bar .= '<button type="button" class="te-share-btn" onclick="navigator.clipboard.writeText(\'' . $plain . '\');this.querySelector(\'span\').textContent=\'Copied!\';"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy Link</span></button>';
	$bar .= '</div>';
	// hand-rolled author box (no AIOSEO E-E-A-T dependency)
	$author = get_userdata( (int) get_post_field( 'post_author', get_the_ID() ) );
	if ( $author && 'ben' === $author->user_login ) {
		$bar .= '<div class="te-author-box"><img src="' . esc_url( home_url( '/wp-content/uploads/2025/10/Ben-Bishop.webp' ) ) . '" alt="Ben Bishop, owner of Tire Express and Complete Auto Service in Ocala FL" loading="lazy"><div><h4>Ben Bishop</h4><span class="te-author-role">Owner &amp; Manager, Tire Express &amp; Complete Auto Service</span><p>Ben runs the shop on Silver Springs Blvd — the guy Ocala reviews mention by name. Straight answers, fair prices, and a standard that every vehicle leaves here done right. <a href="/our-team/">Meet the team</a>.</p></div></div>';
	}
	return $content . $bar;
}, 0 );

/** Ben's headshot wherever WP asks for his avatar (byline, comments). */
add_filter( 'pre_get_avatar_data', function ( $args, $id_or_email ) {
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
	if ( $user && 'ben' === $user->user_login ) {
		$args['url'] = home_url( '/wp-content/uploads/2025/10/Ben-Bishop.webp' );
		$args['found_avatar'] = true;
	}
	return $args;
}, 10, 2 );

/** Single-author blog: keep the thin author archive out of the index. */
add_filter( 'aioseo_robots_meta', function ( $attributes ) {
	if ( is_author() ) {
		$attributes['noindex'] = 'noindex';
	}
	return $attributes;
} );

/**
 * Facebook's web sharer (sharer.php) dead-ends inside the mobile Facebook app — it opens the app,
 * which can't process the web endpoint, and jiggles to nothing. On devices with the Web Share API,
 * open the native OS share sheet instead (where picking Facebook lands in its real composer).
 * Desktop is untouched (sharer.php popup still works). Targets the FB link by href, class-agnostic.
 */
add_action( 'wp_footer', function () {
	if ( ! is_singular() ) {
		return;
	}
	?>
<script>document.addEventListener("click",function(e){var fb=e.target.closest('a[href*="facebook.com/sharer"]');if(fb&&navigator.share){e.preventDefault();var u;try{u=new URL(fb.href).searchParams.get("u");}catch(x){}navigator.share({title:document.title,url:u||location.href}).catch(function(){});}});</script>
	<?php
} );
