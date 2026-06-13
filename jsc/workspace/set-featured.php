<?php
/**
 * wp eval-file set-featured.php — set featured images per the 2026-06-10 audit. Idempotent.
 * Cover card (Keith's brand montage, att looked up by filename) -> utility/info pages.
 * Best real job photo -> service + gallery pages. Posts untouched (blog cards approved as-is).
 */

// resolve the OG cover (imported as jsc-og-cover.jpg)
$cover = attachment_url_to_postid( home_url( '/wp-content/uploads/2026/06/jsc-og-cover.jpg' ) );
if ( ! $cover ) { echo "ABORT: cover attachment not found — import first\n"; exit; }
echo "cover attachment: $cover\n";

$by_url = function ( $path ) {
	$id = attachment_url_to_postid( home_url( $path ) );
	if ( ! $id ) { echo "  !! no attachment for $path\n"; }
	return $id;
};

$map = array(
	// cover card — info/utility pages
	93271  => $cover, // home
	91280  => $cover, // about-us
	97973  => $cover, // contact
	101185 => $cover, // core-values
	100816 => $cover, // our-team
	93315  => $cover, // services
	101216 => $cover, // galleries index
	102146 => $cover, // get-a-free-quote
	90829  => $cover, // thank-you
	101434 => $cover, // privacy
	96840  => $cover, // blog posts page
	// service pages — real job photos (replacing 500px squares / NONE)
	100717 => $by_url( '/wp-content/uploads/2026/06/best-barndominium-builders-in-florida-hero.webp' ), // barndo
	100394 => 102073, // dock builder — two-story dock with viewing deck
	101740 => 102077, // boat lift — boathouse + lift combo
	100468 => 102074, // seawall — Lake Weir
	102114 => 102111, // container homes — real build photo (temp video frame, swap when client pics arrive)
	100894 => $by_url( '/wp-content/uploads/2026/02/custom-built-home-in-central-florida.webp' ), // new construction
	100771 => $by_url( '/wp-content/uploads/2026/02/central-florida-fence-builder.webp' ), // fence
	// gallery pages — strongest image from each gallery
	101287 => $by_url( '/wp-content/uploads/2026/06/barndominium-backyard-garage-guest-suite.webp' ),
	101224 => $by_url( '/wp-content/uploads/2026/02/boat-house-with-boat-lift.webp' ),
	101266 => $by_url( '/wp-content/uploads/2026/02/wood-fence-installation.webp' ),
	101276 => $by_url( '/wp-content/uploads/2026/02/custom-built-home-in-central-florida.webp' ),
	101257 => 102076, // pole barn gallery — pole barn in backyard
	101248 => 102074, // seawall gallery — Lake Weir
	101233 => 102071, // dock gallery — dock with railings (replaces 1536x2048 portrait)
);

foreach ( $map as $page_id => $att_id ) {
	if ( ! $att_id ) { echo "SKIP $page_id (no attachment resolved)\n"; continue; }
	if ( ! get_post( $att_id ) || 'attachment' !== get_post_type( $att_id ) ) { echo "SKIP $page_id (att $att_id invalid)\n"; continue; }
	set_post_thumbnail( $page_id, $att_id );
	echo "OK $page_id (" . get_post( $page_id )->post_name . ") -> $att_id (" . basename( get_attached_file( $att_id ) ) . ")\n";
}
echo "DONE\n";
