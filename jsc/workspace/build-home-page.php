<?php
/**
 * Rebuild HOME (93271) — montage hero + preserved copy in the approved design system.
 * Copy fixes (logged): "envy of the of the neighborhood" → "envy of the neighborhood";
 * meta description double comma fixed (baseline issue #4).
 * Run: wp eval-file build-home-page.php
 */

$services = array(
	array( '/central-florida-dock-builder/', 'Docks', '/wp-content/uploads/2026/06/two-story-dock-with-viewing-deck-768x576.webp', 'Custom dock built by JSC in Central Florida' ),
	array( '/boathouse-builder/', 'Boathouses', '/wp-content/uploads/2025/12/boat-house-500.webp', 'Boathouse built by JSC Contracting' ),
	array( '/seawall-construction-and-repair/', 'Seawalls', '/wp-content/uploads/2026/06/seawall-on-lake-weir-768x1024.webp', 'Seawall construction and repair by JSC' ),
	array( '/central-florida-boat-lift-installation/', 'Boat Lifts', '/wp-content/uploads/2026/03/boat-in-a-boat-lift.jpg', 'Boat lift installation in Central Florida' ),
	array( '/barndominium-builders-in-florida/', 'Barndominiums', '/wp-content/uploads/2026/06/best-barndominium-builders-in-florida-hero.webp', 'Barndominium built by JSC in Florida' ),
	array( '/container-home-builders-in-florida/', 'Container Homes', '/wp-content/uploads/2026/06/container-home-build-florida.webp', 'Shipping container home built by JSC in Florida' ),
	array( '/pole-barn-builder/', 'Pole Barns', '/wp-content/uploads/2026/06/pole-barn-in-backyard-768x576.webp', 'Pole barn built by JSC in Central Florida' ),
	array( '/home-remodeling-central-florida/', 'Home Remodeling', '/wp-content/uploads/2026/01/kitchen-remodel-500.webp', 'Home remodeling in Central Florida by JSC' ),
	array( '/custom-new-construction-builder-in-central-florida/', 'New Construction', '/wp-content/uploads/2026/02/new-construction-home-modern-florida.webp', 'New construction home built by JSC' ),
	array( '/central-florida-fence-builder/', 'New Fencing', '/wp-content/uploads/2025/12/New-Fencing.webp', 'New fencing installed by JSC in Central Florida' ),
);
$cards = '';
foreach ( $services as $s ) {
	$cards .= '<a class="jsc-gal-card" href="' . $s[0] . '"><img src="' . $s[2] . '" alt="' . esc_attr( $s[3] ) . '" loading="lazy"><span>' . $s[1] . '</span></a>' . "\n";
}

$features = array(
	array( '100% Satisfaction', 'Our goal is always 100% customer satisfaction. We want to exceed your expectations, not just meet them.' ),
	array( 'Upfront Pricing', 'We know clients don\'t like surprises when it comes to the cost of a job. Our quotes are clear, transparent, and we hold to them.' ),
	array( 'Dedication', 'Our company culture breeds an environment of excellence. You can expect dedication to your job from start to finish.' ),
	array( 'Turn Times', 'When we give an estimate for the completion of your project, we do everything we can to stick to that goal.' ),
	array( 'Quality Workmanship', 'Our project managers and skilled laborers are relentlessly dedicated to getting the job done right no matter the project.' ),
	array( 'Safety Commitment', 'We aim to always make sure our job site is secure, clean, and safe.' ),
);
$fcards = '';
foreach ( $features as $f ) {
	$fcards .= '<div class="jsc-feature"><h3>' . $f[0] . '</h3><p>' . $f[1] . '</p></div>' . "\n";
}

