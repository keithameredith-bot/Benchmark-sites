<?php
// Where does the footer live? Search widgets + Kadence elements for the cv-axle link.
global $wpdb;
$rows = $wpdb->get_results( "SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE '%cv-axle-replacement-ocala%'" );
foreach ( $rows as $r ) { echo "OPTION: {$r->option_name}\n"; }
$posts = $wpdb->get_results( "SELECT ID, post_type, post_title, post_status FROM {$wpdb->posts} WHERE post_content LIKE '%cv-axle-replacement-ocala%' AND post_status NOT IN ('trash','inherit')" );
foreach ( $posts as $p ) { echo "POST: {$p->ID} ({$p->post_type}, {$p->post_status}) {$p->post_title}\n"; }
