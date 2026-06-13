<?php
foreach ( wp_get_nav_menus() as $m ) {
	echo "MENU '{$m->name}' (id {$m->term_id}, {$m->count} items)\n";
}
echo "--- locations ---\n";
foreach ( get_nav_menu_locations() as $loc => $term_id ) {
	$m = $term_id ? wp_get_nav_menu_object( $term_id ) : null;
	echo "$loc => " . ( $m ? "'{$m->name}' ({$term_id})" : '(none)' ) . "\n";
}
