<?php
/**
 * fgs-21-free-quote.php — Conversion path split (Keith 2026-06-12):
 * 1. Create /free-quote/ landing page: hero, benefit cards, form card (WPForms 367),
 *    what-happens-next steps, call strip. Published (Keith is iterating live).
 * 2. All quote CTAs sitewide (-> /contact/) now point to /free-quote/.
 * 3. Header gets a second button: "Get a Free Quote" (outline) next to Call Now,
 *    via Kadence header html element.
 * Idempotent. Usage: wp eval-file fgs-21-free-quote.php
 */

// ---------- 1. landing page ----------
$existing = get_page_by_path( 'free-quote', OBJECT, 'page' );
if ( $existing ) {
	$quote_id = $existing->ID;
	WP_CLI::log( "free-quote page exists (ID {$quote_id})." );
} else {
	$content = <<<'HTML'
<!-- wp:kadence/rowlayout {"uniqueID":"fq_hero-r1","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_fqhero_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_fqhero_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">NO OBLIGATION · RESPONSE FROM AN ENGINEER, NOT A CALL CENTER</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">Get a Free Quote</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">Tell us what you're building and where. We'll come back with a clear scope and a real number — no pressure, no spam, no handing your info to anyone else.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"fq_body-r2","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[40,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_fqbody_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_fqbody_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-why-grid" style="max-width:1100px">
  <div class="fgs-why-card"><h3>Stamped by a Florida P.E.</h3><p>Every report we deliver is signed and sealed engineering your lender, insurer, and building department can act on.</p></div>
  <div class="fgs-why-card"><h3>In-House Accredited Lab</h3><p>FDOT &amp; CMEC accredited. Samples never wait in a shipping queue, so your quote timeline is the real timeline.</p></div>
  <div class="fgs-why-card"><h3>All 67 Counties</h3><p>Ocala-based crews covering the entire state — residential, commercial, and FDOT work.</p></div>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"fq_form-r3","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[16,"",40,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_fqform_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_fqform_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"className":"fgs-quote-form","style":{"color":{"background":"#fbfbfb"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"48px","right":"44px","bottom":"48px","left":"44px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group fgs-quote-form has-background" style="border-radius:24px;background-color:#fbfbfb;padding-top:48px;padding-right:44px;padding-bottom:48px;padding-left:44px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"30px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"10px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:0;margin-bottom:10px;font-size:30px;font-weight:800">Tell Us About Your Project</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"15px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:15px;line-height:1.6">Property address, what you're building or what's worrying you, and any deadline you're working against. The more we know, the tighter the quote.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[wpforms id="367" title="false"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"fq_steps-r4","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[16,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_fqsteps_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_fqsteps_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-steps-panel">
  <div class="fgs-process-header" style="margin-bottom:32px">
    <span class="kicker">What Happens Next</span>
    <h2>Three Steps, No Runaround</h2>
  </div>
  <ol class="fgs-steps">
    <li><div class="fgs-step-num">1</div><div class="fgs-step-body"><h3>We review your project</h3><p>An engineer looks at your site, scope, and county — not a sales rep reading a script.</p></div></li>
    <li><div class="fgs-step-num">2</div><div class="fgs-step-body"><h3>You get a clear quote</h3><p>Scope, price, and schedule in plain language, including what's not included and why.</p></div></li>
    <li><div class="fgs-step-num">3</div><div class="fgs-step-body"><h3>Fieldwork gets scheduled</h3><p>Once you give the go, the rig and crew get on the calendar — and the lab is ours, so results don't wait in line.</p></div></li>
  </ol>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"fq_cta-r5","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[8,"",64,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_fqcta_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_fqcta_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"17px"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:17px">Rather talk it through? Call <a href="tel:+13526199292" style="color:#a91513"><strong>(352) 619-9292</strong></a> — Mon–Fri, 8am–5pm.</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->
HTML;

	$quote_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Get a Free Quote',
			'post_name'    => 'free-quote',
			'post_content' => wp_slash( $content ),
		),
		true
	);
	if ( is_wp_error( $quote_id ) ) {
		WP_CLI::error( $quote_id->get_error_message() );
	}
	WP_CLI::log( "free-quote page created (ID {$quote_id})." );
}

// AIOSEO meta
global $wpdb;
$aio = $wpdb->prefix . 'aioseo_posts';
$row = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM {$aio} WHERE post_id = %d", $quote_id ) );
$t   = 'Get a Free Geotechnical Quote | FGS Florida';
$d   = 'Free, no-obligation quote for geotechnical engineering, soil testing, sinkhole investigation, or materials testing anywhere in Florida. (352) 619-9292.';
if ( $row ) {
	$wpdb->update( $aio, array( 'title' => $t, 'description' => $d ), array( 'post_id' => $quote_id ) );
} else {
	$wpdb->insert( $aio, array( 'post_id' => $quote_id, 'title' => $t, 'description' => $d, 'created' => current_time( 'mysql' ), 'updated' => current_time( 'mysql' ) ) );
}
WP_CLI::log( 'free-quote AIOSEO meta set.' );

// ---------- 2. CTA rewiring: quote buttons -> /free-quote/ ----------
$pages = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type='page' AND post_status IN ('publish','draft') AND post_content LIKE '%/contact/%' AND ID != 94" );
$total = 0;
foreach ( $pages as $pid ) {
	if ( (int) $pid === (int) $quote_id ) {
		continue;
	}
	$p   = get_post( $pid );
	$new = preg_replace( '#(<a[^>]*href=")/contact/("[^>]*>(?:(?!</a>)[\s\S])*?Quote)#', '$1/free-quote/$2', $p->post_content, -1, $n );
	if ( $n ) {
		wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $new ) ), true );
		WP_CLI::log( "  {$pid} ({$p->post_title}): {$n} quote CTA(s) -> /free-quote/" );
		$total += $n;
	}
}
WP_CLI::log( "CTA rewiring: {$total} links updated." );

// ---------- 3. header second button ----------
$items = get_theme_mod( 'header_desktop_items' );
if ( is_array( $items ) && ! in_array( 'html', $items['main']['main_right'], true ) ) {
	$items['main']['main_right'] = array( 'navigation', 'html', 'button' );
	set_theme_mod( 'header_desktop_items', $items );
	WP_CLI::log( 'header: html slot added to main_right.' );
} else {
	WP_CLI::log( 'header: html slot already present.' );
}
set_theme_mod( 'header_html_content', '<a class="fgs-hq-btn" href="/free-quote/">Get a Free Quote</a>' );
set_theme_mod( 'header_html_wpautop', false );

// button style
$ms2 = '/* fgs-hq-btn:start */';
$me2 = '/* fgs-hq-btn:end */';
$bcss = <<<'CSS'
#masthead .header-html{display:flex;align-items:center}
.fgs-hq-btn{
  display:inline-block;padding:9px 20px;border:2px solid #a91513;border-radius:10px;
  color:#a91513 !important;font-weight:800;font-size:15px;text-decoration:none;
  transition:background .2s ease,color .2s ease;white-space:nowrap;margin-right:10px;
}
.fgs-hq-btn:hover{background:#a91513;color:#ffffff !important}
@media (max-width:1240px){.fgs-hq-btn{display:none}}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms2, '#' ) . '.*?' . preg_quote( $me2, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms2 . "\n" . $bcss . "\n" . $me2 . "\n";
wp_update_custom_css_post( $css );
WP_CLI::log( 'header quote button styled.' );

WP_CLI::success( 'Free-quote funnel live.' );
