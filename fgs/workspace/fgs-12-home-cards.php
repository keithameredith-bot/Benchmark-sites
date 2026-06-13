<?php
/**
 * fgs-12-home-cards.php — Keith 2026-06-12:
 * 1. Beautify the info cards (Kadence infoboxes — homepage value props + 9-service grid,
 *    same treatment on service-page infobox rows): card surface, blush icon chip,
 *    maroon hover lift. Pure CSS, no content edits.
 * 2. Add a second dark section to the homepage — a charcoal stats band between the
 *    services grid and Recent Projects, matching the "What Sets Us Apart" row he likes.
 *    All stats are truth-audit-safe claims already published on the site.
 * Idempotent. Usage: wp eval-file fgs-12-home-cards.php
 */

// ---------- 1. stats band row on homepage ----------
$post    = get_post( 90 );
$content = $post->post_content;
if ( false !== strpos( $content, 'fgs-stats' ) ) {
	WP_CLI::log( 'stats band: already present — skip.' );
} else {
	$anchor = '<!-- wp:kadence/rowlayout {"uniqueID":"90_ea8191-8d"';
	$pos    = strpos( $content, $anchor );
	if ( false === $pos ) {
		WP_CLI::error( 'Recent Projects row anchor not found.' );
	}
	$band = '<!-- wp:kadence/rowlayout {"uniqueID":"90_57a751-f5","columns":1,"colLayout":"equal","bgColor":"#2d2d2d","align":"full","padding":[0,"",0,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignfull"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_hpstats_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_hpstats_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-stats">
  <div class="fgs-stats__inner">
    <div class="fgs-stat"><span class="fgs-stat__n">67</span><span class="fgs-stat__l">Florida counties served</span></div>
    <div class="fgs-stat"><span class="fgs-stat__n">5&ndash;7 Days</span><span class="fgs-stat__l">In-house lab turnaround</span></div>
    <div class="fgs-stat"><span class="fgs-stat__n">One Roof</span><span class="fgs-stat__l">Drilling, lab &amp; stamped reports</span></div>
    <div class="fgs-stat"><span class="fgs-stat__n">2023</span><span class="fgs-stat__l">Founded in Ocala, built for Florida</span></div>
  </div>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

';
	$content = substr( $content, 0, $pos ) . $band . substr( $content, $pos );
	$r       = wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $content ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( 'stats band: inserted before Recent Projects.' );
}

// ---------- 2. CSS (marker-replaced) ----------
$ms  = '/* fgs-infobox-cards:start */';
$me  = '/* fgs-infobox-cards:end */';
$new = <<<'CSS'
/* — Infobox cards: surface, blush icon chip, maroon hover — */
/* card rows sit on the same 1180px grid as the services list — no edge-touching */
.kb-row-layout-wrap:has(.wp-block-kadence-infobox) > .kt-row-column-wrap{
  max-width:1180px;margin-left:auto;margin-right:auto;
  padding-left:8px;padding-right:8px;box-sizing:border-box;
}
/* equal heights: stretch the whole column chain down to the card */
.wp-block-kadence-column:has(> .kt-inside-inner-col > .wp-block-kadence-infobox){height:100%}
.wp-block-kadence-column:has(> .kt-inside-inner-col > .wp-block-kadence-infobox) > .kt-inside-inner-col{height:100%;display:flex;flex-direction:column}
.wp-block-kadence-column:has(> .kt-inside-inner-col > .wp-block-kadence-infobox) > .kt-inside-inner-col > .wp-block-kadence-infobox{flex:1;display:flex;flex-direction:column}
.wp-block-kadence-infobox{height:100%}
.wp-block-kadence-infobox .kt-blocks-info-box-link-wrap{flex:1}
.wp-block-kadence-infobox .kt-blocks-info-box-link-wrap{
  display:block;height:100%;box-sizing:border-box;
  background:#fbfbfb;border:1px solid #ece7e4;border-radius:18px;
  padding:34px 28px 30px;
  transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease;
}
.wp-block-kadence-infobox:hover .kt-blocks-info-box-link-wrap{
  transform:translateY(-4px);
  box-shadow:0 14px 32px rgba(96,0,0,.10);
  border-color:#a91513;
}
.wp-block-kadence-infobox .kadence-info-box-icon-container{
  display:inline-flex;align-items:center;justify-content:center;
  width:88px;height:88px;border-radius:50%;background:#f0e5e5;
  margin-bottom:8px;transition:background .2s ease;
}
.wp-block-kadence-infobox:hover .kadence-info-box-icon-container{background:#e9d5d5}
.wp-block-kadence-infobox .kt-blocks-info-box-title{font-size:21px;font-weight:800;color:#2d2d2d;line-height:1.3;margin-top:14px}
.wp-block-kadence-infobox .kt-blocks-info-box-text{font-size:15px;line-height:1.62;color:#555555}
@media (max-width:767px){
  .wp-block-kadence-infobox .kt-blocks-info-box-link-wrap{padding:26px 22px 24px}
  .wp-block-kadence-infobox .kadence-info-box-icon-container{width:72px;height:72px}
}
/* — Dark stats band — */
.fgs-stats{padding:64px 24px;border-top:1px solid rgba(255,255,255,.07);border-bottom:1px solid rgba(255,255,255,.07)}
.fgs-stats__inner{display:grid;grid-template-columns:repeat(4,1fr);gap:36px;max-width:1100px;margin:0 auto}
.fgs-stat{text-align:center}
.fgs-stat__n{display:block;font-size:44px;font-weight:800;color:#ffffff;line-height:1.1;letter-spacing:-.5px}
.fgs-stat__n::after{content:"";display:block;width:36px;height:4px;background:#a91513;border-radius:2px;margin:14px auto 12px}
.fgs-stat__l{display:block;font-size:12.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#adadad;line-height:1.5}
@media (max-width:860px){
  .fgs-stats{padding:44px 20px}
  .fgs-stats__inner{grid-template-columns:repeat(2,1fr);gap:28px}
  .fgs-stat__n{font-size:34px}
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Infobox card + stats band CSS written.' );
