<?php
/**
 * fgs-05-location-pages.php — Phase 3: create the six location-wheel pages as DRAFTS.
 * Reads body markup from location-pages/<slug>.html, wraps in hero/trust-bar/CTA shell
 * (new design tokens), creates draft page, sets AIOSEO title/description.
 * Idempotent: if a page with the slug exists, its content/meta are updated in place
 * (status left as-is so an approved/published page is not demoted).
 * Usage: wp eval-file fgs-05-location-pages.php
 */

$dir = 'C:/Users/keith/Desktop/fgs-workspace/location-pages/';

$pages = array(
	'geotechnical-engineering-gainesville-fl'   => array(
		'title'  => 'Geotechnical Engineering Gainesville FL',
		'h1'     => 'Geotechnical Engineering in Gainesville & Alachua County',
		'kicker' => 'SERVING GAINESVILLE & ALACHUA COUNTY FROM OCALA',
		'intro'  => 'Gainesville sits on one of the sharpest geological boundaries in Florida: clay-rich Hawthorn Group uplands on one side, near-surface karst limestone on the other. Two sites a few miles apart can need completely different foundations. We run SPT borings, lab testing, and stamped geotechnical reports for Alachua County projects from our Ocala office, about 45 minutes down I-75.',
		'seo_t'  => 'Geotechnical Engineering Gainesville FL | Soil Testing',
		'seo_d'  => 'Geotechnical engineering, SPT borings, and soil testing for Gainesville & Alachua County from our Ocala office and accredited lab. Call (352) 619-9292.',
	),
	'geotechnical-engineering-the-villages-fl'  => array(
		'title'  => 'Geotechnical Engineering The Villages FL',
		'h1'     => 'Geotechnical Engineering in The Villages, FL',
		'kicker' => 'SERVING THE VILLAGES — SUMTER, LAKE & MARION COUNTIES — FROM OCALA',
		'intro'  => 'The Villages has been one of the fastest-growing communities in America for years, and all of that construction sits on covered karst: sand over Ocala Limestone, in one of the more sinkhole-active regions of the state. We provide geotechnical reports, sinkhole investigations, and construction materials testing across the tri-county area from our Ocala office, about 40 to 45 minutes away.',
		'seo_t'  => 'Geotechnical Engineering The Villages FL | Sinkhole Tests',
		'seo_d'  => 'Geotechnical reports, sinkhole investigation, and materials testing in The Villages, FL. Stamped by a Florida-licensed P.E. Call (352) 619-9292.',
	),
	'geotechnical-engineering-sumter-county-fl' => array(
		'title'  => 'Geotechnical Engineering Sumter County FL',
		'h1'     => 'Geotechnical Engineering in Sumter County, FL',
		'kicker' => 'WILDWOOD · BUSHNELL · THE VILLAGES · THE I-75 CORRIDOR',
		'intro'  => "Sumter County is permitting big-footprint warehouse slabs and miles of new pavement at a pace the area has never seen, and most of it is going up over covered karst. We're a geotechnical engineering firm based in Ocala — 35 to 45 minutes up I-75 from Wildwood — with an in-house accredited soils lab, and every report we issue is stamped by a Florida-licensed P.E.",
		'seo_t'  => 'Geotechnical Engineering in Sumter County, FL | FGS',
		'seo_d'  => 'Geotechnical engineering, soil borings, and CMT for Wildwood, Bushnell & The Villages. Ocala-based firm with in-house lab. Call (352) 619-9292.',
	),
	'sinkhole-inspection-citrus-county-fl'      => array(
		'title'  => 'Sinkhole Inspection Citrus County FL',
		'h1'     => 'Sinkhole Inspection & Geotechnical Engineering in Citrus County',
		'kicker' => 'INVERNESS · LECANTO · CRYSTAL RIVER · HOMOSASSA',
		'intro'  => 'Citrus County sits on some of the most sinkhole-active ground in the United States: thin sandy soils directly over weathered Ocala Limestone, in the karst belt that runs from Tampa Bay up through Ocala. We investigate suspected sinkholes with GPR screening and SPT confirmation borings, and a Florida-licensed P.E. stamps what we find — including when the answer is "this isn\'t a sinkhole."',
		'seo_t'  => 'Sinkhole Inspection in Citrus County, FL | FGS',
		'seo_d'  => 'Sinkhole investigations & geotechnical engineering in Inverness, Lecanto, Crystal River & Homosassa. GPR screening, SPT borings. Call (352) 619-9292.',
	),
	'geotechnical-engineering-lake-county-fl'   => array(
		'title'  => 'Geotechnical Engineering Lake County FL',
		'h1'     => 'Geotechnical Engineering in Lake County, FL',
		'kicker' => 'CLERMONT · LEESBURG · MOUNT DORA · TAVARES · EUSTIS · MINNEOLA',
		'intro'  => "Most of Florida is flat. Lake County isn't. Between the sand hills of the Lake Wales Ridge and the shorelines of the Harris Chain, this county puts more topography into a site investigation than almost anywhere else in the state — and topography changes the questions a geotechnical engineer has to answer.",
		'seo_t'  => 'Geotechnical Engineering in Lake County, FL | FGS',
		'seo_d'  => 'Geotechnical engineering in Lake County, FL — borings, compaction testing, sinkhole investigation for Clermont, Leesburg, Mount Dora. Call (352) 619-9292.',
	),
	'geotechnical-engineering-putnam-county-fl' => array(
		'title'  => 'Geotechnical Engineering Putnam County FL',
		'h1'     => 'Geotechnical Engineering in Putnam County, FL',
		'kicker' => 'PALATKA · CRESCENT CITY · INTERLACHEN',
		'intro'  => 'In Putnam County the St. Johns River sets the geotechnical rules. Soft organic soils and shallow groundwater near the river, dry sand ridges inland, and a riverfront with a century of industrial history behind it — each one changes what a site investigation needs to look at before anyone builds.',
		'seo_t'  => 'Geotechnical Engineering in Putnam County, FL | FGS',
		'seo_d'  => 'Geotechnical engineering in Putnam County, FL — borings, lab testing, Phase I ESAs for Palatka and the St. Johns riverfront. Call (352) 619-9292.',
	),
);

