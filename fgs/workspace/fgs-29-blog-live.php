<?php
/**
 * fgs-29-blog-live.php — Blog goes LIVE (Keith 2026-06-12):
 * 1. Post content broken up with BRM-style blocks: TL;DR callout, mid-post CTA band,
 *    styled cost table, FAQ styling (CSS marker fgs-blog).
 * 2. Featured images set from imported client photos.
 * 3. Posts 586+587 and Blog page 588 published; Reading -> posts page = Blog.
 * 4. Main Menu rebuilt deterministically (convention: full rebuild, never incremental):
 *    Home, Services (pillar + 10 children), Blog, About, Contact.
 * Idempotent. Usage: wp eval-file fgs-29-blog-live.php
 */

// ---------- 1a. inject blocks into posts ----------
$inject = array(
	586 => array(
		'label'   => 'THE SHORT ANSWER',
		'cta_after' => 'why the price gap</h2>',
		'cta_h'   => 'Want a real number instead of a range?',
		'cta_p'   => 'Send the parcel address and what you\'re building — an engineer scopes it, not a sales rep.',
	),
	587 => array(
		'label'   => 'THE HONEST ANSWER',
		'cta_after' => 'Sinkhole Insurance in Plain Language</h2>',
		'cta_h'   => 'Watching a crack and not sure?',
		'cta_p'   => 'Describe what you\'re seeing. If it doesn\'t justify an investigation, we\'ll tell you that for free.',
	),
);

foreach ( $inject as $pid => $cfg ) {
	$p = get_post( $pid );
	$c = $p->post_content;
	if ( false !== strpos( $c, 'fgs-blog-tldr' ) ) {
		WP_CLI::log( "post {$pid}: blocks already injected." );
		continue;
	}
	// wrap the first paragraph in a TL;DR callout
	if ( preg_match( '#^<!-- wp:paragraph -->\s*<p>(.*?)</p>\s*<!-- /wp:paragraph -->#s', $c, $m ) ) {
		$tldr = '<!-- wp:html -->
<div class="fgs-blog-tldr"><span class="fgs-blog-label">' . $cfg['label'] . '</span><p>' . $m[1] . '</p></div>
<!-- /wp:html -->';
		$c = $tldr . substr( $c, strlen( $m[0] ) );
	}
	// mid-post CTA band after the configured H2's section heading
	$pos = strpos( $c, $cfg['cta_after'] );
	if ( false !== $pos ) {
		// insert before that heading's block opener
		$open = strrpos( substr( $c, 0, $pos ), '<!-- wp:heading' );
		$cta  = '<!-- wp:html -->
<div class="fgs-blog-cta"><h3>' . $cfg['cta_h'] . '</h3><p>' . $cfg['cta_p'] . '</p><a href="/free-quote/">Get a Free Quote</a><span class="fgs-blog-cta-or">or call <a href="tel:+13526199292">(352) 619-9292</a></span></div>
<!-- /wp:html -->

';
		$c = substr( $c, 0, $open ) . $cta . substr( $c, $open );
	}
	$r = wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $c ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( "post {$pid}: " . $r->get_error_message() );
	}
	WP_CLI::log( "post {$pid}: TL;DR + CTA blocks injected." );
}

