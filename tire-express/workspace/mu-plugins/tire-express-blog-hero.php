<?php
/**
 * Plugin Name: Tire Express Blog Hero
 * Description: Branded gradient hero on the blog + category archives, replacing the plain "Blogs" title band.
 *   Same pattern as Black Rock's brm-blog-hero. TE colors: deep navy-blue gradient, Space Grotesk,
 *   orange (#ff5a3c) active chip.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'kadence_archive', function () {
	if ( ! is_home() && ! is_category() ) {
		return;
	}

	if ( is_home() ) {
		$eyebrow = 'The Tire Express Blog';
		$h1      = 'Tire &amp; Auto Advice for Ocala Drivers';
		$sub     = 'Straight answers from the shop on Silver Springs Blvd &mdash; what to watch for, what it really costs, and when it&rsquo;s actually time. The same things we tell our own customers, no upsell.';
	} else {
		$cat     = get_queried_object();
		$eyebrow = 'The Tire Express Blog';
		$h1      = esc_html( $cat->name );
		$sub     = $cat->description ? esc_html( $cat->description ) : 'Tips and straight talk on ' . esc_html( strtolower( $cat->name ) ) . ' from your Ocala tire and auto shop.';
	}

	$cats  = get_categories( array( 'hide_empty' => true, 'exclude' => array( 1 ) ) ); // hide Uncategorized + empty Divi leftovers
	$chips = '';
	foreach ( $cats as $c ) {
		$active = ( is_category() && get_queried_object_id() === $c->term_id );
		$style  = $active
			? 'background:#ff5a3c;border-color:#ff5a3c;color:#fff;font-weight:700;'
			: 'background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.22);color:#dce4f2;';
		$chips .= '<a href="' . esc_url( get_category_link( $c ) ) . '" style="display:inline-block;border:1.5px solid;border-radius:999px;padding:8px 16px;font-size:13.5px;text-decoration:none;transition:all .15s ease;' . $style . '">' . esc_html( $c->name ) . '</a>';
	}
	if ( is_category() ) {
		$chips = '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" style="display:inline-block;border:1.5px solid rgba(255,255,255,.22);border-radius:999px;padding:8px 16px;font-size:13.5px;text-decoration:none;background:rgba(255,255,255,.07);color:#dce4f2;">&larr; All articles</a>' . $chips;
	}
	?>
<div class="te-blog-hero" style="max-width:1140px;margin:18px auto 6px;padding:0 20px;">
  <div style="position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(127,168,255,.22),transparent 60%),linear-gradient(180deg,#0f1d3a,#0a1020);color:#fff;border-radius:16px;padding:48px 40px;">
    <p style="font-family:'Space Grotesk',sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#7fa8ff;margin:0 0 10px;"><?php echo $eyebrow; ?></p>
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:800;color:#fff;font-size:clamp(28px,4vw,42px);line-height:1.12;margin:0 0 12px;"><?php echo $h1; ?></h1>
    <p style="color:#c7d2e6;font-size:17.5px;line-height:1.55;max-width:680px;margin:0 0 22px;"><?php echo $sub; ?></p>
    <div style="display:flex;flex-wrap:wrap;gap:9px;"><?php echo $chips; ?></div>
  </div>
</div>
<style>
body.blog .entry-hero, body.category .entry-hero { display: none !important; }
.te-blog-hero a:hover { border-color: #7fa8ff !important; }
@media (max-width: 720px) { .te-blog-hero > div { padding: 34px 22px !important; border-radius: 12px !important; } }
</style>
	<?php
}, 5 );
