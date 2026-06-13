<?php
/**
 * wp eval-file apply-perfmatters-baseline.php — merge the Benchmark Perfmatters baseline
 * (C:\Users\keith\.perfmatters-baseline.json, from Black Rock) into JSC's local settings,
 * adapted: JSC hero preloads (montage + barndo, device-targeted), wpforms excluded from delay-all,
 * local_ga OFF (MonsterInsights handles GA). Runs BEFORE export so it ships with the migration.
 */
$opts = get_option( 'perfmatters_options' );
if ( ! is_array( $opts ) ) { $opts = array(); }

// housekeeping
foreach ( array( 'disable_emojis', 'disable_dashicons', 'disable_embeds', 'disable_xmlrpc', 'remove_jquery_migrate', 'hide_wp_version', 'remove_shortlink', 'disable_self_pingbacks', 'disable_comments', 'blank_favicon' ) as $k ) { $opts[ $k ] = '1'; }
$opts['limit_post_revisions'] = '10';

// assets: defer + delay-all (wpforms excluded — the quote form must stay interactive) + RUCSS
$opts['assets'] = array_merge( (array) ( $opts['assets'] ?? array() ), array(
	'defer_js'                   => '1',
	'delay_js'                   => '1',
	'delay_js_behavior'          => 'all',
	'delay_js_exclusions'        => array( 'wpforms' ),
	'remove_unused_css'          => '1',
	'rucss_excluded_stylesheets' => array( '.site-branding', '.custom-logo', '.custom-logo-link', '.site-logo', '.site-header', '.site-mobile-header-wrap', '.kadence-svg-iconset', '.header-button', '.menu-toggle-open' ),
) );

// preloads: montage (8 info pages) + barndo hero (the money page), device-targeted mobile variants
$montage_locs = '/,/services/,/about-us/,/core-values/,/our-team/,/galleries/,/contact/,/our-reviews/';
$opts['preload'] = array_merge( (array) ( $opts['preload'] ?? array() ), array(
	'preload' => array(
		array( 'url' => home_url( '/wp-content/uploads/2026/06/jsc-home-hero-montage.webp' ), 'as' => 'image', 'device' => 'desktop', 'locations' => $montage_locs, 'priority' => 'high' ),
		array( 'url' => home_url( '/wp-content/uploads/2026/06/jsc-home-hero-montage-mobile.webp' ), 'as' => 'image', 'device' => 'mobile', 'locations' => $montage_locs, 'priority' => 'high' ),
		array( 'url' => home_url( '/wp-content/uploads/2026/06/best-barndominium-builders-in-florida-hero.webp' ), 'as' => 'image', 'device' => 'desktop', 'locations' => '/barndominium-builders-in-florida/', 'priority' => 'high' ),
		array( 'url' => home_url( '/wp-content/uploads/2026/06/barndo-hero-mobile.webp' ), 'as' => 'image', 'device' => 'mobile', 'locations' => '/barndominium-builders-in-florida/', 'priority' => 'high' ),
	),
) );

// lazyload + fonts
$opts['lazyload'] = array_merge( (array) ( $opts['lazyload'] ?? array() ), array(
	'lazy_loading' => '1', 'exclude_leading_images' => '2', 'lazy_loading_iframes' => '1',
	'threshold' => '400', 'lazy_loading_dom_monitoring' => '1', 'image_dimensions' => '1',
) );
$opts['fonts'] = array_merge( (array) ( $opts['fonts'] ?? array() ), array( 'local_google_fonts' => '1', 'display_swap' => '1', 'subsets' => array( 'latin' ) ) );
// MonsterInsights owns GA — do NOT double up
if ( isset( $opts['analytics']['enable_local_ga'] ) ) { $opts['analytics']['enable_local_ga'] = ''; }

update_option( 'perfmatters_options', $opts );
echo "perfmatters baseline merged: delay-all(excl wpforms), RUCSS, 4 device-targeted preloads, lazy, local fonts\n";
