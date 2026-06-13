<?php
/**
 * fgs-32-blog-head-home.php — Keith 2026-06-12:
 * 1. /blog/ archive header -> full-bleed maroon torn band (overlay header like other pages),
 *    big white title; post cards get the system card treatment everywhere (.loop-entry).
 * 2. Single-post header polish (title scale, meta, featured image crop).
 * 3. Homepage "From the Blog" section (latest 3 via kadence/posts) before the final CTA.
 * Idempotent. Usage: wp eval-file fgs-32-blog-head-home.php
 */

// ---------- CSS ----------
$ms  = '/* fgs-bloghead:start */';
$me  = '/* fgs-bloghead:end */';
$new = <<<'CSS'
/* — Blog archive: maroon torn hero band — */
.blog #masthead{position:absolute;top:0;left:0;right:0;z-index:100;background:transparent}
.blog .content-area{margin-top:24px !important}
.blog .entry-hero.post-archive-hero-section{
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
  max-width:none !important;
  width:auto;
  background:
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) center bottom/100% clamp(32px,4vw,76px) no-repeat,
    radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,0.12),transparent 60%),
    linear-gradient(180deg,#7a0c0e 0%,#4a0404 55%,#2e0000 100%) !important;
  padding:160px 24px 104px;
}
.blog .entry-hero-container-inner{background:transparent !important}
.blog .entry-hero .entry-header{min-height:0}
/* Kadence renders the archive title AS h1.page-title (not nested) — cover both shapes */
.blog .page-title,
.blog h1.page-title,
.blog .page-title h1{
  color:#ffffff !important;font-size:52px !important;font-weight:800 !important;
  text-align:center;line-height:1.1;
  text-shadow:0 2px 12px rgba(0,0,0,0.25);
}
.blog .entry-hero .entry-header{min-height:0;display:block}
@media (max-width:767px){
  .blog .entry-hero.post-archive-hero-section{padding:128px 18px 78px}
  .blog .page-title,.blog h1.page-title{font-size:34px !important}
}
/* — Post cards (archive + homepage feed) — */
.loop-entry{border-radius:18px;overflow:hidden;border:1px solid #ece7e4;box-shadow:0 4px 18px rgba(0,0,0,0.04);transition:transform .2s ease,box-shadow .2s ease}
.loop-entry:hover{transform:translateY(-4px);box-shadow:0 14px 32px rgba(96,0,0,0.09)}
.loop-entry .post-thumbnail img{aspect-ratio:16/9;object-fit:cover;width:100%}
.loop-entry .entry-title{font-size:20px;line-height:1.3}
.loop-entry .entry-title a{color:#2d2d2d}
.loop-entry .entry-title a:hover{color:#a91513}
/* — Single post header — */
.single-post .entry-header{max-width:780px;margin-left:auto;margin-right:auto}
.single-post .entry-title{font-size:40px;line-height:1.15;font-weight:800;color:#2d2d2d}
.single-post .entry-meta{color:#676767;font-size:14px;font-weight:600}
.single-post .article .post-thumbnail img,.single-post .entry-content-wrap > .post-thumbnail img{border-radius:18px;aspect-ratio:2/1;object-fit:cover;width:100%}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'blog header CSS written.' );

// ---------- homepage blog feed ----------
$p = get_post( 90 );
if ( false !== strpos( $p->post_content, 'kadence/posts' ) ) {
	WP_CLI::log( 'homepage blog feed already present.' );
} else {
	$anchor = '<!-- wp:kadence/rowlayout {"uniqueID":"90_e0a813-cc"';
	$pos    = strpos( $p->post_content, $anchor );
	if ( false === $pos ) {
		WP_CLI::error( 'CTA row anchor not found on homepage.' );
	}
	$section = '<!-- wp:kadence/rowlayout {"uniqueID":"90_blgf01-aa","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[48,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_hpblog_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_hpblog_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-process-header">
  <span class="kicker">From the Blog</span>
  <h2>Straight Answers About Florida Ground</h2>
  <p>Costs, sinkholes, soils, and what the data actually says &mdash; written by the people doing the work.</p>
</div>
<!-- /wp:html -->

<!-- wp:kadence/posts {"uniqueID":"90_blgp01-aa","postsToShow":3,"columns":3,"kbVersion":2} /-->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:28px"><!-- wp:button {"className":"is-style-outline","style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px","width":"2px","color":"#2d2d2d"},"spacing":{"padding":{"top":"12px","right":"30px","bottom":"12px","left":"30px"}},"typography":{"fontSize":"15px","fontWeight":"700"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color has-background has-border-color has-custom-font-size wp-element-button" href="/blog/" style="border-color:#2d2d2d;border-width:2px;border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:12px;padding-right:30px;padding-bottom:12px;padding-left:30px;font-size:15px;font-weight:700">View All Posts →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

';
	$new_c = substr( $p->post_content, 0, $pos ) . $section . substr( $p->post_content, $pos );
	$r     = wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $new_c ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( 'homepage "From the Blog" section inserted before final CTA.' );
}

WP_CLI::success( 'Blog header + homepage feed done.' );
