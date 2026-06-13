<?php
// "Our Testimonial" (226144) -> "Testimonials": page title + slug + nav menu label. Idempotent.
$p = get_post( 226144 );
if ( ! $p ) { echo "ABORT: page missing\n"; exit; }
echo "BEFORE: '{$p->post_title}' /{$p->post_name}/\n";
wp_update_post( array( 'ID' => 226144, 'post_title' => 'Testimonials', 'post_name' => 'testimonials' ) );
$p = get_post( 226144 );
echo "AFTER:  '{$p->post_title}' /{$p->post_name}/  old-slug meta: " . implode( ',', get_post_meta( 226144, '_wp_old_slug' ) ) . "\n";

// nav menu items pointing at this page — fix their labels if they carry the old text
foreach ( wp_get_nav_menus() as $menu ) {
	foreach ( wp_get_nav_menu_items( $menu ) as $item ) {
		if ( 226144 === (int) $item->object_id ) {
			echo "menu '{$menu->name}' item {$item->ID}: label '{$item->title}'";
			if ( 'Testimonials' !== $item->title ) {
				wp_update_post( array( 'ID' => $item->ID, 'post_title' => 'Testimonials' ) );
				echo " -> 'Testimonials'";
			}
			echo "\n";
		}
	}
}
echo "DONE\n";
