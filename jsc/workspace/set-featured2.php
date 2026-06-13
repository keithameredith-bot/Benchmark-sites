<?php
// Second pass: the 4 pages skipped in set-featured.php, with URLs taken from the gallery specs.
$by_url = function ( $path ) {
	$id = attachment_url_to_postid( home_url( $path ) );
	if ( ! $id ) { echo "  !! no attachment for $path\n"; }
	return $id;
};
$map = array(
	101224 => $by_url( '/wp-content/uploads/2026/01/Boat-house-with-decking.webp' ),        // boathouse gallery
	101266 => $by_url( '/wp-content/uploads/2026/02/four-board-fencing-with-lake-small.webp' ), // fencing gallery
	101276 => $by_url( '/wp-content/uploads/2026/02/new-construction-home-modern-florida.webp' ), // new home gallery
	100894 => $by_url( '/wp-content/uploads/2026/02/new-construction-spec-home.webp' ),     // new construction service
);
foreach ( $map as $page_id => $att_id ) {
	if ( ! $att_id ) { echo "SKIP $page_id\n"; continue; }
	set_post_thumbnail( $page_id, $att_id );
	echo "OK $page_id (" . get_post( $page_id )->post_name . ") -> $att_id (" . basename( get_attached_file( $att_id ) ) . ")\n";
}
echo "DONE\n";
