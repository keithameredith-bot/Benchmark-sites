<?php
// Create battery + fleet pages (idempotent by slug); clean up the mangled draft 227930.
$mangled = get_post( 227930 );
if ( $mangled && 'draft' === $mangled->post_status && 'Battery' === $mangled->post_title ) {
	wp_delete_post( 227930, true );
	echo "deleted mangled draft 227930\n";
}
$want = array(
	'battery-replacement-in-ocala' => 'Battery Replacement in Ocala',
	'fleet-maintenance-in-ocala'   => 'Fleet Accounts',
	// slugs match the footer links built in a prior session
	'used-tires-ocala'             => 'Used Tires in Ocala',
	'tire-repair-ocala'            => 'Tire Repair in Ocala',
	'wheel-alignment-ocala'        => 'Wheel Alignment in Ocala',
	'tire-installation-ocala'      => 'Tire Installation in Ocala',
	'lifted-truck-tires-ocala'     => 'Lifted Truck & Off-Road Tires',
	'cv-axle-replacement-ocala'    => 'CV Axle Replacement in Ocala',
	'accessibility'                => 'Accessibility Statement',
);

// accessibility statement gets simple content right here (not a te-np landing page)
$a11y = get_page_by_path( 'accessibility' );
if ( $a11y && strlen( $a11y->post_content ) < 100 ) {
	wp_update_post( array( 'ID' => $a11y->ID, 'post_content' => '<!-- wp:html -->
<h2>Our Commitment to Accessibility</h2>
<p>Tire Express and Complete Auto Service is committed to making our website usable by everyone, including people with disabilities. We aim to follow the Web Content Accessibility Guidelines (WCAG) 2.1, Level AA, and we review the site regularly to improve accessibility.</p>
<h2>Measures We Take</h2>
<ul>
<li>Descriptive alternative text on images</li>
<li>Sufficient color contrast and readable font sizes</li>
<li>Keyboard-navigable menus and content</li>
<li>Clear headings and page structure</li>
</ul>
<h2>Need Help or Found a Problem?</h2>
<p>If you have difficulty using any part of this website, or you spot an accessibility issue, please tell us — we will do our best to fix it promptly and to provide the information you need by phone or email in the meantime.</p>
<p><strong>Phone:</strong> <a href="tel:3524215650">(352) 421-5650</a><br><strong>Visit:</strong> 1708 E Silver Springs Blvd, Ocala, FL 34470</p>
<!-- /wp:html -->' ) );
	echo "accessibility content set\n";
}
foreach ( $want as $slug => $title ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) { echo "EXISTS $slug -> {$existing->ID}\n"; continue; }
	$id = wp_insert_post( array(
		'post_type'   => 'page',
		'post_title'  => $title,
		'post_name'   => $slug,
		'post_status' => 'publish',
		'post_content'=> '',
	) );
	echo "CREATED $slug -> $id\n";
}
