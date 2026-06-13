<?php
/**
 * Apply the Kadence rebuild of /barndominium-builders-in-florida/ (post 100717) on LOCAL.
 * Run: wp eval-file apply-barndo-page.php
 * Idempotent — safe to re-run after editing barndo-kadence-content.html.
 */

$page_id = 100717;
$content_file = 'C:\Users\keith\Desktop\jsc-kadence-mockup\barndo-kadence-content.html';

$content = file_get_contents( $content_file );
if ( false === $content || strlen( $content ) < 1000 ) {
	echo "ABORT: could not read content file\n";
	exit( 1 );
}

// 1. Page content.
$r = wp_update_post( array( 'ID' => $page_id, 'post_content' => $content ), true );
echo is_wp_error( $r ) ? 'ERROR: ' . $r->get_error_message() . "\n" : "content updated\n";

// 2. Kadence per-page layout: hide theme title (hero owns the single H1), full-width unboxed content.
update_post_meta( $page_id, '_kad_post_title', 'hide' );
update_post_meta( $page_id, '_kad_post_layout', 'fullwidth' );
update_post_meta( $page_id, '_kad_post_content_style', 'unboxed' );
update_post_meta( $page_id, '_kad_post_vertical_padding', 'hide' );
echo "kadence page meta set\n";

// 3. Attachment alt text (sitewide benefit — galleries pull alts from attachment meta).
$alts = array(
	100726 => 'Barndominium with wood siding built by JSC Contracting in Florida',
	100729 => 'Aerial view of a completed JSC barndominium build',
	100730 => 'Board and batten barndominium exterior in central Florida',
	100159 => 'Barndominium interior with vaulted ceilings and open kitchen',
	100733 => 'Barndominium garage and shop space',
	100739 => 'Rustic barndominium interior with aged wood finishes',
	100736 => 'Barndominium interior framing and finish work',
);
foreach ( $alts as $id => $alt ) {
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
}
echo "attachment alts set\n";

// 4. Kadence global palette → approved JSC colors (1=blue, 2=blue-dark, 3=ink, 4=ink-soft).
$palette = get_option( 'kadence_global_palette' );
$palette = $palette ? json_decode( $palette, true ) : null;
if ( ! is_array( $palette ) || empty( $palette['palette'] ) ) {
	$defaults = array( '#2B6CB0', '#215387', '#1A202C', '#2D3748', '#4A5568', '#718096', '#EDF2F7', '#F7FAFC', '#ffffff' );
	$palette = array( 'palette' => array(), 'active' => 'palette' );
	foreach ( $defaults as $i => $c ) {
		$palette['palette'][] = array( 'color' => $c, 'slug' => 'palette' . ( $i + 1 ), 'name' => 'Palette Color ' . ( $i + 1 ) );
	}
}
$jsc = array( 'palette1' => '#2166D3', 'palette2' => '#174FA8', 'palette3' => '#16191D', 'palette4' => '#3C434B' );
foreach ( $palette['palette'] as &$c ) {
	if ( isset( $jsc[ $c['slug'] ] ) ) {
		$c['color'] = $jsc[ $c['slug'] ];
	}
}
unset( $c );
update_option( 'kadence_global_palette', wp_json_encode( $palette ) );
echo "global palette set\n";

// 5. Make sure the menu also serves the mobile drawer.
$locations = get_theme_mod( 'nav_menu_locations', array() );
if ( empty( $locations['mobile'] ) && ! empty( $locations['primary'] ) ) {
	$locations['mobile'] = $locations['primary'];
	set_theme_mod( 'nav_menu_locations', $locations );
	echo "mobile menu assigned\n";
}

echo "DONE\n";
