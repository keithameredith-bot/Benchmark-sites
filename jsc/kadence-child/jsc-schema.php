<?php
/**
 * JSC custom schema: Service (per service page) + FAQPage (barndominium page).
 *
 * RULES (the Black Rock lesson):
 * - NEVER redefine the Organization here. AIOSEO owns it; we reference its node
 *   by @id only: home_url('/#organization') — verified against AIOSEO's rendered @graph.
 * - Blog posts carry their own FAQPage JSON-LD in content — they are NOT touched here.
 * - FAQPage questions below MUST mirror the visible FAQ on the barndominium page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * page ID => Service definition.
 * areaServed: Central Florida counties for local services; Florida for statewide builds.
 */
function jsc_schema_service_map() {
	$central_florida = array( 'Marion County FL', 'Lake County FL', 'Sumter County FL', 'Citrus County FL', 'Alachua County FL', 'Putnam County FL' );
	$statewide       = array( 'Florida' );
	return array(
		100394 => array( 'serviceType' => 'Dock Construction', 'areaServed' => $central_florida ),
		100421 => array( 'serviceType' => 'Boathouse Construction', 'areaServed' => $central_florida ),
		100468 => array( 'serviceType' => 'Seawall Construction and Repair', 'areaServed' => $statewide ),
		101740 => array( 'serviceType' => 'Boat Lift Installation', 'areaServed' => $central_florida ),
		100513 => array( 'serviceType' => 'Pole Barn Construction', 'areaServed' => $central_florida ),
		100658 => array( 'serviceType' => 'Home Remodeling', 'areaServed' => $central_florida ),
		100894 => array( 'serviceType' => 'New Home Construction', 'areaServed' => $central_florida ),
		100771 => array( 'serviceType' => 'Fence Installation', 'areaServed' => $central_florida ),
		100717 => array( 'serviceType' => 'Barndominium Construction', 'areaServed' => $statewide ),
		102114 => array( 'serviceType' => 'Container Home Construction', 'areaServed' => $statewide ),
	);
}

/** FAQPage source: page ID => Q/A pairs (must mirror visible page FAQ). */
function jsc_schema_faq_map() {
	return array(
		100394 => array(
			array(
				'q' => 'How much does it cost to build a dock in Central Florida?',
				'a' => 'Plan on $40–$60 per square foot for flat, walkable, easily accessible decking. Complete projects typically run from around $35,000 on deep-water rivers like the Rainbow to $200,000 on coastal builds like Crystal River — the biggest variable is how far your dock must run to reach proper depth for your boat. Rather than guess, our goal is to quote your dock free, on site.',
			),
			array(
				'q' => 'What warranty comes with a JSC dock?',
				'a' => 'A lifetime labor warranty on everything that\'s JSC\'s responsibility — if something we built needs attention, we make it right. Boat lifts carry a 3-year manufacturer warranty, and replacing a malfunctioning lift is no problem.',
			),
			array(
				'q' => 'Do I need a permit to build a dock in Florida?',
				'a' => 'Usually, yes — construction and environmental permits can both apply depending on your waterway. That\'s our job, not yours: JSC handles the permitting and makes sure your dock is built compliant from day one.',
			),
			array(
				'q' => 'Wood or composite decking — which is better?',
				'a' => 'Wood is cheaper up front, stays cooler underfoot, and takes stain — but needs sealing over time and can warp or splinter. Composite costs more up front but resists mold, insects, and warping with very little maintenance. We\'ll price your dock both ways so you can decide with real numbers.',
			),
			array(
				'q' => 'Do you repair existing docks?',
				'a' => 'Yes. Decking replacement, piling problems, storm damage, rails and hardware, and full re-decks from wood to composite. We\'ll walk your dock, tell you honestly what\'s worth repairing versus replacing, and quote it on site.',
			),
			array(
				'q' => 'What areas do you build docks in?',
				'a' => 'We\'re based in Ocala and our crews work across Central Florida — Orlando to Gainesville, Daytona to Crystal River, and every lake and river in between.',
			),
		),
		100717 => array(
			array(
				'q' => 'How much does it cost to build a barndominium in Florida?',
				'a' => 'Most JSC barndominiums come in between $100,000 and $800,000. The two biggest levers are size and finishes: a right-sized build with standard finishes lands toward the low end, while a large custom home with high-end kitchens, baths and outdoor living pushes toward the top. Square foot for square foot, a barndominium is typically cheaper than a comparable traditional home. Every JSC quote is priced from your exact plan and site.',
			),
			array(
				'q' => 'Can you build anywhere in Florida?',
				'a' => 'Yes. We\'re based in central Florida (Silver Springs), and we build barndominiums throughout the state.',
			),
			array(
				'q' => 'Can I use my own floor plan?',
				'a' => 'Yes — bring any plan you find online and we can build it, adjust it, or have our architects draw a custom plan from your ideas.',
			),
			array(
				'q' => 'Can I finance a barndominium build?',
				'a' => 'Yes. Construction loans are possible with as little as 5% down — far less than typical land loans. We can connect you with one of our preferred lenders to walk you through it.',
			),
		),
	);
}

add_action( 'wp_head', function () {
	if ( ! is_page() ) {
		return;
	}
	$id     = get_queried_object_id();
	$org_id = home_url( '/#organization' );
	$schemas = array();

	$services = jsc_schema_service_map();
	if ( isset( $services[ $id ] ) ) {
		$s = $services[ $id ];
		$schemas[] = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'@id'         => get_permalink( $id ) . '#service',
			'name'        => get_the_title( $id ),
			'serviceType' => $s['serviceType'],
			'url'         => get_permalink( $id ),
			'provider'    => array( '@id' => $org_id ),
			'areaServed'  => array_map( function ( $a ) {
				return array( '@type' => 'AdministrativeArea', 'name' => $a );
			}, $s['areaServed'] ),
		);
	}

	$faqs = jsc_schema_faq_map();
	if ( isset( $faqs[ $id ] ) ) {
		$main = array();
		foreach ( $faqs[ $id ] as $qa ) {
			$main[] = array(
				'@type'          => 'Question',
				'name'           => $qa['q'],
				'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $qa['a'] ),
			);
		}
		$schemas[] = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'@id'        => get_permalink( $id ) . '#faq',
			'mainEntity' => $main,
		);
	}

	foreach ( $schemas as $schema ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}, 20 );

/**
 * Add the contractor license to AIOSEO's GeneralContractor node (homepage local entity).
 * Augments AIOSEO's own graph via its filter — additive only, no @id is redefined.
 * License: Certified RESIDENTIAL Contractor (Ch. 489) — must never say General Contractor.
 */
add_filter( 'aioseo_schema_output', function ( $graph ) {
	foreach ( $graph as &$node ) {
		if ( isset( $node['@id'] ) && false !== strpos( $node['@id'], '#localbusiness' ) ) {
			$node['hasCredential'] = array(
				'@type'              => 'EducationalOccupationalCredential',
				'credentialCategory' => 'license',
				'name'               => 'Florida Certified Residential Contractor',
				'identifier'         => 'CRC1332267',
				'recognizedBy'       => array(
					'@type' => 'Organization',
					'name'  => 'Florida Department of Business and Professional Regulation',
				),
			);
		}
	}
	return $graph;
} );
