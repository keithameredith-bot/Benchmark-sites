<?php
// new-tires page: generic lifted-truck.jpg -> the F-250 with fresh tires & wheels (on-topic). Idempotent.
$p = get_post( 226006 );
$c = $p->post_content;
$old = 'http://tire-express.local/wp-content/uploads/2026/06/lifted-truck.jpg';
$new = '/wp-content/uploads/2026/06/new-tires-and-wheels-on-a-f-250.webp';
if ( false === strpos( $c, $old ) ) { echo strpos( $c, $new ) !== false ? "already swapped\n" : "old URL not found — no change\n"; exit; }
$c = str_replace( $old, $new, $c );
// fix the alt on that img if it's the generic one
$c = str_replace( 'alt="Lifted truck', 'alt="New off-road tires and wheels on a Ford F-250', $c );
wp_update_post( array( 'ID' => 226006, 'post_content' => $c ) );
echo "swapped\n";