// ---------- 1b. blog CSS ----------
$ms  = '/* fgs-blog:start */';
$me  = '/* fgs-blog:end */';
$new = <<<'CSS'
/* — Blog post typography & blocks (BRM-style system in FGS colors) — */
.single-post .entry-content{max-width:780px;margin-left:auto;margin-right:auto;font-size:17px;line-height:1.75;color:#3a3a3a}
.single-post .entry-content h2{font-size:30px;font-weight:800;color:#2d2d2d;margin:1.6em 0 .6em}
.single-post .entry-content h3{font-size:21px;font-weight:800;color:#2d2d2d;margin:1.4em 0 .5em}
.single-post .entry-content li{margin-bottom:.55em}
.single-post .entry-header .entry-title{max-width:780px;margin-left:auto;margin-right:auto}
.fgs-blog-tldr{background:#f3efe8;border:1px solid #e8e1d6;border-left:5px solid #a91513;border-radius:14px;padding:22px 26px;margin:0 0 28px}
.fgs-blog-tldr p{margin:0;font-size:17.5px;line-height:1.7;color:#2d2d2d}
.fgs-blog-label{display:block;font-size:12px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase;color:#a91513;margin-bottom:8px}
.fgs-blog-cta{background:radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,.08),transparent 60%),linear-gradient(180deg,#6e0a0c 0%,#400303 100%);border-radius:18px;padding:34px 30px;margin:36px 0;text-align:center}
.fgs-blog-cta h3{color:#ffffff !important;margin:0 0 8px !important;font-size:23px !important}
.fgs-blog-cta p{color:rgba(255,255,255,.88);margin:0 auto 18px;max-width:480px;font-size:15.5px}
.fgs-blog-cta > a{display:inline-block;background:#ffffff;color:#5c0606;font-weight:800;padding:12px 28px;border-radius:9px;text-decoration:none;font-size:15.5px}
.fgs-blog-cta > a:hover{background:#f3efe8}
.fgs-blog-cta-or{display:block;margin-top:12px;color:rgba(255,255,255,.7);font-size:14px}
.fgs-blog-cta-or a{color:#ee7c63;font-weight:700}
.single-post .entry-content .wp-block-table table{border-collapse:collapse;width:100%;font-size:15px}
.single-post .entry-content .wp-block-table th{background:#2d2d2d;color:#ffffff;font-weight:700;padding:12px 14px;text-align:left}
.single-post .entry-content .wp-block-table td{border:1px solid #e8e1d6;padding:11px 14px;vertical-align:top}
.single-post .entry-content .wp-block-table tr:nth-child(even) td{background:#faf8f4}
/* archive cards: title + image polish */
.blog .entry,.archive .entry{border-radius:18px;overflow:hidden;border:1px solid #ece7e4;box-shadow:0 4px 18px rgba(0,0,0,.04)}
.blog .post-thumbnail img,.archive .post-thumbnail img{aspect-ratio:16/9;object-fit:cover;width:100%}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'blog CSS written.' );

// ---------- 2. featured images ----------
$thumbs = array(
	586 => 'fgs-mini-excavator-test-pit-geotechnical-site-investigation-florida.jpg',
	587 => 'fgs-deep-sinkhole-throat-karst-cavity-florida-geotechnical-evaluation.jpg',
);
global $wpdb;
foreach ( $thumbs as $pid => $file ) {
	$aid = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid LIKE %s LIMIT 1", '%/' . $wpdb->esc_like( $file ) ) );
	if ( $aid ) {
		set_post_thumbnail( $pid, $aid );
		WP_CLI::log( "post {$pid}: featured image -> {$file}" );
	}
}

// ---------- 2b. categories ----------
$cats = array();
foreach ( array(
	'Costs & Pricing' => 'costs-pricing',
	'Sinkholes'       => 'sinkholes',
	'Soil & Testing'  => 'soil-testing',
	'Foundations'     => 'foundations',
	'Project Notes'   => 'project-notes', // case-study rundowns
) as $name => $slug ) {
	$term = term_exists( $slug, 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	}
	$cats[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}
wp_set_post_categories( 586, array( $cats['costs-pricing'], $cats['soil-testing'] ) );
wp_set_post_categories( 587, array( $cats['sinkholes'] ) );
WP_CLI::log( 'categories created + assigned (586: Costs/Soil, 587: Sinkholes).' );

// ---------- 3. publish + posts page ----------
foreach ( array( 586, 587, 588 ) as $pid ) {
	if ( 'publish' !== get_post_status( $pid ) ) {
		wp_publish_post( $pid );
		WP_CLI::log( "published {$pid}." );
	}
}
update_option( 'page_for_posts', 588 );
WP_CLI::log( 'Reading: posts page = Blog (588).' );

// ---------- 4. menu rebuild (deterministic, full) ----------
$menu = wp_get_nav_menu_object( 'Main Menu' );
if ( ! $menu ) {
	WP_CLI::error( 'Main Menu not found.' );
}
foreach ( wp_get_nav_menu_items( $menu->term_id ) as $item ) {
	wp_delete_post( $item->ID, true );
}
$add = function ( $title, $page_id, $parent = 0 ) use ( $menu ) {
	return wp_update_nav_menu_item( $menu->term_id, 0, array(
		'menu-item-title'     => $title,
		'menu-item-object'    => 'page',
		'menu-item-object-id' => $page_id,
		'menu-item-type'      => 'post_type',
		'menu-item-status'    => 'publish',
		'menu-item-parent-id' => $parent,
	) );
};
$add( 'Home', 90 );
$svc = $add( 'Services', 146 );
$children = array(
	'Geotechnical Engineering'       => 146,
	'Sinkhole Investigation'         => 167,
	'Geotechnical Drilling'          => 205,
	'Soil Testing & Lab'             => 216,
	'Construction Materials Testing' => 202,
	'Concrete & Asphalt Testing'     => 230,
	'Foundation Engineering'         => 269,
	'Ground Penetrating Radar'       => 264,
	'Environmental Site Assessment'  => 223,
	'Pavement Design & Evaluation'   => 225,
);
foreach ( $children as $t => $pid ) {
	$add( $t, $pid, $svc );
}
$add( 'Gallery', 99 );
$add( 'Blog', 588 );
$add( 'About', 92 );
$add( 'Contact', 94 );
WP_CLI::log( 'Main Menu rebuilt: Home, Services(+10), Gallery, Blog, About, Contact.' );

WP_CLI::success( 'Blog is LIVE.' );
