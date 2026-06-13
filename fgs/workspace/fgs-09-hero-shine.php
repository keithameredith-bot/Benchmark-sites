<?php
/**
 * fgs-09-hero-shine.php — Black Rock-style hero treatment in FGS logo reds.
 * Recipe from black-rock-mortgage .brm-hero: deep vertical brand gradient + radial glow
 * top-right + inset top highlight + lifted shadow + glassy outline buttons.
 *
 * EXEMPLAR MODE (default): styles ONLY the Foundation Engineering page (page-id-269)
 * so Keith can review one page before sitewide rollout.
 * Rollout: FGS_SCOPE=all wp eval-file fgs-09-hero-shine.php
 * Idempotent: replaces its own marker block on every run.
 */

$scope_env = getenv( 'FGS_SCOPE' );
$prefix    = ( 'all' === $scope_env ) ? '' : '.page-id-269 ';
$label     = ( '' === $prefix ) ? 'SITEWIDE' : 'EXEMPLAR (page 269 only)';

$start_marker = '/* fgs-deep-red-hero:start */';
$end_marker   = '/* fgs-deep-red-hero:end */';

$tpl = '
{S}.wp-block-group.has-background:has(h1) {
  background:
    radial-gradient(120% 120% at 85% -10%, rgba(255,255,255,0.12), transparent 60%),
    linear-gradient(180deg, #7a0c0e 0%, #4a0404 55%, #2e0000 100%) !important;
  box-shadow:
    0 26px 60px -22px rgba(40,0,0,0.55),
    inset 0 2px 0 0 rgba(255,255,255,0.18);
  position: relative;
  overflow: hidden;
}
{S}.wp-block-group.has-background:has(h1) h1 {
  color: #ffffff !important;
  text-shadow: 0 2px 12px rgba(0,0,0,0.25);
}
{S}.wp-block-group.has-background:has(h1) p {
  color: rgba(255,255,255,0.92) !important;
}
{S}.wp-block-group.has-background:has(h1) p[style*="letter-spacing:2px"] {
  color: rgba(255,255,255,0.72) !important;
}
{S}.wp-block-group.has-background:has(h1) .wp-block-button:not(.is-style-outline) .wp-block-button__link {
  background: #ffffff !important;
  color: #5c0606 !important;
  box-shadow: 0 12px 30px rgba(0,0,0,0.28);
}
{S}.wp-block-group.has-background:has(h1) .wp-block-button:not(.is-style-outline) .wp-block-button__link:hover {
  background: #f0e5e5 !important;
}
{S}.wp-block-group.has-background:has(h1) .wp-block-button:not(.is-style-outline) .wp-block-button__link svg {
  fill: #7c0e0d;
}
{S}.wp-block-group.has-background:has(h1) .wp-block-button.is-style-outline .wp-block-button__link {
  background: rgba(255,255,255,0.08) !important;
  color: #ffffff !important;
  border-color: rgba(255,255,255,0.72) !important;
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
}
{S}.wp-block-group.has-background:has(h1) .wp-block-button.is-style-outline .wp-block-button__link:hover {
  background: rgba(255,255,255,0.18) !important;
}
{S}.wp-block-group.has-background[style*="background-color:#2d2d2d"] {
  background:
    radial-gradient(120% 120% at 85% -10%, rgba(255,255,255,0.08), transparent 60%),
    linear-gradient(180deg, #6e0a0c 0%, #400303 55%, #270000 100%) !important;
  box-shadow:
    0 22px 50px -20px rgba(40,0,0,0.5),
    inset 0 2px 0 0 rgba(255,255,255,0.15);
}
{S}.wp-block-group.has-background[style*="background-color:#2d2d2d"] p {
  color: rgba(255,255,255,0.88) !important;
}
{S}.wp-block-group.has-background[style*="background-color:#2d2d2d"] .wp-block-button .wp-block-button__link[style*="background-color:#a91513"] {
  background: #ffffff !important;
  color: #5c0606 !important;
}
';

$block = $start_marker . "\n/* mode: {$label} */" . str_replace( '{S}', $prefix, $tpl ) . $end_marker;

$css = (string) wp_get_custom_css();

// Remove any previous version of our block (old single-marker format too).
$css = preg_replace( '#/\* fgs-deep-red-hero:start \*/.*?/\* fgs-deep-red-hero:end \*/#s', '', $css );
$css = preg_replace( '#/\* fgs-deep-red-hero \*/.*\z#s', '', $css, 1 ); // old format was appended at EOF
$css = rtrim( $css );

$r = wp_update_custom_css_post( $css . "\n\n" . $block . "\n" );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS update failed: ' . $r->get_error_message() );
}
WP_CLI::success( "Hero shine CSS written in {$label} mode." );
