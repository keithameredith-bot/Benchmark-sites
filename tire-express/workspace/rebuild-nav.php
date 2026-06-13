<?php
/**
 * wp eval-file rebuild-nav.php — deterministic rebuild of the Primary menu.
 * Deletes all items, recreates the full tree in order. Safe to re-run.
 */
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object( $locations['primary'] );
if ( ! $menu ) { echo "ABORT: no primary menu\n"; exit; }

foreach ( wp_get_nav_menu_items( $menu->term_id, array( 'post_status' => 'any' ) ) as $i ) {
	wp_delete_post( $i->ID, true );
}
echo "old items deleted\n";

function te_add( $menu_id, $label, $slug_or_url, $parent = 0 ) {
	$args = array( 'menu-item-title' => $label, 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent );
	if ( 0 === strpos( $slug_or_url, '/' ) && '/' !== $slug_or_url ) {
		$p = get_page_by_path( trim( $slug_or_url, '/' ) );
		if ( $p ) {
			$args += array( 'menu-item-object' => 'page', 'menu-item-object-id' => $p->ID, 'menu-item-type' => 'post_type' );
		} else {
			$args += array( 'menu-item-url' => $slug_or_url, 'menu-item-type' => 'custom' );
		}
	} else {
		$args += array( 'menu-item-url' => $slug_or_url, 'menu-item-type' => 'custom' );
	}
	$id = wp_update_nav_menu_item( $menu_id, 0, $args );
	echo str_repeat( '  ', $parent ? ( 1 ) : 0 ) . "+ $label\n";
	return $id;
}

$m = $menu->term_id;
te_add( $m, 'Home', '/' );
$svc = te_add( $m, 'Services', '/services/' );
	$tires = te_add( $m, 'Tires', '/new-tires-in-ocala/', $svc );
		te_add( $m, 'Used Tires', '/used-tires-ocala/', $tires );
		te_add( $m, 'Tire Repair', '/tire-repair-ocala/', $tires );
		te_add( $m, 'Tire Installation', '/tire-installation-ocala/', $tires );
		te_add( $m, 'Balancing & Rotation', '/tire-balancing-and-rotation/', $tires );
		te_add( $m, 'Lifted & Off-Road Tires', '/lifted-truck-tires-ocala/', $tires );
	te_add( $m, 'Wheel Alignment', '/wheel-alignment-ocala/', $svc );
	te_add( $m, 'Oil Change', '/oil-change-in-ocala/', $svc );
	te_add( $m, 'Brake Jobs', '/brake-jobs-in-ocala/', $svc );
	te_add( $m, 'Battery Replacement', '/battery-replacement-in-ocala/', $svc );
	te_add( $m, 'Tune Ups', '/tune-ups-in-ocala/', $svc );
	te_add( $m, 'A/C Repair & Recharge', '/car-air-conditioning-recharge/', $svc );
	te_add( $m, 'CV Axles', '/cv-axle-replacement-ocala/', $svc );
	te_add( $m, 'Fleet Accounts', '/fleet-maintenance-in-ocala/', $svc );
$about = te_add( $m, 'About Us', '/about-us/' );
	te_add( $m, 'Our Team', '/our-team/', $about );
	te_add( $m, 'Testimonials', '/testimonials/', $about );
	te_add( $m, 'Gallery', '/our-gallery/', $about );
	te_add( $m, "FAQ's", '/our-faqs/', $about );
te_add( $m, 'Blog', '/blogs/' );
te_add( $m, 'Contact', '/contact-us/' );

echo "--- final tree ---\n";
$items = wp_get_nav_menu_items( $menu->term_id );
$parents = array();
foreach ( $items as $i ) { $parents[ $i->ID ] = (int) $i->menu_item_parent; }
foreach ( $items as $i ) {
	$depth = 0; $p = (int) $i->menu_item_parent;
	while ( $p && isset( $parents[ $p ] ) ) { $depth++; $p = $parents[ $p ]; }
	echo str_repeat( '    ', $depth ) . "- {$i->title}\n";
}
