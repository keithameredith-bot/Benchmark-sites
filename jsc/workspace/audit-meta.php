<?php
// Title + meta description sweep: every published page/post from wp_aioseo_posts (and rendered fallback).
global $wpdb;
$items = get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'type title', 'order' => 'ASC' ) );
$seen_titles = array(); $seen_descs = array();
foreach ( $items as $p ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT title, description FROM {$wpdb->prefix}aioseo_posts WHERE post_id = %d", $p->ID ) );
	$t = $row->title ?? '';
	$d = $row->description ?? '';
	// resolve smart tags roughly for length judgment
	$t_resolved = str_replace( array( '#post_title', '#site_title', '#separator_sa', '#tagline' ), array( $p->post_title, 'JSC Contracting Inc', '-', '' ), $t );
	$d_resolved = str_replace( array( '#post_title', '#site_title', '#separator_sa' ), array( $p->post_title, 'JSC Contracting Inc', '-' ), $d );
	$flags = array();
	if ( '' === trim( $t ) ) { $flags[] = 'NO-TITLE(default)'; $t_resolved = $p->post_title . ' - JSC Contracting Inc'; }
	if ( '' === trim( $d ) ) { $flags[] = 'NO-DESC'; }
	$tl = mb_strlen( $t_resolved ); $dl = mb_strlen( $d_resolved );
	if ( $tl > 60 ) { $flags[] = "TITLE-LONG($tl)"; }
	if ( $d && $dl > 160 ) { $flags[] = "DESC-LONG($dl)"; }
	if ( $d && $dl < 70 ) { $flags[] = "DESC-SHORT($dl)"; }
	if ( isset( $seen_titles[ $t_resolved ] ) ) { $flags[] = 'DUP-TITLE-OF-' . $seen_titles[ $t_resolved ]; } else { $seen_titles[ $t_resolved ] = $p->post_name; }
	if ( $d && isset( $seen_descs[ $d ] ) ) { $flags[] = 'DUP-DESC-OF-' . $seen_descs[ $d ]; } else if ( $d ) { $seen_descs[ $d ] = $p->post_name; }
	printf( "%s /%s/\n  T(%d): %s\n  D(%d): %s\n%s", strtoupper( $p->post_type[0] ) . $p->ID, $p->post_name, $tl, $t_resolved, $dl, ( $d ?: '——' ), $flags ? '  >> ' . implode( ' | ', $flags ) . "\n" : '' );
}
