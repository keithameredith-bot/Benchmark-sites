<?php
/**
 * Rebuild /services/ (93315): hero + preserved intro + 10 service cards.
 * Run: wp eval-file build-services-page.php
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

$content = '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/06/jsc-home-hero-montage.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">How Can We Help You</span>
<h1>Our Services</h1>
<p class="jsc-sub">Marine construction, barndominiums, custom homes and more — if your dream project isn\'t listed, call us anyway.</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
<a class="jsc-btn jsc-btn-ghost" href="tel:3526872030">CALL 352.687.2030</a>
</div>
</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p>JSC Contracting Inc is the leading marine construction builder in central Florida, but it doesn\'t stop there. We have many divisions constantly keeping busy with new construction projects. See below for just a little of what we do. Please do not hesitate to call if your dream project is not listed here.</p>
<div class="jsc-gal-cards">
' . $cards . '</div>
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

$r = wp_update_post( array( 'ID' => 93315, 'post_content' => $content ), true );
echo is_wp_error( $r ) ? 'ERR: ' . $r->get_error_message() . "\n" : "services page rebuilt\n";
update_post_meta( 93315, '_kad_post_title', 'hide' );
update_post_meta( 93315, '_kad_post_layout', 'fullwidth' );
update_post_meta( 93315, '_kad_post_content_style', 'unboxed' );
update_post_meta( 93315, '_kad_post_vertical_padding', 'hide' );
echo "DONE\n";
