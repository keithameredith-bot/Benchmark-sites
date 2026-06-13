<?php
/**
 * wp eval-file apply-te-pages.php — rebuild the 4 broken Divi service pages in the te-np template.
 * Edit page-<slug>.html (body) or te-np.css (shared styles) → rerun. Idempotent.
 * Also sets AIOSEO titles/descriptions (house style: price in title where one exists).
 */
$dir = 'C:/Users/keith/Desktop/tire-express-workspace/';
$css = file_get_contents( $dir . 'te-np.css' );
if ( ! $css ) { echo "ABORT: te-np.css missing\n"; exit; }
$css = preg_replace( '/^\xEF\xBB\xBF/', '', $css ); // strip BOM — a BOM before @import kills the font load
$css = str_replace( 'http://tire-express.local', '', $css ); // relative URLs — survive deploy search-replace

// pages created by create-new-pages.php get their IDs resolved by slug here
$by_slug = array(
	'used-tires-ocala' => array(
		'file'  => 'page-used-tires-ocala.html',
		// "used tires near me" 49,500/mo FL + "used tires ocala fl" 480 (DataForSEO 2026-06-10)
		'title' => 'Used Tires in Ocala, FL | Inspected, Mounted & Balanced',
		'desc'  => 'Quality used tires in Ocala - tread, sidewall & age inspected before sale, mounted and balanced on pro equipment. Stock changes daily, call with your size!',
	),
	'tire-repair-ocala' => array(
		'file'  => 'page-tire-repair-ocala.html',
		// "tire repair near me" 27,100/mo + flat 2,900 + patch 2,900 + plug 1,300
		'title' => 'Tire Repair in Ocala, FL | Flats, Patches & Plugs',
		'desc'  => 'Flat tire repair in Ocala - proper inside patch-plug repairs, slow leaks found and fixed, honest answers on what is repairable. Most done while you wait.',
	),
	'wheel-alignment-ocala' => array(
		'file'  => 'page-wheel-alignment-ocala.html',
		// "alignment near me" 12,100/mo + "wheel alignment near me" 6,600 + front end 1,300
		'title' => 'Wheel Alignment in Ocala, FL | Stop Uneven Tire Wear',
		'desc'  => 'Wheel alignments in Ocala - fix pulling, crooked steering and uneven tire wear. Suspension checked as part of every job. Pairs perfectly with new tires.',
	),
	'tire-installation-ocala' => array(
		'file'  => 'page-tire-installation-ocala.html',
		// "tire installation near me" 1,900/mo + "tire mounting near me" 590
		'title' => 'Tire Installation in Ocala, FL | Online Tire Orders Welcome',
		'desc'  => 'Bought tires online? We install them - pro mounting & balancing, TPMS service, old tires recycled. TireRack, Amazon, anywhere. Call for an out-the-door quote.',
	),
	'lifted-truck-tires-ocala' => array(
		'file'  => 'page-lifted-truck-tires-ocala.html',
		// niche/brand page: direct searches tiny but "35 inch tires" 390 + "37 inch tires" 210; lift kits confirmed by Keith
		'title' => 'Lifted Truck & Off-Road Tires in Ocala, FL | 35s, 38s & Lift Kits',
		'desc'  => 'Mud tires, all-terrains & big rubber up to 37" - mounted and balanced right, plus lift kit installation. The Ocala shop that actually likes your lifted truck.',
	),
	'cv-axle-replacement-ocala' => array(
		'file'  => 'page-cv-axle-replacement-ocala.html',
		// "cv axle replacement cost" 2,400/mo (cost intent) + repair near me 110
		'title' => 'CV Axle Replacement in Ocala, FL | Clicking Noise, Fixed',
		'desc'  => 'Clicking when you turn? CV axle replacement in Ocala - diagnosed first (it is not always the axle), out-the-door price before any work, most done same day.',
	),
);
$pages = array();
foreach ( $by_slug as $slug => $def ) {
	$p = get_page_by_path( $slug );
	if ( $p ) { $pages[ $p->ID ] = $def; } else { echo "WARN: page $slug not found — run create-new-pages.php first\n"; }
}
$pages += array(
	226138 => array(
		'file'  => 'page-about-us.html',
		'title' => 'About Us | Tire Express & Complete Auto Service, Ocala FL',
		'desc'  => 'Locally owned, no corporate vibe - Tire Express was built from the ground up around customer service. Meet Ocala\'s hometown tire shop and auto repair crew.',
	),
	711 => array(
		'file'  => 'page-our-team.html',
		'title' => 'Our Team | Tire Express & Complete Auto Service in Ocala',
		'desc'  => 'Meet the crew - Ben (owner & manager) and Ocala\'s top mechanical talent, with 50+ years of combined experience in tires and auto service.',
	),
	226144 => array(
		'file'  => 'page-testimonials.html',
		'title' => 'Testimonials | 5.0-Star Tire Shop & Auto Repair in Ocala',
		'desc'  => 'Real reviews from real customers - fleets, lifted trucks, semis and daily drivers. See why Tire Express holds a 5.0 rating on Google in Ocala.',
	),
	858 => array(
		'file'  => 'page-our-faqs.html',
		'title' => 'FAQs | Tire Express & Complete Auto Service in Ocala, FL',
		'desc'  => 'Appointments, quotes, towing, overnight drop-off, financing, installs on parts you bought - quick answers to the questions we hear most.',
	),
	15 => array(
		'file'  => 'page-services.html',
		'title' => 'Auto Repair Services in Ocala, FL | Tire Express',
		'desc'  => 'Tires (new, used, lifted & repairs), oil changes, brakes, alignments, batteries, A/C, tune ups, CV axles and fleet accounts - one local Ocala shop for all of it.',
	),
	533 => array(
		'file'  => 'page-our-gallery.html',
		'title' => 'Gallery | Real Work at Tire Express in Ocala, FL',
		'desc'  => 'Real jobs from our bays - lifted trucks, engine rebuilds, big tires and more. No stock photos, just what a day at Tire Express in Ocala looks like.',
	),
	18 => array(
		'file'  => 'page-contact-us.html',
		'title' => 'Contact Tire Express | Tire Shop & Auto Repair in Ocala, FL',
		'desc'  => 'Call (352) 421-5650, email, or visit Tire Express at 1708 E Silver Springs Blvd, Ocala - quotes by phone, walk-ins welcome, Mon-Fri 8-5. Fleets loved.',
	),
	7 => array(
		'file'  => 'page-home.html',
		// "tire shop ocala fl" 880/mo + "auto repair ocala fl" 1,300/mo; brand kept first
		'title' => 'Tire Express | Tire Shop & Auto Repair in Ocala, FL',
		'desc'  => 'Locally owned tire shop & complete auto repair in Ocala - new & used tires, brakes, oil, A/C, alignments and more. Honest prices, 5.0 stars. Veterans save 20%.',
	),
	226004 => array(
		'file'  => 'page-brake-jobs-in-ocala.html',
		'title' => 'Brake Jobs in Ocala, FL | Pads & Rotors From $350 Per Axle',
		'desc'  => 'Honest brake jobs in Ocala - free inspections, no scare tactics, new pads & rotors from $350 per axle. All makes & models. Veterans save 20%.',
	),
	226001 => array(
		'file'  => 'page-car-air-conditioning-recharge.html',
		// "car ac repair near me" = 12,100/mo FL vs "ac recharge near me" 590 (DataForSEO 2026-06-10) — page covers leak detection/repair, title broadened
		'title' => 'Car A/C Repair & Recharge in Ocala, FL | From $139.95',
		'desc'  => 'Car A/C repair & recharge in Ocala from $139.95 - full evacuation, vacuum test, leak detection & recharge to spec, usually ~30 minutes. Veterans save 20%.',
	),
	227931 => array(
		'file'  => 'page-battery-replacement-in-ocala.html',
		// "battery replacement near me" 1,000/mo + "car battery replacement near me" 720/mo FL; free testing confirmed by Keith
		'title' => 'Car & Truck Battery Replacement in Ocala, FL | Free Testing',
		'desc'  => 'Free battery testing & fast replacement in Ocala for cars and trucks - we test the battery AND charging system first. Veterans save 20%.',
	),
	227932 => array(
		'file'  => 'page-fleet-maintenance-in-ocala.html',
		// low volume B2B ("fleet repair near me" 140/mo) but $20-27 CPC — sales page more than SEO play
		'title' => 'Fleet Maintenance & Repair in Ocala, FL | Fleet Accounts',
		'desc'  => 'Fleet accounts at Tire Express Ocala - one local shop for tires, brakes, oil, batteries & repair on your work trucks and vans. Less downtime, simple billing.',
	),
	226007 => array(
		'file'  => 'page-tune-ups-in-ocala.html',
		'title' => 'Tune Ups in Ocala, FL | Honest Diagnostics & $89.95 Coolant Flush',
		'desc'  => 'Engine running rough or check engine light on? Honest computer diagnostics & tune ups in Ocala, plus $89.95 coolant flushes. Veterans save 20%.',
	),
	226003 => array(
		'file'  => 'page-tire-balancing-and-rotation.html',
		'title' => 'Tire Balancing & Rotation in Ocala, FL | Up to 37" Tires',
		'desc'  => 'Tire balancing & rotation in Ocala on pro Coats equipment - smooth rides, even wear, off-road tires up to 37 inches. Veterans save 20%.',
	),
);

