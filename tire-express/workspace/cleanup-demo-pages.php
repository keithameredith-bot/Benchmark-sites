<?php
/**
 * wp eval-file cleanup-demo-pages.php — trash theme-demo filler pages (Keith approved 2026-06-10).
 * TRASH not delete — recoverable for 30 days. Skips anything referenced in a nav menu or the home page.
 */
$candidates = array(
	5      => 'sample-page',
	226008 => 'fuel-level',
	226009 => 'air-filter',
	226010 => 'itemised-bill',
	226117 => 'gallery-filter-4-column-no-gutter',
	226116 => 'gallery-filter-3-column-no-gutter',
	226115 => 'gallery-filter-2-column-no-gutter',
	226114 => 'gallery-4-column-no-gutter',
	226113 => 'gallery-3-column-no-gutter',
	226112 => 'gallery-2-column-no-gutter',
	225809 => 'gallery-filter-3-column',
	225808 => 'gallery-filter-2-column',
	225803 => 'gallery-3-column',
	225801 => 'gallery-2-column',
	225795 => 'blog-column-4',
	225794 => 'blog-column-2',
	225788 => 'blog-list-image-right',
	225786 => 'blog-list-image-left',
	// Ignition demo leftovers — verified against nav/home below before trashing
	160    => 'works',
	39     => 'our-plan',
	226144 => 'our-testimonial',
);

// collect every object_id referenced by any nav menu
$menu_ids = array();
foreach ( wp_get_nav_menus() as $menu ) {
	foreach ( wp_get_nav_menu_items( $menu ) as $item ) {
		$menu_ids[] = (int) $item->object_id;
	}
}
$home = get_post( 7 )->post_content;

foreach ( $candidates as $id => $slug ) {
	if ( in_array( $id, $menu_ids, true ) ) { echo "KEEP $id ($slug) — in a nav menu\n"; continue; }
	if ( false !== strpos( $home, '/' . $slug . '/' ) ) { echo "KEEP $id ($slug) — linked from home\n"; continue; }
	$p = get_post( $id );
	if ( ! $p || 'trash' === $p->post_status ) { echo "SKIP $id ($slug) — gone already\n"; continue; }
	wp_trash_post( $id );
	echo "TRASHED $id ($slug)\n";
}
echo "DONE\n";
