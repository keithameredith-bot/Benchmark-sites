<?php
/**
 * Rebuild our-reviews (101414), contact (97973), thank-you (90829), privacy (101434).
 * Cleanups: contact "fill out of the info" → "fill out the info"; thank-you hours "Sat- Fri" → "Sat – Sun";
 * thank-you set to NOINDEX (conversion page, standard practice). Run: wp eval-file build-utility-pages.php
 */

function jsc_apply_page2( $id, $content, $fullwidth = true ) {
	$r = wp_update_post( array( 'ID' => $id, 'post_content' => $content ), true );
	if ( is_wp_error( $r ) ) { echo "ERR $id: " . $r->get_error_message() . "\n"; return; }
	update_post_meta( $id, '_kad_post_title', 'hide' );
	if ( $fullwidth ) {
		update_post_meta( $id, '_kad_post_layout', 'fullwidth' );
		update_post_meta( $id, '_kad_post_content_style', 'unboxed' );
		update_post_meta( $id, '_kad_post_vertical_padding', 'hide' );
	} else {
		update_post_meta( $id, '_kad_post_layout', 'narrow' );
	}
	echo "OK $id (" . get_post_field( 'post_name', $id ) . ")\n";
}

$info_block = '<h3>JSC Contracting Inc.</h3>
<p>16455 E Hwy 40, Unit 1<br>Silver Springs, FL 34488</p>
<p><a href="tel:3526872030">352.687.2030</a><br><a href="mailto:info@jscfla.com">info@jscfla.com</a></p>
<p><strong>Mon – Fri:</strong> 8:00 am – 4:00 pm<br><strong>Sat – Sun:</strong> By Appointment</p>';

/* ============================== OUR REVIEWS ============================== */
$rev = '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/06/jsc-home-hero-montage.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">See What Our Clients Are Saying</span>
<h1>Our Reviews</h1>
<p class="jsc-sub">We always aim for 5 star service — don\'t just take our word for it.</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="https://g.page/r/CU_afPuU9LllEBM/review" target="_blank" rel="noopener nofollow">LEAVE US A GOOGLE REVIEW</a>
<a class="jsc-btn jsc-btn-ghost" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<div class="jsc-trust">
[bwd_stars]
<span><b>✓</b> 25+ Years Experience</span>
<span><b>✓</b> FL Certified Residential Contractor <b>CRC1332267</b></span>
</div>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
[trustindex no-registration=google]
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jsc-section jsc-warm"} -->
<section class="wp-block-group jsc-section jsc-warm"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<h2>Help Our Business By Leaving a Review</h2>
<p>If we\'ve done work for you, a Google review is the best thank-you we could ask for — it helps your neighbors find a contractor they can trust.</p>
<a class="jsc-btn jsc-btn-gold" href="https://g.page/r/CU_afPuU9LllEBM/review" target="_blank" rel="noopener nofollow">LEAVE US A GOOGLE REVIEW</a>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:html -->
<div class="jsc-cta-band" id="appt">
<h2>Get Your Free Quote Today!</h2>
<p>Call <a class="jsc-tel" href="tel:3526872030">352.687.2030</a> or send us your project details online — we\'ll review your project and get you a free price quote.</p>
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<!-- /wp:html -->';
jsc_apply_page2( 101414, $rev );

/* ============================== CONTACT ============================== */
$contact = '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/06/jsc-home-hero-montage.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Let\'s Get In Touch</span>
<h1>Contact us</h1>
<p class="jsc-sub">Questions, scheduling, existing projects — call during business hours or send us a message. Ready for a price instead? <a href="/get-a-free-quote/" style="color:var(--jsc-gold);font-weight:800">Get a free quote →</a></p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="tel:3526872030">CALL 352.687.2030</a>
</div>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:columns {"className":"jsc-two-col"} -->
<div class="wp-block-columns jsc-two-col"><!-- wp:column {"width":"60%","className":"jsc-copy-col"} -->
<div class="wp-block-column jsc-copy-col" style="flex-basis:60%"><!-- wp:html -->
<h2>Send Us a Message</h2>
<p>We would love to connect with you. If you need to just ask a few questions feel free to <strong>give us a call</strong> during business hours, or drop a message below and the right team member will get back to you. If you\'re looking for a price on a project, the fastest path is our <a href="/get-a-free-quote/">free quote form</a>.</p>
[wpforms id="102170" title="false"]

<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%","className":"jsc-side-col"} -->
<div class="wp-block-column jsc-side-col" style="flex-basis:40%"><!-- wp:html -->
' . $info_block . '
<div class="jsc-map">
<a href="https://maps.google.com/?cid=7330158789233793615" target="_blank" rel="noopener" aria-label="Open JSC Contracting in Google Maps for directions">
<img src="/wp-content/uploads/2026/06/jsc-map-silver-springs.webp" alt="Map showing JSC Contracting at 16455 E Hwy 40, Silver Springs, FL" width="880" height="560" loading="lazy" decoding="async"></a>
<a class="jsc-map-directions" href="https://maps.google.com/?cid=7330158789233793615" target="_blank" rel="noopener">Get Directions &rarr;</a>
</div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->';
jsc_apply_page2( 97973, $contact );

/* ============================== THANK YOU ============================== */
$ty = '<!-- wp:html -->
<div class="jsc-hero">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/02/central-florida-fence-builder.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Success</span>
<h1>Thank you</h1>
<p class="jsc-sub">We will get in touch with you shortly!</p>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p>Thank you for leaving a message with us. Your message will be directed to the team member best able to serve your needs.</p>
' . str_replace( 'By Appointment', 'Closed', $info_block ) . '
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->';
jsc_apply_page2( 90829, $ty );

/* ============================== PRIVACY POLICY ============================== */
// content is already a clean HTML doc inside the old Divi text module — extract, clean, keep its own H1
$page = get_post( 101434 );
$html = '';
foreach ( parse_blocks( $page->post_content ) as $b ) {
	// pull every divi text innerContent
	$stack = array( $b );
	while ( $stack ) {
		$cur = array_pop( $stack );
		$v = $cur['attrs']['content']['innerContent']['desktop']['value'] ?? '';
		if ( $v ) { $html .= $v . "\n"; }
		foreach ( ( $cur['innerBlocks'] ?? array() ) as $ib ) { $stack[] = $ib; }
	}
}
if ( strlen( $html ) > 3000 ) {
	$html = preg_replace( '/<!--.*?-->/s', '', $html );                       // strip the paste-instructions comment
	$html = str_replace( 'http://jsc.local', 'https://jscfla.com', $html );   // canonical site refs in legal text
	$html = str_replace( 'You Dream it, We Build it.', '', $html );
	$privacy = "<!-- wp:html -->\n" . trim( $html ) . "\n<!-- /wp:html -->";
	jsc_apply_page2( 101434, $privacy, false ); // narrow document layout, content provides the H1
} else {
	echo "SKIP privacy: extraction too small\n";
}

/* ============================== SEO bits ============================== */
global $wpdb;
$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'description' => 'Contact JSC Contracting in Silver Springs FL — call 352.687.2030 or send your project details for a free quote on docks, barndominiums, homes and more.' ), array( 'post_id' => 97973 ) );
// thank-you: noindex (conversion page) + description
$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'robots_default' => 0, 'robots_noindex' => 1 ), array( 'post_id' => 90829 ) );
echo "contact meta description set; thank-you set to noindex\n";
echo "DONE\n";
