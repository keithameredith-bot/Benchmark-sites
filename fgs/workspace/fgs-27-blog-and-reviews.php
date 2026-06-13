<?php
/**
 * fgs-27-blog-and-reviews.php — Blog launch + Reviews page (all DRAFTS for Keith):
 * 1. Two blog posts as draft posts (bodies in blog-posts/*.html) + AIOSEO meta.
 * 2. "Blog" page as draft (becomes the posts page at first publish — see BLOG-PLAN.md).
 * 3. "Reviews" page as draft: hero + the homepage testimonial section (copied verbatim,
 *    style block included) + review-us-on-Google CTA.
 * Idempotent. Usage: wp eval-file fgs-27-blog-and-reviews.php
 */

global $wpdb;
$aio = $wpdb->prefix . 'aioseo_posts';

function fgs27_meta( $pid, $t, $d ) {
	global $wpdb, $aio;
	$aio = $wpdb->prefix . 'aioseo_posts';
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM {$aio} WHERE post_id = %d", $pid ) );
	if ( $row ) {
		$wpdb->update( $aio, array( 'title' => $t, 'description' => $d ), array( 'post_id' => $pid ) );
	} else {
		$wpdb->insert( $aio, array( 'post_id' => $pid, 'title' => $t, 'description' => $d, 'created' => current_time( 'mysql' ), 'updated' => current_time( 'mysql' ) ) );
	}
}

// ---------- 1. blog post drafts ----------
$posts = array(
	array(
		'slug'  => 'geotechnical-report-cost-florida',
		'title' => 'How Much Does a Geotechnical Report Cost in Florida? (2026 Guide)',
		'file'  => 'C:/Users/keith/Desktop/fgs-workspace/blog-posts/geotechnical-report-cost-florida.html',
		'seo_t' => 'Geotechnical Report Cost in Florida: 2026 Guide',
		'seo_d' => 'Florida geotechnical reports run $1,500–$3,500 residential, $5,000–$20,000+ commercial. What drives the price and where not to cut corners. (352) 619-9292.',
	),
	array(
		'slug'  => 'sinkhole-warning-signs-florida',
		'title' => "Sinkhole Warning Signs in Florida: What's Serious and What Isn't",
		'file'  => 'C:/Users/keith/Desktop/fgs-workspace/blog-posts/sinkhole-warning-signs-florida.html',
		'seo_t' => "Sinkhole Warning Signs in Florida: What's Serious",
		'seo_d' => "Most sinkhole warning signs aren't sinkholes. A Florida engineer explains which cracks and depressions matter. Call FGS in Ocala at (352) 619-9292.",
	),
);

foreach ( $posts as $bp ) {
	$exists = get_page_by_path( $bp['slug'], OBJECT, 'post' );
	if ( $exists ) {
		WP_CLI::log( "post {$bp['slug']}: exists (ID {$exists->ID}) — skip." );
		continue;
	}
	$body = file_get_contents( $bp['file'] );
	$id   = wp_insert_post(
		array(
			'post_type'    => 'post',
			'post_status'  => 'draft',
			'post_title'   => $bp['title'],
			'post_name'    => $bp['slug'],
			'post_content' => wp_slash( $body ),
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( "{$bp['slug']}: " . $id->get_error_message() );
	}
	fgs27_meta( $id, $bp['seo_t'], $bp['seo_d'] );
	// validate block parse
	$orph = 0;
	foreach ( parse_blocks( $body ) as $b ) {
		if ( ! $b['blockName'] && '' !== trim( $b['innerHTML'] ) ) {
			$orph++;
		}
	}
	WP_CLI::log( "post {$bp['slug']}: DRAFT created (ID {$id}), orphan chunks: {$orph}." );
}

// ---------- 2. Blog page draft ----------
if ( ! get_page_by_path( 'blog', OBJECT, 'page' ) ) {
	$bid = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'draft',
			'post_title'   => 'Blog',
			'post_name'    => 'blog',
			'post_content' => '',
		),
		true
	);
	fgs27_meta( $bid, 'Florida Geotechnical Blog | Soil, Sinkholes & Site Work | FGS', 'Plain-language engineering guides from Florida Geotechnical Services — costs, sinkholes, soil testing, and what Florida ground actually does.' );
	WP_CLI::log( "Blog page DRAFT created (ID {$bid}). Set Settings > Reading > Posts page = Blog when first post publishes." );
} else {
	WP_CLI::log( 'Blog page exists — skip.' );
}

