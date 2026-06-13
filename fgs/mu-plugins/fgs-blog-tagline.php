<?php
/**
 * Plugin Name: FGS Blog Tagline
 * Description: Subtitle under the Blog archive title.
 */

add_filter( 'kadence_show_archive_description', function ( $show ) {
	return is_home() ? true : $show;
} );

add_filter( 'get_the_archive_description', function ( $desc ) {
	if ( is_home() ) {
		return '<p>Geotechnical insights for the contractor, the homeowner, and the geotechnical engineering enthusiast.</p>';
	}
	return $desc;
} );
