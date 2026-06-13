<?php
/**
 * fgs-24-sand.php — Keith 2026-06-12: blush (#f0e5e5) panels read PINK. Replace the
 * blush surface tone with warm sand (#f3efe8 — manila/report-paper feel) across:
 * steps panels, author cards, kicker chips, dropdown hovers, and the placeholder
 * image tints baked into placehold.co URLs. Maroon accents stay; nothing pink remains.
 * Idempotent. Usage: wp eval-file fgs-24-sand.php
 */

// ---------- CSS overrides ----------
$ms  = '/* fgs-sand:start */';
$me  = '/* fgs-sand:end */';
$new = <<<'CSS'
/* — Warm sand replaces blush on all panel surfaces — */
.fgs-steps-panel{
  background:#f3efe8;
  border:1px solid #e8e1d6;
  box-shadow:inset 0 2px 0 rgba(255,255,255,0.8);
}
.fgs-steps li{border-bottom:1px solid rgba(45,45,45,0.09)}
.fgs-author{background-color:#f3efe8 !important;border-left:6px solid #a91513 !important}
.fgs-svc-kicker{background:#f3efe8;color:#a91513}
.fgs-tm__kicker{background:#f3efe8 !important}
.fgs-why-card p a{color:#a91513}
/* menu dropdown + button hover tints follow */
#masthead .header-navigation ul.sub-menu li a:hover,
#masthead .header-navigation ul.sub-menu li.current-menu-item > a{background:#f3efe8 !important}
.wp-block-kadence-infobox .kadence-info-box-icon-container{background:#f3efe8}
.wp-block-kadence-infobox:hover .kadence-info-box-icon-container{background:#ece4d8}
/* hero buttons that hover to blush now hover to sand */
.wp-block-group.has-background:has(h1) .wp-block-button:not(.is-style-outline) .wp-block-button__link:hover{background:#f3efe8 !important}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::log( 'sand CSS written.' );

// ---------- placeholder image tints: f0e5e5 -> f3efe8 in placehold.co URLs ----------
global $wpdb;
$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type='page' AND post_status IN ('publish','draft') AND post_content LIKE '%placehold.co%f0e5e5%'" );
foreach ( $ids as $id ) {
	$p   = get_post( $id );
	$new = str_replace( 'placehold.co/1200x500/f0e5e5/', 'placehold.co/1200x500/f3efe8/', $p->post_content );
	$new = str_replace( 'placehold.co/726x482/f0e5e5/', 'placehold.co/726x482/f3efe8/', $new );
	$new = str_replace( 'placehold.co/500x500/f0e5e5/', 'placehold.co/500x500/f3efe8/', $new );
	if ( $new !== $p->post_content ) {
		wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $new ) ), true );
		WP_CLI::log( "  {$id} ({$p->post_title}): placeholder tints -> sand" );
	}
}

WP_CLI::success( 'Sand swap complete.' );