function fgs_loc_shell( $slug, $m, $body ) {
	$uid    = substr( md5( $slug ), 0, 6 );
	$kicker = esc_html( $m['kicker'] );
	$h1     = esc_html( $m['h1'] );
	$intro  = esc_html( $m['intro'] );

	$hero = <<<HTML
<!-- wp:kadence/rowlayout {"uniqueID":"loc{$uid}-hero","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[4,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"loc{$uid}-heroc","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-columnloc{$uid}-heroc inner-column-1"><div class="kt-inside-inner-col"><!-- wp:group {"style":{"color":{"background":"#f0e5e5"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"64px","right":"48px","bottom":"64px","left":"48px"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f0e5e5;padding-top:64px;padding-right:48px;padding-bottom:64px;padding-left:48px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","letterSpacing":"2px","textTransform":"uppercase","fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:2px;text-transform:uppercase">{$kicker}</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#2d2d2d"},"typography":{"fontSize":"48px","fontWeight":"800","lineHeight":"1.1"},"spacing":{"margin":{"top":"8px","bottom":"24px"}}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#2d2d2d;margin-top:8px;margin-bottom:24px;font-size:48px;font-weight:800;line-height:1.1">{$h1}</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#454545"},"typography":{"fontSize":"18px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#454545;font-size:18px;line-height:1.6">{$intro}</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"32px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:32px"><!-- wp:button {"style":{"color":{"background":"#c63a3a","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="tel:+13526199292" style="border-radius:8px;color:#ffffff;background-color:#c63a3a;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Call (352) 619-9292</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px","width":"2px","color":"#2d2d2d"},"spacing":{"padding":{"top":"12px","right":"30px","bottom":"12px","left":"30px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color has-background has-border-color has-custom-font-size wp-element-button" href="/contact/" style="border-color:#2d2d2d;border-width:2px;border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:12px;padding-right:30px;padding-bottom:12px;padding-left:30px;font-size:16px;font-weight:700">Request a Quote →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

<!-- wp:kadence/rowlayout {"uniqueID":"loc{$uid}-trust","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[24,"",24,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"loc{$uid}-trustc","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-columnloc{$uid}-trustc inner-column-1"><div class="kt-inside-inner-col"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#676767"},"typography":{"fontSize":"14px","fontWeight":"600","letterSpacing":"1px"}}} -->
<p class="has-text-align-center has-text-color" style="color:#676767;font-size:14px;font-weight:600;letter-spacing:1px">✓ OCALA-BASED · ALL 67 FLORIDA COUNTIES &nbsp;&nbsp;•&nbsp;&nbsp; ✓ ACCREDITED IN-HOUSE LAB &nbsp;&nbsp;•&nbsp;&nbsp; ✓ P.E.-STAMPED REPORTS &nbsp;&nbsp;•&nbsp;&nbsp; ✓ FAST TURNAROUND</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->

