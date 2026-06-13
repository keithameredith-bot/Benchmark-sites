<?php
// oil-change (226005) + new-tires (226006) carry their own embedded CSS + inline pricing grids.
// Same mobile fix: add the cols utilities to their <style> and swap inline styles for classes. Idempotent.
global $wpdb;
$util = '.te-np .incl.cols-2{grid-template-columns:repeat(2,1fr);}
.te-np .incl.cols-4{grid-template-columns:repeat(4,1fr);}
@media(max-width:900px){.te-np .incl.cols-4{grid-template-columns:1fr 1fr;}}
@media(max-width:600px){.te-np .incl.cols-2,.te-np .incl.cols-4{grid-template-columns:1fr;}}
</style>';
foreach ( array( 226005 => 'oil-change', 226006 => 'new-tires' ) as $id => $label ) {
	$c = get_post( $id )->post_content;
	$orig = $c;
	if ( false === strpos( $c, 'incl.cols-2' ) ) {
		$c = preg_replace( '/<\/style>/', $util, $c, 1 );
	}
	$c = str_replace( 'class="incl" style="grid-template-columns:repeat(2,1fr);"', 'class="incl cols-2"', $c );
	$c = str_replace( 'class="incl" style="grid-template-columns:repeat(4,1fr);"', 'class="incl cols-4"', $c );
	if ( $c !== $orig ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $c ), array( 'ID' => $id ) );
		clean_post_cache( $id );
		echo "$label fixed\n";
	} else { echo "$label unchanged (check manually if it has inline grids)\n"; }
}
