<?php
/**
 * fgs-00-audit-claims.php — READ-ONLY report.
 * Finds every page/post containing unverified team names, placeholder images,
 * and credential claims so the truth-audit edits hit every instance.
 * Usage: wp eval-file fgs-00-audit-claims.php
 */

global $wpdb;

$terms = array(
	'Mike Henderson',
	'Sarah Chen',
	'James Carter',
	'New Person',
	'placehold.co',
	'58334',
	'Cappa',
	'28 years',
	'30 years',
	'30+ years',
	'45+ years',
	'75+ years',
	'FDOT',
	'CMEC',
);

foreach ( $terms as $t ) {
	$like = '%' . $wpdb->esc_like( $t ) . '%';
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID, post_title, post_type, post_status FROM {$wpdb->posts}
			 WHERE post_content LIKE %s AND post_type IN ('page','post','wp_block','kadence_element')",
			$like
		)
	);
	echo "== {$t}\n";
	foreach ( $rows as $r ) {
		echo "   {$r->ID} [{$r->post_type}/{$r->post_status}] {$r->post_title}\n";
	}
}

// Also check widgets / theme mods / customizer-stored header-footer for the phone-bar claims.
$mods = get_theme_mods();
$flat = wp_json_encode( $mods );
foreach ( array( '58334', 'Cappa', 'CMEC' ) as $t ) {
	if ( false !== strpos( $flat, $t ) ) {
		echo "THEME MODS contain: {$t}\n";
	}
}
