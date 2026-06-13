<?php
// TEST (brake page only): lighten the right side of the hero gradient per Keith.
// Round 1: .62/.42 -> .38/.18.  Round 2 (Keith: "even lighter"): -> .22/.06,
// and the 40% midpoint eased .90 -> .82 so the lightening blends in sooner.
// Round 3 (Keith): RIGHT side back to original, lighten the LEFT side instead
// (.96/.90 -> .80/.70 on the dark stops; blue right stops back to .62/.42).
global $wpdb;
$id = 226004;
$c  = get_post( $id )->post_content;
$target = 'rgba(7,11,20,.80) 0%,rgba(9,15,28,.70) 40%,rgba(13,38,96,.62) 72%,rgba(18,72,215,.42) 100%';
$olds = array(
	'rgba(7,11,20,.96) 0%,rgba(9,15,28,.90) 40%,rgba(13,38,96,.62) 72%,rgba(18,72,215,.42) 100%', // original
	'rgba(7,11,20,.96) 0%,rgba(9,15,28,.90) 40%,rgba(13,38,96,.38) 72%,rgba(18,72,215,.18) 100%', // round 1
	'rgba(7,11,20,.96) 0%,rgba(9,15,28,.82) 40%,rgba(13,38,96,.22) 72%,rgba(18,72,215,.06) 100%', // round 2
);
if ( false !== strpos( $c, $target ) ) { echo "already at round-2 values\n"; exit; }
$done = false;
foreach ( $olds as $old ) {
	if ( false !== strpos( $c, $old ) ) {
		$c = str_replace( $old, $target, $c );
		$done = true;
		break;
	}
}
if ( ! $done ) { echo "gradient string not found — check format\n"; exit; }
$wpdb->update( $wpdb->posts, array( 'post_content' => $c ), array( 'ID' => $id ) );
clean_post_cache( $id );
echo "brake page gradient at round-2 (lighter) values\n";
