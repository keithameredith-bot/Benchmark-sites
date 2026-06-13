<?php
/**
 * fgs-08-deep-red.php — Keith feedback: accent should be the LOGO's deep red, not the
 * live site's muted #c63a3a. Logo reds sampled: #a91513 (bright) -> #600000 (deep).
 * Swaps #c63a3a -> #a91513 and #a93232 (hover) -> #7c0e0d across:
 * Kadence palette, post content, footer widget_block, Additional CSS.
 * Dry run default; FGS_APPLY=1 to write. Idempotent.
 */

$apply = (bool) getenv( 'FGS_APPLY' );
WP_CLI::log( $apply ? '== APPLY ==' : '== DRY RUN ==' );

$hex_map = array(
	'#c63a3a' => '#a91513',
	'#a93232' => '#7c0e0d',
);

// palette
$dec = json_decode( get_option( 'kadence_global_palette' ), true );
$n   = 0;
foreach ( $dec['palette'] as &$e ) {
	if ( isset( $hex_map[ strtolower( $e['color'] ) ] ) ) {
		WP_CLI::log( "palette {$e['slug']}: {$e['color']} -> " . $hex_map[ strtolower( $e['color'] ) ] );
		$e['color'] = $hex_map[ strtolower( $e['color'] ) ];
		$n++;
	}
}
unset( $e );
if ( $n && $apply ) {
	update_option( 'kadence_global_palette', wp_json_encode( $dec ) );
	WP_CLI::log( '-> palette WRITTEN' );
}

// content
global $wpdb;
$ids   = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type IN ('page','post','wp_block') AND post_status IN ('publish','draft')" );
$total = 0;
foreach ( $ids as $id ) {
	$p   = get_post( $id );
	$new = str_ireplace( array_keys( $hex_map ), array_values( $hex_map ), $p->post_content );
	if ( $new === $p->post_content ) {
		continue;
	}
	$c = 0;
	foreach ( $hex_map as $f => $t ) {
		$c += substr_count( strtolower( $p->post_content ), $f );
	}
	$total += $c;
	WP_CLI::log( "content {$id} ({$p->post_title}): {$c}" );
	if ( $apply ) {
		wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $new ) ), true );
	}
}
WP_CLI::log( "content total: {$total}" );

// footer widget
$opt     = get_option( 'widget_block' );
$changed = false;
foreach ( $opt as $k => $v ) {
	if ( is_array( $v ) && isset( $v['content'] ) ) {
		$new = str_ireplace( array_keys( $hex_map ), array_values( $hex_map ), $v['content'] );
		if ( $new !== $v['content'] ) {
			$opt[ $k ]['content'] = $new;
			$changed              = true;
			WP_CLI::log( "widget_block[{$k}]: updated" );
		}
	}
}
if ( $changed && $apply ) {
	update_option( 'widget_block', $opt );
}

// custom css
$css = (string) wp_get_custom_css();
$new = str_ireplace( array_keys( $hex_map ), array_values( $hex_map ), $css );
if ( $new !== $css ) {
	WP_CLI::log( 'custom css: updated' );
	if ( $apply ) {
		wp_update_custom_css_post( $new );
	}
}

WP_CLI::success( $apply ? 'Deep red applied.' : 'Dry run done.' );