global $wpdb;
foreach ( $pages as $id => $p ) {
	$body = file_get_contents( $dir . $p['file'] );
	if ( ! $body ) { echo "SKIP $id: {$p['file']} missing\n"; continue; }
	$slug    = get_post( $id )->post_name;
	// fonts via parallel <link>s, NOT @import (the @import serial chain was the mobile-LCP killer)
	$font_links = '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"><link rel="preload" as="image" href="/wp-content/uploads/2026/06/store-front-hero.webp" media="(min-width:641px)"><link rel="preload" as="image" href="/wp-content/uploads/2026/06/store-front-hero-mobile.webp" media="(max-width:640px)">';
	$content = "<!-- wp:html -->\n<!-- " . strtoupper( $slug ) . " - te-np template (shared CSS from te-np.css). Edit workspace file + rerun apply-te-pages.php -->\n" . $font_links . "\n<style>\n" . trim( $css ) . "\n</style>\n\n" . trim( $body ) . "\n<!-- /wp:html -->";
	// wp_slash: wp_update_post unslashes — without this, CSS escapes like content:"\2212" lose their backslash
	$r = wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $content ) ), true );
	if ( is_wp_error( $r ) ) { echo "ERROR $id: " . $r->get_error_message() . "\n"; continue; }
	// page meta to match the oil-change page (full width, hide theme title — content provides the H1)
	update_post_meta( $id, '_kad_post_title', 'hide' );
	update_post_meta( $id, '_kad_post_layout', 'fullwidth' );
	update_post_meta( $id, '_kad_post_content_style', 'unboxed' );
	update_post_meta( $id, '_kad_post_vertical_padding', 'hide' );
	// AIOSEO meta
	$tl = mb_strlen( $p['title'] ); $dl = mb_strlen( $p['desc'] );
	$exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}aioseo_posts WHERE post_id = %d", $id ) );
	if ( $exists ) {
		$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'title' => $p['title'], 'description' => $p['desc'] ), array( 'post_id' => $id ) );
	} else {
		$wpdb->insert( $wpdb->prefix . 'aioseo_posts', array( 'post_id' => $id, 'title' => $p['title'], 'description' => $p['desc'] ) );
	}
	echo "OK $id ($slug): content " . strlen( $content ) . "B, title={$tl}c, desc={$dl}c\n";
}
echo "DONE\n";
