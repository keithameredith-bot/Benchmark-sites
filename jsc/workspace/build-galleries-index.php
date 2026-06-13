<?php
$cards = array(
	array( '/barndominium-gallery/', 'Barndominiums', '/wp-content/uploads/2026/06/best-barndominium-builders-in-florida-hero.webp', 'Barndominium gallery — JSC builds' ),
	array( '/dock-gallery/', 'Docks', '/wp-content/uploads/2026/06/two-story-dock-with-viewing-deck-768x576.webp', 'Dock gallery — JSC builds' ),
	array( '/boathouse-gallery/', 'Boathouses', '/wp-content/uploads/2025/12/boat-house-500.webp', 'Boathouse gallery — JSC builds' ),
	array( '/seawall-gallery/', 'Seawalls', '/wp-content/uploads/2026/06/seawall-on-lake-weir-768x1024.webp', 'Seawall gallery — JSC builds' ),
	array( '/pole-barn-gallery/', 'Pole Barns', '/wp-content/uploads/2026/06/pole-barn-in-backyard-768x576.webp', 'Pole barn gallery — JSC builds' ),
	array( '/new-fencing-gallery/', 'New Fencing', '/wp-content/uploads/2025/12/New-Fencing.webp', 'Fencing gallery — JSC installs' ),
	array( '/new-home-gallery/', 'New Homes', '/wp-content/uploads/2026/02/new-construction-home-modern-florida.webp', 'New home gallery — JSC builds' ),
	array( '/marine-construction-gallery/', 'Marine Construction', '/wp-content/uploads/2026/06/boathouse-and-boat-lift-768x433.webp', 'Marine construction gallery — JSC builds' ),
);
$cards_html = '';
foreach ( $cards as $c ) {
	$cards_html .= '<a class="jsc-gal-card" href="' . $c[0] . '"><img src="' . $c[2] . '" alt="' . esc_attr( $c[3] ) . '" loading="lazy"><span>' . $c[1] . '</span></a>' . "\n";
}
$content = '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'/wp-content/uploads/2026/06/jsc-home-hero-montage.webp\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">Our Work Speaks For Itself</span>
<h1>Galleries of Our Past Work</h1>
<p class="jsc-sub">Check out some pictures of our past work.</p>
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
<p class="jsc-real-jobs-note"><span class="jsc-tag">REAL JOBS ONLY</span> Every photo in every gallery is a real JSC job — no stock photos.</p>
<div class="jsc-gal-cards">
' . $cards_html . '</div>
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

$r = wp_update_post( array( 'ID' => 101216, 'post_content' => $content ), true );
echo is_wp_error( $r ) ? 'ERR: ' . $r->get_error_message() . "\n" : "galleries index rebuilt\n";
update_post_meta( 101216, '_kad_post_title', 'hide' );
update_post_meta( 101216, '_kad_post_layout', 'fullwidth' );
update_post_meta( 101216, '_kad_post_content_style', 'unboxed' );
update_post_meta( 101216, '_kad_post_vertical_padding', 'hide' );
echo "meta set\n";
