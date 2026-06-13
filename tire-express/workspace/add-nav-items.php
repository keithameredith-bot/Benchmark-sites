<?php
// Add Battery Replacement + Fleet Accounts under the Services submenu in the ACTIVE header menu
// ('Primary' — assigned to the kadence `primary` location; 'main_menu' is the unused Divi-era menu). Idempotent.
$locations = get_nav_menu_locations();
$menu = ! empty( $locations['primary'] ) ? wp_get_nav_menu_object( $locations['primary'] ) : null;
if ( ! $menu ) { echo "ABORT: primary-location menu not found\n"; exit; }
echo "target menu: '{$menu->name}' ({$menu->term_id})\n";
$items = wp_get_nav_menu_items( $menu->term_id );
$parent_id = 0;
$existing  = array();
foreach ( $items as $it ) {
	if ( 'Services' === $it->title ) { $parent_id = $it->ID; }
	$existing[ (int) $it->object_id ] = $it->ID;
}
if ( ! $parent_id ) { echo "ABORT: Services menu item not found\n"; exit; }
echo "Services menu item: $parent_id\n";
$add = array( 227931 => 'Battery Replacement', 227932 => 'Fleet Accounts' );
foreach ( array( 'used-tires-ocala' => 'Used Tires', 'tire-repair-ocala' => 'Tire Repair', 'wheel-alignment-ocala' => 'Wheel Alignment' ) as $slug => $label ) {
	$p = get_page_by_path( $slug );
	if ( $p ) { $add[ $p->ID ] = $label; }
}
foreach ( $add as $page_id => $label ) {
	if ( isset( $existing[ $page_id ] ) ) { echo "SKIP $label — already in menu\n"; continue; }
	$r = wp_update_nav_menu_item( $menu->term_id, 0, array(
		'menu-item-title'     => $label,
		'menu-item-object'    => 'page',
		'menu-item-object-id' => $page_id,
		'menu-item-type'      => 'post_type',
		'menu-item-parent-id' => $parent_id,
		'menu-item-status'    => 'publish',
	) );
	echo is_wp_error( $r ) ? "ERR $label: " . $r->get_error_message() . "\n" : "ADDED $label (item $r)\n";
}
echo "DONE\n";
