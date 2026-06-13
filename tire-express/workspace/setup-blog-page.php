<?php
// Make /blogs/ a real posts page (Kadence archive renders it; old Divi blog module was dead). Idempotent.
global $wpdb;
if ( 226141 !== (int) get_option( 'page_for_posts' ) ) {
	update_option( 'page_for_posts', 226141 );
	echo "page_for_posts => 226141\n";
} else { echo "page_for_posts already set\n"; }
// dead Divi content can go — archives ignore content, but keep the DB clean
$p = get_post( 226141 );
if ( false !== strpos( $p->post_content, 'wp:divi' ) ) {
	wp_update_post( array( 'ID' => 226141, 'post_content' => '' ) );
	echo "dead divi content cleared from blogs page\n";
}
// title/desc
$exists = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}aioseo_posts WHERE post_id = 226141" );
$meta = array( 'title' => 'Blog | Tire Express & Complete Auto Service in Ocala', 'description' => 'Tips, maintenance know-how and shop news from Tire Express in Ocala - tires, A/C, brakes and keeping your vehicle alive in the Florida heat.' );
if ( $exists ) { $wpdb->update( $wpdb->prefix . 'aioseo_posts', $meta, array( 'post_id' => 226141 ) ); }
else { $meta['post_id'] = 226141; $wpdb->insert( $wpdb->prefix . 'aioseo_posts', $meta ); }
echo "blogs page meta set\n";
// do the 3 posts have featured images?
foreach ( get_posts( array( 'post_type' => 'post', 'numberposts' => -1 ) ) as $post ) {
	echo "post {$post->ID} /{$post->post_name}/ thumb=" . ( get_post_thumbnail_id( $post->ID ) ?: 'NONE' ) . " len=" . strlen( $post->post_content ) . "\n";
}
