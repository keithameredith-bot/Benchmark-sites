<?php
/**
 * Plugin Name: FGS Share Bar
 * Description: Appends social share buttons to single blog posts (blog only, by design).
 */

add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );

	$bar = '<div class="fgs-share">'
		. '<span class="fgs-share__label">Share This</span>'
		. '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener" aria-label="Share on Facebook"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 21v-7.5h2.5l.5-3h-3V8.6c0-.9.3-1.6 1.6-1.6H16.6V4.3c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.4-4 4.1v2.2H7.5v3h2.7V21h3.3z"/></svg></a>'
		. '<a href="https://twitter.com/intent/tweet?url=' . $url . '&amp;text=' . $title . '" target="_blank" rel="noopener" aria-label="Share on X"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.5 3h3.1l-6.8 7.8L21.8 21h-6.3l-4.9-6.4L5 21H1.9l7.3-8.3L2.2 3h6.4l4.4 5.9L17.5 3zm-1.1 16.1h1.7L6.9 4.8H5.1l11.3 14.3z"/></svg></a>'
		. '<a href="https://www.linkedin.com/sharing/share-offsite/?url=' . $url . '" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3V9zm6.5 0H13v1.7h.05c.5-.9 1.7-1.9 3.5-1.9 3.7 0 4.4 2.4 4.4 5.5V21h-4v-5.9c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1V21h-4V9z"/></svg></a>'
		. '<a href="mailto:?subject=' . $title . '&amp;body=' . $url . '" aria-label="Share by email"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2 5.5A1.5 1.5 0 0 1 3.5 4h17A1.5 1.5 0 0 1 22 5.5v13a1.5 1.5 0 0 1-1.5 1.5h-17A1.5 1.5 0 0 1 2 18.5v-13zm2 .9V18h16V6.4l-7.4 6.2a1 1 0 0 1-1.2 0L4 6.4zM5.6 6l6.4 5.3L18.4 6H5.6z"/></svg></a>'
		. '<button type="button" class="fgs-share__copy" onclick="navigator.clipboard.writeText(\'' . esc_js( get_permalink() ) . '\');this.querySelector(\'span\').textContent=\'Copied!\';"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8 4h10a2 2 0 0 1 2 2v12h-2V6H8V4zm-2 4h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2zm0 2v10h10V10H6z"/></svg><span>Copy Link</span></button>'
		. '</div>';

	return $content . $bar;
}, 50 );
