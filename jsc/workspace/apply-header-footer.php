<?php
/**
 * Configure Kadence header + footer for JSC per the approved mockup. LOCAL.
 * Run: wp eval-file apply-header-footer.php   (idempotent)
 * Header: logo left, nav + click-to-call right, no top bar.
 * Footer: 3 cols (contact / services / service area) + CONQUER values band + license fine print.
 */

// ---------- LOGO ----------
global $wpdb;
$logo_id = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE '%/2025/12/JSC-Wide.png' LIMIT 1" );
if ( $logo_id ) {
	set_theme_mod( 'custom_logo', (int) $logo_id );
	set_theme_mod( 'logo_width', array(
		'size' => array( 'mobile' => 140, 'tablet' => 160, 'desktop' => 190 ),
		'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ),
	) );
	echo "logo set (id $logo_id)\n";
} else {
	echo "WARN: JSC-Wide.png attachment not found — logo not set\n";
}

// ---------- HEADER ----------
set_theme_mod( 'header_desktop_items', array(
	'top'    => array( 'top_left' => array(), 'top_left_center' => array(), 'top_center' => array(), 'top_right_center' => array(), 'top_right' => array() ),
	'main'   => array(
		'main_left'         => array( 'logo' ),
		'main_left_center'  => array(),
		'main_center'       => array(),
		'main_right_center' => array(),
		'main_right'        => array( 'navigation', 'html' ),
	),
	'bottom' => array( 'bottom_left' => array(), 'bottom_left_center' => array(), 'bottom_center' => array(), 'bottom_right_center' => array(), 'bottom_right' => array() ),
) );

// Click-to-call button (mockup pattern, styled by child theme .jsc-btn).
$call_btn = '<a class="jsc-btn jsc-call-btn" href="tel:3526872030"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg> 352.687.2030</a>';
set_theme_mod( 'header_html_content', $call_btn );
set_theme_mod( 'header_html_wpautop', false );

// Mobile: logo left; call button + menu toggle right.
set_theme_mod( 'header_mobile_items', array(
	'popup'  => array( 'popup_content' => array( 'mobile-navigation' ) ),
	'top'    => array( 'top_left' => array(), 'top_center' => array(), 'top_right' => array() ),
	'main'   => array(
		'main_left'   => array( 'mobile-logo' ),
		'main_center' => array(),
		'main_right'  => array( 'mobile-html', 'popup-toggle' ),
	),
	'bottom' => array( 'bottom_left' => array(), 'bottom_center' => array(), 'bottom_right' => array() ),
) );
set_theme_mod( 'mobile_html_content', $call_btn );
set_theme_mod( 'mobile_html_wpautop', false );
echo "header configured\n";

// ---------- FOOTER LAYOUT ----------
set_theme_mod( 'footer_items', array(
	'top'    => array( 'top_1' => array( 'footer-widget4' ), 'top_2' => array(), 'top_3' => array(), 'top_4' => array(), 'top_5' => array() ),
	'middle' => array( 'middle_1' => array( 'footer-widget1' ), 'middle_2' => array( 'footer-widget2' ), 'middle_3' => array( 'footer-widget3' ), 'middle_4' => array(), 'middle_5' => array() ),
	'bottom' => array( 'bottom_1' => array( 'footer-html' ), 'bottom_2' => array(), 'bottom_3' => array(), 'bottom_4' => array(), 'bottom_5' => array() ),
) );
set_theme_mod( 'footer_top_columns', '1' );
set_theme_mod( 'footer_middle_columns', '3' );
set_theme_mod( 'footer_bottom_columns', '1' );
set_theme_mod( 'footer_wrap_background', array( 'desktop' => array( 'color' => '#0F1216' ) ) );

// License + copyright fine print.
set_theme_mod( 'footer_html_content', '{copyright} {year} JSC Contracting Inc. • Florida Certified Residential Contractor — Lic. CRC1332267 • Developed by <a href="https://benchmarkwebd.com/" target="_blank" rel="noopener">Benchmark Web Development</a>' );
echo "footer layout set\n";

// ---------- FOOTER WIDGETS (block widgets in footer1/2/3/4) ----------
$widget_blocks = get_option( 'widget_block', array() );
if ( ! is_array( $widget_blocks ) ) { $widget_blocks = array(); }

