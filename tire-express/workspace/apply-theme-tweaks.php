<?php
// Sticky header (reveal on scroll up) + blog archive H1. Idempotent.
set_theme_mod( 'header_sticky', 'top_main' );
set_theme_mod( 'header_reveal_scroll_up', true );
set_theme_mod( 'post_archive_title', true );
echo "header_sticky=" . get_theme_mod( 'header_sticky' ) . "\n";
echo "header_reveal_scroll_up=" . var_export( get_theme_mod( 'header_reveal_scroll_up' ), true ) . "\n";
echo "post_archive_title=" . var_export( get_theme_mod( 'post_archive_title' ), true ) . "\n";
