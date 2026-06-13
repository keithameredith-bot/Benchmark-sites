<?php
/**
 * fgs-34-mission-buttons.php — Keith 2026-06-12:
 * 1. Our Mission page (96) rebuilt from the live site's About copy in our design system:
 *    maroon torn hero -> mission prose -> dark torn "Driven Different" band (2 cards) ->
 *    "Our Work" 3-card grid -> "Let's Build on Solid Ground" shine CTA.
 * 2. Sitewide button hover polish: every button gets a real hover color change + lift.
 * Backs up old 96 content. Idempotent. Usage: wp eval-file fgs-34-mission-buttons.php
 */

$p = get_post( 96 );
if ( false === strpos( $p->post_content, 'fgs-mission-built' ) ) {
	file_put_contents( 'C:/Users/keith/Desktop/fgs-workspace/_mission-96-old.html', $p->post_content );

	$content = <<<'HTML'
<!-- wp:html --><!-- fgs-mission-built --><!-- /wp:html -->
<!-- wp:kadence/rowlayout {"uniqueID":"96_hero-r1","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_msnhero_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_msnhero_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">OUR MISSION</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">Committed to Precision, Backed by Experience</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">Reliable, certified testing and geotechnical engineering that supports safe, efficient construction across Florida. Whether we're drilling on-site, testing materials in our accredited lab, or delivering a stamped report, the goal is always the same: clear, accurate data that keeps your project on track.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"32px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:32px"><!-- wp:button {"style":{"color":{"background":"#a91513","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="tel:+13526199292" style="border-radius:8px;color:#ffffff;background-color:#a91513;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Call (352) 619-9292</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px","width":"2px","color":"#2d2d2d"},"spacing":{"padding":{"top":"12px","right":"30px","bottom":"12px","left":"30px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color has-background has-border-color has-custom-font-size wp-element-button" href="/free-quote/" style="border-color:#2d2d2d;border-width:2px;border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:12px;padding-right:30px;padding-bottom:12px;padding-left:30px;font-size:16px;font-weight:700">Get a Free Quote →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"96_lede-r2","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[48,"",32,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_msnlede_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_msnlede_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontSize":"20px","lineHeight":"1.65"},"color":{"text":"#2d2d2d"}}} -->
<p class="has-text-color" style="color:#2d2d2d;font-size:20px;line-height:1.65">We work closely with contractors, developers, engineers, and municipalities — bringing deep technical knowledge and field experience to every project, large or small. You don't need another vendor. You need a reliable partner who knows what to look for and how to deliver it.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"96_drvn-r3","columns":1,"colLayout":"equal","bgColor":"#2d2d2d","align":"full","padding":[0,"",0,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignfull"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_msndrvn_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_msndrvn_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-process-header fgs-on-dark">
  <span class="kicker">Driven Different</span>
  <h2>Experience Earned in the Field</h2>
</div>
<div class="fgs-split">
  <div class="fgs-split-card"><h3>Proven Where It Matters</h3><p>The expertise we bring today comes from time spent solving real problems on real job sites. Some things you can only learn by doing — by showing up, troubleshooting in the moment, and learning from every outcome.</p></div>
  <div class="fgs-split-card"><h3>Knowledge That Performs</h3><p>Over the years, we've trained, tested, and refined our methods to meet the demands of Florida's unique soil conditions and strict building standards. It's not just about knowing the science. It's about applying it when timing, safety, and accuracy are on the line.</p></div>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"96_work-r4","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[56,"",32,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_msnwork_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_msnwork_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-process-header">
  <span class="kicker">Our Work</span>
  <h2>How We Support Your Project</h2>
</div>
<div class="fgs-why-grid">
  <div class="fgs-why-card"><h3>Complete Geotechnical Solutions</h3><p>A full range of geotechnical services — soil evaluations, drilling, and certified construction materials testing — all backed by our FDOT &amp; CMEC accredited in-house lab.</p></div>
  <div class="fgs-why-card"><h3>Your Partner in Getting It Done</h3><p>That's how we help contractors meet deadlines, developers keep timelines intact, and municipalities ensure public safety without overruns.</p></div>
  <div class="fgs-why-card"><h3>Simple Process. Solid Results.</h3><p>From the initial site investigation to final lab reports, we work quickly and clearly so you can move forward without delays or guesswork: accurate data, clear communication, responsive people.</p></div>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"96_cta-r5","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[16,"",64,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_msncta_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_msncta_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"className":"fgs-cta","style":{"color":{"background":"#ffffff"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"56px","right":"48px","bottom":"56px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group fgs-cta has-background" style="border-radius:24px;background-color:#ffffff;padding-top:56px;padding-right:48px;padding-bottom:56px;padding-left:48px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"36px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"16px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;margin-top:0;margin-bottom:16px;font-size:36px;font-weight:800">Let's Build on Solid Ground</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#adadad"},"typography":{"fontSize":"17px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#adadad;font-size:17px;line-height:1.6">If you need accurate results, fast turnaround, and a team that's ready to get to work, we're here to help. Let's talk about your next project.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:28px"><!-- wp:button {"style":{"color":{"background":"#a91513","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="/free-quote/" style="border-radius:8px;color:#ffffff;background-color:#a91513;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Get a Free Quote</a></div>
<!-- /wp:button -->

<!-- wp:button {"style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="tel:+13526199292" style="border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Call (352) 619-9292</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->
HTML;

	$r = wp_update_post( array( 'ID' => 96, 'post_content' => wp_slash( $content ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( 'Mission page rebuilt (old content backed up).' );
} else {
	WP_CLI::log( 'Mission page already rebuilt.' );
}

// AIOSEO desc refresh
global $wpdb;
$aio = $wpdb->prefix . 'aioseo_posts';
$wpdb->update( $aio, array(
	'title'       => 'Our Mission | Committed to Precision | FGS Florida',
	'description' => "Reliable, certified geotechnical testing and engineering across Florida. Clear, accurate data that keeps your project on track. Let's build on solid ground.",
), array( 'post_id' => 96 ) );

// ---------- CSS: dark band tears for 96_drvn-r3 + on-dark header + button hovers ----------
$ms  = '/* fgs-mission:start */';
$me  = '/* fgs-mission:end */';
$new = <<<'CSS'
/* — Mission "Driven Different" dark torn band — */
.kb-row-layout-id96_drvn-r3{
  background-image:
    url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp),
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) !important;
  background-position:center top,center bottom !important;
  background-size:100% clamp(36px,4.5vw,84px),100% clamp(32px,4vw,76px) !important;
  background-repeat:no-repeat,no-repeat !important;
}
.kb-row-layout-id96_drvn-r3 > .kt-row-column-wrap{padding-top:120px !important;padding-bottom:120px !important}
.fgs-process-header.fgs-on-dark h2{color:#ffffff}
.fgs-process-header.fgs-on-dark p{color:#adadad}

/* — Button hover system: every button changes color + lifts — */
.wp-block-button__link{transition:background-color .2s ease,color .2s ease,border-color .2s ease,transform .15s ease,box-shadow .2s ease !important}
/* solid maroon -> deep maroon */
.wp-block-button__link[style*="background-color:#a91513"]:hover{background-color:#7c0e0d !important;transform:translateY(-2px);box-shadow:0 12px 26px rgba(96,0,0,0.32) !important}
/* white buttons (on dark panels) -> sand */
.fgs-cta .wp-block-button__link[style*="background-color:#ffffff"]:hover,
.wp-block-group.has-background:has(h1) .wp-block-button__link[style*="background-color:#ffffff"]:hover{background-color:#f3efe8 !important;transform:translateY(-2px)}
/* charcoal outline -> fills charcoal */
.wp-block-button.is-style-outline .wp-block-button__link[style*="border-color:#2d2d2d"]:hover{background-color:#2d2d2d !important;color:#ffffff !important;transform:translateY(-2px)}
/* blog + quote helpers lift too */
.fgs-blog-cta > a:hover,.fgs-f-directions:hover,.fgs-hq-btn:hover{transform:translateY(-2px)}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'mission band + button hover CSS written.' );

WP_CLI::success( 'Mission page + button hovers done.' );