$jsc_widgets = array(
	'jsc1' => "<!-- wp:html -->\n<img class=\"jsc-footer-logo\" src=\"/wp-content/uploads/2025/12/logo-white.png\" alt=\"JSC Contracting Inc\" loading=\"lazy\"><p class=\"jsc-footer-tagline\">You dream it. We build it.</p>\n[bwd_stars]\n<p class=\"jsc-footer-review-link\"><a href=\"https://g.page/r/CU_afPuU9LllEBM/review\" target=\"_blank\" rel=\"noopener nofollow\">Worked with us? Leave a review →</a></p>\n<!-- /wp:html -->",
	'jsc2' => "<!-- wp:html -->\n<h3>Services</h3><ul class=\"jsc-footer-links\"><li><a href=\"/central-florida-dock-builder/\">Docks</a></li><li><a href=\"/boathouse-builder/\">Boat Houses</a></li><li><a href=\"/seawall-construction-and-repair/\">Seawalls</a></li><li><a href=\"/central-florida-boat-lift-installation/\">Boat Lifts</a></li><li><a href=\"/pole-barn-builder/\">Pole Barns</a></li><li><a href=\"/barndominium-builders-in-florida/\">Barndominiums</a></li><li><a href=\"/container-home-builders-in-florida/\">Container Homes</a></li><li><a href=\"/central-florida-fence-builder/\">Fencing</a></li><li><a href=\"/home-remodeling-central-florida/\">Remodeling</a></li><li><a href=\"/custom-new-construction-builder-in-central-florida/\">New Construction</a></li></ul>\n<!-- /wp:html -->",
	'jsc3' => "<!-- wp:html -->\n<h3>Contact</h3><p>16455 E Hwy 40, Unit 1<br>Silver Springs, FL 34488<br><a href=\"tel:3526872030\">352.687.2030</a><br><a href=\"mailto:info@jsc" . "fla.com\">info@jscfla.com</a></p><p><strong>Mon – Fri:</strong> 8am – 4pm</p><p>All of Central Florida and beyond — barndominiums and container homes built statewide.</p><a class=\"jsc-btn jsc-btn-gold\" href=\"/get-a-free-quote/\">GET A FREE QUOTE</a><div class=\"jsc-social\"><a href=\"https://www.facebook.com/JSCContractingInc\" target=\"_blank\" rel=\"noopener\" aria-label=\"JSC Contracting on Facebook\"><svg width=\"20\" height=\"20\" viewBox=\"0 0 24 24\" fill=\"currentColor\" aria-hidden=\"true\"><path d=\"M24 12.07C24 5.41 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.5h-2.8V24C19.62 23.1 24 18.1 24 12.07z\"/></svg></a><a href=\"https://www.instagram.com/jsc_contracting_inc/\" target=\"_blank\" rel=\"noopener\" aria-label=\"JSC Contracting on Instagram\"><svg width=\"20\" height=\"20\" viewBox=\"0 0 24 24\" fill=\"currentColor\" aria-hidden=\"true\"><path d=\"M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.72 3.72 0 0 1-1.38-.9 3.72 3.72 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63a5.88 5.88 0 0 0-2.13 1.38A5.88 5.88 0 0 0 .63 4.14C.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.8.72 1.48 1.38 2.13a5.88 5.88 0 0 0 2.13 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.88 5.88 0 0 0 2.13-1.38 5.88 5.88 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.88 5.88 0 0 0-1.38-2.13A5.88 5.88 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.15A4 4 0 1 1 16 12a4 4 0 0 1-4 3.99zm7.85-10.4a1.44 1.44 0 1 1-1.44-1.44 1.44 1.44 0 0 1 1.44 1.44z\"/></svg></a><a href=\"https://www.tiktok.com/@jsccontractinginc\" target=\"_blank\" rel=\"noopener\" aria-label=\"JSC Contracting on TikTok\"><svg width=\"20\" height=\"20\" viewBox=\"0 0 24 24\" fill=\"currentColor\" aria-hidden=\"true\"><path d=\"M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.04-.1z\"/></svg></a></div>\n<!-- /wp:html -->",
	'jsc4' => "<!-- wp:html -->\n<div class=\"jsc-values\">OUR VALUES: <b>C</b>ONSISTENCY • <b>O</b>RGANIZATION • <b>N</b>EAT • <b>Q</b>UALITY • <b>U</b>NITY • <b>E</b>NVIRONMENT • <b>R</b>ELIABILITY</div>\n<!-- /wp:html -->",
);

// Reuse stable instance slots 90-93 so re-runs overwrite instead of duplicating.
$slot = 90;
$sidebar_map = array();
foreach ( $jsc_widgets as $k => $content ) {
	$widget_blocks[ $slot ] = array( 'content' => $content );
	$sidebar_map[ $k ] = 'block-' . $slot;
	$slot++;
}
update_option( 'widget_block', $widget_blocks );

$sidebars = get_option( 'sidebars_widgets', array() );
$sidebars['footer1'] = array( $sidebar_map['jsc1'] );
$sidebars['footer2'] = array( $sidebar_map['jsc2'] );
$sidebars['footer3'] = array( $sidebar_map['jsc3'] );
$sidebars['footer4'] = array( $sidebar_map['jsc4'] );
update_option( 'sidebars_widgets', $sidebars );
echo "footer widgets set\n";

echo "DONE\n";
