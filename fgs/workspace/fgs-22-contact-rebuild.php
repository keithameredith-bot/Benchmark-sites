<?php
/**
 * fgs-22-contact-rebuild.php — Contact page (94) becomes a proper contact page in the
 * homepage design language: maroon torn hero (via generic template CSS), info card grid,
 * embedded map, message form, free-quote cross-link. Quote-hunting traffic now goes to
 * /free-quote/; this page is for reaching the office.
 * Backs up old content to _contact-94-old.html. Idempotent. Usage: wp eval-file fgs-22-contact-rebuild.php
 */

$p = get_post( 94 );
if ( false !== strpos( $p->post_content, 'fgs-contact-grid' ) ) {
	WP_CLI::success( 'Contact already rebuilt.' );
	return;
}
file_put_contents( 'C:/Users/keith/Desktop/fgs-workspace/_contact-94-old.html', $p->post_content );

$content = <<<'HTML'
<!-- wp:kadence/rowlayout {"uniqueID":"94_hero-r1","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_cthero_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_cthero_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">OCALA OFFICE · SERVING ALL 67 FLORIDA COUNTIES</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">Contact Florida Geotechnical Services</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">Call, email, or stop by the office. If you're after pricing, the fastest route is a <a href="/free-quote/" style="color:#f0e5e5;text-decoration:underline">free quote request</a> — it goes straight to an engineer.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"32px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:32px"><!-- wp:button {"style":{"color":{"background":"#a91513","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="tel:+13526199292" style="border-radius:8px;color:#ffffff;background-color:#a91513;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Call (352) 619-9292</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px","width":"2px","color":"#2d2d2d"},"spacing":{"padding":{"top":"12px","right":"30px","bottom":"12px","left":"30px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color has-background has-border-color has-custom-font-size wp-element-button" href="https://maps.google.com/?q=302+SW+33rd+Ave+Ocala+FL+34474" target="_blank" rel="noopener" style="border-color:#2d2d2d;border-width:2px;border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:12px;padding-right:30px;padding-bottom:12px;padding-left:30px;font-size:16px;font-weight:700">Get Directions →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"94_info-r2","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[48,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_ctinfo_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_ctinfo_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div class="fgs-contact-grid fgs-why-grid" style="max-width:1100px">
  <div class="fgs-why-card"><h3>Phone</h3><p><a href="tel:+13526199292"><strong>(352) 619-9292</strong></a><br>Mon–Fri, 8:00am–5:00pm ET. After-hours messages are returned promptly.</p></div>
  <div class="fgs-why-card"><h3>Email</h3><p><a href="mailto:rtownsend@fgsfl.net"><strong>rtownsend@fgsfl.net</strong></a><br>Plans, scopes, and bid sets welcome — attach what you have.</p></div>
  <div class="fgs-why-card"><h3>Office</h3><p><strong>302 SW 33rd Ave, Ocala, FL 34474</strong><br>Lab and dispatch under the same roof.</p></div>
  <div class="fgs-why-card"><h3>Service Area</h3><p><strong>All 67 Florida counties</strong><br>Concentrated in Marion, Alachua, Citrus, Sumter, Lake, Hernando, and the I-75 corridor.</p></div>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"94_map-r3","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[24,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_ctmap_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_ctmap_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
<div style="max-width:1100px;margin:0 auto;border-radius:20px;overflow:hidden;box-shadow:0 14px 36px rgba(45,45,45,0.12);border:1px solid #ece7e4">
  <iframe src="https://www.google.com/maps?q=302+SW+33rd+Ave,+Ocala,+FL+34474&output=embed" width="100%" height="380" style="border:0;display:block" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="FGS office — 302 SW 33rd Ave, Ocala, FL"></iframe>
</div>
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"94_form-r4","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[24,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_ctform_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_ctform_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#fbfbfb"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"48px","right":"44px","bottom":"48px","left":"44px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#fbfbfb;padding-top:48px;padding-right:44px;padding-bottom:48px;padding-left:44px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"30px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"10px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:0;margin-bottom:10px;font-size:30px;font-weight:800">Send Us a Message</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"15px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:15px;line-height:1.6">General questions, records requests, or anything that isn't a quote. Need pricing? Use the <a href="/free-quote/" style="color:#a91513">free quote form</a> instead — it captures the project details we need.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[wpforms id="367" title="false"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->
HTML;

$r = wp_update_post( array( 'ID' => 94, 'post_content' => wp_slash( $content ) ), true );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( $r->get_error_message() );
}
WP_CLI::success( 'Contact page rebuilt (old content backed up to _contact-94-old.html).' );