HTML;

	$body_open = <<<HTML
<!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","bottom":"40px"}}},"layout":{"type":"constrained","contentSize":"820px"}} -->
<div class="wp-block-group" style="padding-top:24px;padding-bottom:40px">
HTML;

	$cta = <<<HTML
</div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#2d2d2d"},"border":{"radius":"24px"},"spacing":{"padding":{"top":"56px","right":"48px","bottom":"56px","left":"48px"},"margin":{"bottom":"64px"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group has-background" style="border-radius:24px;background-color:#2d2d2d;margin-bottom:64px;padding-top:56px;padding-right:48px;padding-bottom:56px;padding-left:48px"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"34px","fontWeight":"800"},"spacing":{"margin":{"top":"0","bottom":"16px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;margin-top:0;margin-bottom:16px;font-size:34px;font-weight:800">Talk through your project</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#adadad"},"typography":{"fontSize":"17px","lineHeight":"1.6"}}} -->
<p class="has-text-align-center has-text-color" style="color:#adadad;font-size:17px;line-height:1.6">Tell us what you're building and where. You'll get a straight answer on scope, schedule, and price — from the office in Ocala, not a call center.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"12px"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:28px"><!-- wp:button {"style":{"color":{"background":"#c63a3a","text":"#ffffff"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="tel:+13526199292" style="border-radius:8px;color:#ffffff;background-color:#c63a3a;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Call (352) 619-9292</a></div>
<!-- /wp:button -->

<!-- wp:button {"style":{"color":{"background":"#ffffff","text":"#2d2d2d"},"border":{"radius":"8px"},"spacing":{"padding":{"top":"14px","right":"32px","bottom":"14px","left":"32px"}},"typography":{"fontSize":"16px","fontWeight":"700"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-custom-font-size wp-element-button" href="/contact/" style="border-radius:8px;color:#2d2d2d;background-color:#ffffff;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px;font-size:16px;font-weight:700">Request a Quote →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
HTML;

	return $hero . $body_open . "\n" . $body . "\n" . $cta;
}

global $wpdb;
$aio = $wpdb->prefix . 'aioseo_posts';

foreach ( $pages as $slug => $m ) {
	$file = $dir . $slug . '.html';
	if ( ! file_exists( $file ) ) {
		WP_CLI::warning( "missing body file: {$file}" );
		continue;
	}
	$body    = file_get_contents( $file );
	$content = fgs_loc_shell( $slug, $m, $body );

	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing ) {
		$r = wp_update_post( array( 'ID' => $existing->ID, 'post_content' => wp_slash( $content ), 'post_title' => $m['title'] ), true );
		$id = $existing->ID;
		$verb = 'updated (status ' . $existing->post_status . ')';
	} else {
		$r = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => $m['title'],
				'post_name'    => $slug,
				'post_content' => wp_slash( $content ),
			),
			true
		);
		$id   = $r;
		$verb = 'created as DRAFT';
	}
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( "{$slug}: " . $r->get_error_message() );
	}

	$row = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM {$aio} WHERE post_id = %d", $id ) );
	if ( $row ) {
		$wpdb->update( $aio, array( 'title' => $m['seo_t'], 'description' => $m['seo_d'] ), array( 'post_id' => $id ) );
	} else {
		$wpdb->insert( $aio, array( 'post_id' => $id, 'title' => $m['seo_t'], 'description' => $m['seo_d'], 'created' => current_time( 'mysql' ), 'updated' => current_time( 'mysql' ) ) );
	}

	WP_CLI::log( "{$slug}: {$verb} (ID {$id}), AIOSEO meta set." );
}

WP_CLI::success( 'Location pages done. All new pages are DRAFTS — Keith reviews, then publish.' );
