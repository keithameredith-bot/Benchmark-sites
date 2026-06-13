<?php
/**
 * wp eval-file restructure-nav.php — restructure the Primary menu Services dropdown (Keith approved):
 * "New Tires" item becomes "Tires" group (still links /new-tires-in-ocala/) with tire pages nested
 * under it; Tire Installation / Lifted & Off-Road / CV Axles added (were footer-only). Idempotent-ish.
 */
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object( $locations['primary'] );
if ( ! $menu ) { echo "ABORT: no primary menu\n"; exit; }
$items = wp_get_nav_menu_items( $menu->term_id, array( 'post_status' => 'any' ) );
$by_object = array(); $by_title = array();
foreach ( $items as $i ) { $by_object[ (int) $i->object_id ] = $i; $by_title[ $i->title ] = $i; }

$services = $by_title['Services'];
$tires_item = $by_object[226130]; // "New Tires"

// helper: update a nav item keeping its object link
function te_nav_update( $item, $args ) {
	$defaults = array(
		'menu-item-title'     => $item->title,
		'menu-item-object'    => $item->object,
		'menu-item-object-id' => $item->object_id,
		'menu-item-type'      => $item->type,
		'menu-item-parent-id' => $item->menu_item_parent,
		'menu-item-status'    => 'publish',
		'menu-item-position'  => $item->menu_order,
	);
	global $te_menu_id;
	return wp_update_nav_menu_item( $te_menu_id, $item->ID, array_merge( $defaults, $args ) );
}
global $te_menu_id; $te_menu_id = $menu->term_id;

// 1. "New Tires" -> "Tires" group head
te_nav_update( $tires_item, array( 'menu-item-title' => 'Tires', 'menu-item-position' => 10 ) );
echo "tires group head set\n";

// 2. nest existing tire items under it
$nest = array( 227947 => 11 /* Used */, 227948 => 12 /* Repair */, 226133 => 14 /* Balancing */ );
foreach ( $nest as $obj => $pos ) {
	if ( isset( $by_object[ $obj ] ) ) {
		te_nav_update( $by_object[ $obj ], array( 'menu-item-parent-id' => $tires_item->ID, 'menu-item-position' => $pos ) );
		echo "nested {$by_object[$obj]->title}\n";
	}
}

// 3. add the missing pages (installation 13, lifted 15 under Tires; CV top-level 26)
$add = array(
	array( 'slug' => 'tire-installation-ocala',   'label' => 'Tire Installation',        'parent' => $tires_item->ID, 'pos' => 13 ),
	array( 'slug' => 'lifted-truck-tires-ocala',  'label' => 'Lifted & Off-Road Tires',  'parent' => $tires_item->ID, 'pos' => 15 ),
	array( 'slug' => 'cv-axle-replacement-ocala', 'label' => 'CV Axles',                 'parent' => $services->ID,   'pos' => 26 ),
);
foreach ( $add as $a ) {
	$p = get_page_by_path( $a['slug'] );
	if ( ! $p ) { echo "MISS {$a['slug']}\n"; continue; }
	if ( isset( $by_object[ $p->ID ] ) ) {
		te_nav_update( $by_object[ $p->ID ], array( 'menu-item-parent-id' => $a['parent'], 'menu-item-position' => $a['pos'], 'menu-item-title' => $a['label'] ) );
		echo "moved {$a['label']}\n";
	} else {
		wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title' => $a['label'], 'menu-item-object' => 'page', 'menu-item-object-id' => $p->ID,
			'menu-item-type' => 'post_type', 'menu-item-parent-id' => $a['parent'], 'menu-item-status' => 'publish',
			'menu-item-position' => $a['pos'],
		) );
		echo "added {$a['label']}\n";
	}
}

// 4. order the rest of the Services children
$order = array( 227949 => 20 /* Alignment */, 226131 => 21 /* Oil */, 226132 => 22 /* Brakes */, 227939 => 23 /* Battery */, 226129 => 24 /* Tune Ups */, 226134 => 25 /* AC */, 227940 => 27 /* Fleet */ );
foreach ( $order as $obj => $pos ) {
	if ( isset( $by_object[ $obj ] ) ) { te_nav_update( $by_object[ $obj ], array( 'menu-item-position' => $pos ) ); }
}
echo "ordered\n";

// final state
foreach ( wp_get_nav_menu_items( $menu->term_id ) as $i ) {
	$depth = $i->menu_item_parent ? ( ( isset( $by_title['Services'] ) && (int) $i->menu_item_parent === $services->ID ) ? 1 : 2 ) : 0;
	echo str_repeat( '  ', $depth ) . "- {$i->title}\n";
}