$content = '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/06/jsc-home-hero-montage.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Welcome</span>
<h1>JSC Contracting Inc.</h1>
<p class="jsc-sub">You dream it. We build it. Marine and residential construction across Central Florida — docks, barndominiums, custom homes and more.</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
<a class="jsc-btn jsc-btn-ghost" href="tel:3526872030">CALL 352.687.2030</a>
</div>
<div class="jsc-trust">
[bwd_stars]
<span><b>✓</b> 25+ Years Experience</span>
<span><b>✓</b> FL Certified Residential Contractor <b>CRC1332267</b></span>
<span><b>✓</b> We Build Statewide</span>
</div>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:columns {"className":"jsc-two-col"} -->
<div class="wp-block-columns jsc-two-col"><!-- wp:column {"width":"60%","className":"jsc-copy-col"} -->
<div class="wp-block-column jsc-copy-col" style="flex-basis:60%"><!-- wp:html -->
<p class="jsc-kicker">About us</p>
<h2>The Builder You Can Rely On</h2>
<p>JSC Contracting Inc is central Florida\'s leading marine construction builder. We got our start with docks, boat houses, sea walls and all things marine related. <strong>Turns out if <em>you\'re really good at that, barns,</em> barndominiums, new home builds and remodels come easy.</strong> So we do that too, and more.</p>
<p>Our work speaks for itself. From the Gulf of America to the Atlantic, and all the rivers, lakes and springs in between, we\'ve got you covered. The pics you see on our site are from real JSC jobs. <strong>We pride ourselves on timeliness, cleanliness, precision and customer satisfaction.</strong></p>
<p>Our mission statement is simple. <strong>You dream it, we build it.</strong> The truth is we can help you dream as well. This is what we do. We are glad to help brainstorm your dream with you and create an outcome that will be the envy of the neighborhood!</p>
<p><strong>Alex Scanlan — Owner</strong></p>
<img class="jsc-sig" src="/wp-content/uploads/2026/02/alex-sig-small-2-final.png" alt="Alex Scanlan signature" loading="lazy">
<p><a class="jsc-btn" href="/about-us/">MORE ABOUT US</a></p>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%","className":"jsc-side-col"} -->
<div class="wp-block-column is-vertically-aligned-center jsc-side-col" style="flex-basis:40%"><!-- wp:html -->
<div class="jsc-founder-img"><img src="/wp-content/uploads/2026/02/alex-left-transparent.png" alt="Alex Scanlan, owner of JSC Contracting Inc" loading="lazy"></div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jsc-section jsc-warm"} -->
<section class="wp-block-group jsc-section jsc-warm"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p class="jsc-kicker">How Can We Help You</p>
<h2>Our Services</h2>
<p>JSC Contracting covers a wide range of marine, residential, commercial and agricultural construction services. Our services include but are not limited to docks, boat houses, new home construction, remodels, pole barns, barndominiums, seawalls, new fencing and more.</p>
<div class="jsc-gal-cards">
' . $cards . '</div>
<p style="margin-top:22px"><a class="jsc-btn" href="/services/">SEE ALL SERVICES</a></p>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p class="jsc-kicker">You Dream It, We Build It</p>
<h2>What Our Customers Say about Us</h2>
[trustindex no-registration=google]
<p style="margin-top:22px"><a class="jsc-btn" href="/our-reviews/">READ ALL REVIEWS</a></p>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jsc-section jsc-warm"} -->
<section class="wp-block-group jsc-section jsc-warm"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p class="jsc-kicker">Features</p>
<h2>Why Choose Us</h2>
<div class="jsc-features">
' . $fcards . '</div>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p class="jsc-kicker">Latest News</p>
<h2>From the Blog</h2>
<p>Check out our blog for the latest trends, updates, and completed JSC projects.</p>
<!-- /wp:html -->

<!-- wp:latest-posts {"postsToShow":3,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageSizeSlug":"medium_large","addLinkToFeaturedImage":true,"postLayout":"grid","columns":3} /--></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:html -->
<div class="jsc-cta-band" id="appt">
<h2>Get Your Free Quote Today!</h2>
<p>Call <a class="jsc-tel" href="tel:3526872030">352.687.2030</a> or send us your project details online — we\'ll review your project and get you a free price quote.</p>
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<!-- /wp:html -->';

$r = wp_update_post( array( 'ID' => 93271, 'post_content' => $content ), true );
echo is_wp_error( $r ) ? 'ERR: ' . $r->get_error_message() . "\n" : "home rebuilt\n";
update_post_meta( 93271, '_kad_post_title', 'hide' );
update_post_meta( 93271, '_kad_post_layout', 'fullwidth' );
update_post_meta( 93271, '_kad_post_content_style', 'unboxed' );
update_post_meta( 93271, '_kad_post_vertical_padding', 'hide' );

// baseline issue #4: meta description double comma
global $wpdb;
$desc = $wpdb->get_var( "SELECT description FROM {$wpdb->prefix}aioseo_posts WHERE post_id=93271" );
if ( $desc && strpos( $desc, ',,' ) !== false ) {
	$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'description' => str_replace( ',,', ',', $desc ) ), array( 'post_id' => 93271 ) );
	echo "meta description double comma fixed\n";
}
echo "DONE\n";
