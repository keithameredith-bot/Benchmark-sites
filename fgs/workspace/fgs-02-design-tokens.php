<?php
/**
 * fgs-02-design-tokens.php — Phase 1: adopt live-site design tokens.
 *
 * 1. Kadence global palette  -> live-site colors (#c63a3a accent, #2d2d2d charcoal, off-whites)
 * 2. heading_font/base_font  -> Urbanist (Google font, locally hosted via Perfmatters later)
 * 3. Additional CSS          -> same color swap + append iOS Safari gradient-overlay fix (marker-guarded)
 * 4. post_content inline hex -> #c8102e>#c63a3a, #1a1a1a>#2d2d2d, #f5f5f5>#f3f3f3, #e8e8e3>#f0e5e5
 *
 * Dry run (default):  wp eval-file fgs-02-design-tokens.php   — reports only, writes nothing
 * Apply:              FGS_APPLY=1 wp eval-file fgs-02-design-tokens.php
 * Idempotent: re-running after apply reports zero pending changes.
 */

$apply = (bool) getenv( 'FGS_APPLY' );
WP_CLI::log( $apply ? '== APPLY MODE ==' : '== DRY RUN (set FGS_APPLY=1 to write) ==' );

// ---------- 1. Global palette ----------
$palette_map = array(
	'palette1' => '#c63a3a', // accent red (live token)
	'palette2' => '#a93232', // darker red (hover)
	'palette3' => '#2d2d2d', // headings / charcoal
	'palette4' => '#454545', // body text
	'palette5' => '#676767', // secondary text (live gray)
	'palette6' => '#adadad', // subtle / borders (live gray)
	'palette7' => '#f3f3f3', // section bg (live)
	'palette8' => '#fbfbfb', // lighter bg (live)
	'palette9' => '#ffffff',
);
$raw = get_option( 'kadence_global_palette' );
$dec = json_decode( $raw, true );
if ( ! is_array( $dec ) || empty( $dec['palette'] ) ) {
	WP_CLI::error( 'Could not decode kadence_global_palette.' );
}
$palette_changes = 0;
foreach ( $dec['palette'] as &$entry ) {
	if ( isset( $palette_map[ $entry['slug'] ] ) && strtolower( $entry['color'] ) !== $palette_map[ $entry['slug'] ] ) {
		WP_CLI::log( "palette: {$entry['slug']} {$entry['color']} -> {$palette_map[ $entry['slug'] ]}" );
		$entry['color'] = $palette_map[ $entry['slug'] ];
		$palette_changes++;
	}
}
unset( $entry );
if ( $palette_changes && $apply ) {
	update_option( 'kadence_global_palette', wp_json_encode( $dec ) );
	WP_CLI::log( '-> palette WRITTEN' );
}

// ---------- 2. Fonts -> Urbanist ----------
foreach ( array( 'heading_font', 'base_font' ) as $mod_key ) {
	$mod = get_theme_mod( $mod_key );
	if ( ! is_array( $mod ) ) {
		WP_CLI::warning( "theme mod {$mod_key} missing — skipping." );
		continue;
	}
	if ( 'Urbanist' !== ( $mod['family'] ?? '' ) ) {
		WP_CLI::log( "{$mod_key}: {$mod['family']} -> Urbanist" );
		$mod['family']   = 'Urbanist';
		$mod['google']   = true;
		$mod['fallback'] = 'sans-serif';
		if ( $apply ) {
			set_theme_mod( $mod_key, $mod );
			WP_CLI::log( '-> WRITTEN' );
		}
	} else {
		WP_CLI::log( "{$mod_key}: already Urbanist." );
	}
}

// ---------- 3. Additional CSS ----------
$hex_map = array(
	'#c8102e' => '#c63a3a',
	'#1a1a1a' => '#2d2d2d',
	'#f5f5f5' => '#f3f3f3',
	'#e8e8e3' => '#f0e5e5',
);
$ios_marker = '/* fgs-ios-gradient-fix */';
$ios_fix    = $ios_marker . '
@media (max-width: 1024px) {
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) .kt-row-layout-overlay {
    display: none !important;
  }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) { position: relative; }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient)::after {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.15) 100%);
    pointer-events: none; z-index: 1;
  }
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) > .kt-row-column-wrap,
  .wp-block-kadence-rowlayout:has(.kt-row-overlay-gradient) > .kb-row-layout-wrap {
    position: relative; z-index: 2;
  }
}';
$css     = (string) wp_get_custom_css();
$new_css = str_ireplace( array_keys( $hex_map ), array_values( $hex_map ), $css );
$css_n   = 0;
foreach ( $hex_map as $from => $to ) {
	$css_n += substr_count( strtolower( $css ), $from );
}
if ( false === strpos( $new_css, $ios_marker ) ) {
	$new_css .= "\n\n" . $ios_fix . "\n";
	WP_CLI::log( 'custom css: will append iOS gradient fix.' );
}
if ( $new_css !== $css ) {
	WP_CLI::log( "custom css: {$css_n} hex replacements pending." );
	if ( $apply ) {
		$r = wp_update_custom_css_post( $new_css );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( 'custom css update failed: ' . $r->get_error_message() );
		}
		WP_CLI::log( '-> custom css WRITTEN' );
	}
} else {
	WP_CLI::log( 'custom css: no changes needed.' );
}

// ---------- 4. Content hex swap (skips placehold.co URLs: only replaces values with leading #) ----------
global $wpdb;
$ids   = $wpdb->get_col(
	"SELECT ID FROM {$wpdb->posts}
	 WHERE post_type IN ('page','post','wp_block','kadence_element')
	   AND post_status IN ('publish','draft')"
);
$total = 0;
foreach ( $ids as $id ) {
	$post    = get_post( $id );
	$content = $post->post_content;
	$new     = str_ireplace( array_keys( $hex_map ), array_values( $hex_map ), $content );
	if ( $new === $content ) {
		continue;
	}
	$n = 0;
	foreach ( $hex_map as $from => $to ) {
		$n += substr_count( strtolower( $content ), $from );
	}
	$total += $n;
	WP_CLI::log( "content {$id} ({$post->post_title}): {$n} replacements" );
	if ( $apply ) {
		$r = wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $new ) ), true );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( "update failed on {$id}: " . $r->get_error_message() );
		}
	}
}
WP_CLI::log( "content totals: {$total} hex replacements across pages." );

WP_CLI::success( $apply ? 'Design tokens APPLIED.' : 'Dry run complete — nothing written.' );
