<?php
// Cleanup: the quote menu item already had class jsc-menu-quote (styled in child CSS).
// Remove the redundant jsc-menu-cta I added; drawer/pulse CSS now targets jsc-menu-quote.
$classes = get_post_meta( 102184, '_menu_item_classes', true );
if ( ! is_array( $classes ) ) { $classes = array(); }
$classes = array_values( array_diff( $classes, array( 'jsc-menu-cta' ) ) );
if ( empty( $classes ) ) { $classes = array( 'jsc-menu-quote' ); }
if ( ! in_array( 'jsc-menu-quote', $classes, true ) ) { $classes[] = 'jsc-menu-quote'; }
update_post_meta( 102184, '_menu_item_classes', $classes );
echo 'item 102184 classes: ' . implode( ',', $classes ) . "\n";