// ---------- 3. Reviews page draft ----------
if ( get_page_by_path( 'reviews', OBJECT, 'page' ) ) {
	WP_CLI::log( 'Reviews page exists — skip.' );
} else {
	// lift the homepage testimonials block (style + markup) verbatim
	$home = get_post( 90 )->post_content;
	$s    = strpos( $home, '<style>' . "\n" . '.fgs-tm' );
	if ( false === $s ) {
		$s = strpos( $home, '.fgs-tm{' );
		$s = false !== $s ? strrpos( substr( $home, 0, $s ), '<style>' ) : false;
	}
	$tm_html = '';
	if ( false !== $s ) {
		$start_div = strpos( $home, '<div class="fgs-tm">' );
		$style_s   = strrpos( substr( $home, 0, $start_div ), '<style>' );
		$end       = strpos( $home, '<!-- /wp:html -->', $start_div );
		// walk back to find the style that precedes the fgs-tm div within the same html block
		$tm_html = substr( $home, $style_s, $end - $style_s );
	}
	if ( '' === $tm_html ) {
		WP_CLI::warning( 'could not extract homepage testimonials — building page without them.' );
	}

	$content = '<!-- wp:kadence/rowlayout {"uniqueID":"rv_hero-r1","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_rvhero_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_rvhero_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">WHAT CLIENTS SAY</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">Reviews &amp; Testimonials</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">Builders, developers, and homeowners on what it\'s like to work with FGS — straight from the people who had ground to figure out.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"rv_tm-r2","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[24,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_rvtm_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_rvtm_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
' . $tm_html . '
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"rv_cta-r3","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[16,"",64,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_rvcta_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_rvcta_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"className":"fgs-cta","style":{"color":{"background":"#ffffff"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"56px","right":"48px","bottom":"56px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group fgs-cta has-background" style="border-radius:24px;background-color:#ffffff;padding-top:56px;padding-right:48px;padding-bottom:56px;padding-left:48px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"34px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"16px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;margin-top:0;margin-bottom:16px;font-size:34px;font-weight:800">Worked With Us? Tell People How It Went.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#adadad"},"typography":{"fontSize":"17px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#adadad;font-size:17px;line-height:1.6">Reviews are how the next builder or homeowner finds us. Two minutes on Google goes a long way.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:28px"><!-- wp:button {"style":{"color":{"background":"#a91513","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="https://www.google.com/search?q=Florida+Geotechnical+Services+Ocala" target="_blank" rel="noopener" style="border-radius:8px;color:#ffffff;background-color:#a91513;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Review Us on Google</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->';

	$rid = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'draft',
			'post_title'   => 'Reviews & Testimonials',
			'post_name'    => 'reviews',
			'post_content' => wp_slash( $content ),
		),
		true
	);
	if ( is_wp_error( $rid ) ) {
		WP_CLI::error( $rid->get_error_message() );
	}
	fgs27_meta( $rid, 'Reviews & Testimonials | Florida Geotechnical Services', 'What Florida builders, developers, and homeowners say about working with FGS — geotechnical reports, sinkhole investigations, and materials testing.' );
	WP_CLI::log( "Reviews page DRAFT created (ID {$rid})." );
}

WP_CLI::success( 'Blog + reviews drafts ready for Keith.' );
