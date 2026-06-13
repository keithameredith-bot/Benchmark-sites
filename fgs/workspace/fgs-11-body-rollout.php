<?php
/**
 * fgs-11-body-rollout.php — Roll the page-269 body pattern out to the remaining pages.
 * Shape-based row classification (per _all-structure.txt mapping, 2026-06-12):
 *
 *   gray band (#f3f3f3 + alignfull) containing:
 *     RAWHTML or ACCORDION ............... de-band only (white row, alignnone)
 *     H2 + >=3 H3-with-paragraph, no list . convert to fgs-why-grid card grid
 *     H2 ~ "Related/Full Range" + link-dash list -> fgs-tile-grid (if >=4 items parse)
 *     H2 + buttons (closing CTA) .......... de-band + fgs-cta class on inner group
 *     anything else ....................... de-band only
 *   white row containing group bg #f3f3f3 + 1 H3 ("About the Author") -> fgs-author blush card
 *   #2d2d2d rows (home dark band) left untouched.
 *
 * Pages: 9 service pages + about + home + contact. Page 269 already done (fgs-10).
 * Dry run default; FGS_APPLY=1 to write. Idempotent (converted rows no longer match).
 */

$apply = (bool) getenv( 'FGS_APPLY' );
WP_CLI::log( $apply ? '== APPLY ==' : '== DRY RUN ==' );

$page_ids = array( 146, 167, 202, 205, 216, 223, 225, 230, 264, 92, 90, 94 );

function fgs11_row_bounds( $content, $uid ) {
	$open  = '<!-- wp:kadence/rowlayout {"uniqueID":"' . $uid . '"';
	$start = strpos( $content, $open );
	if ( false === $start ) {
		return null;
	}
	$open_tok  = '<!-- wp:kadence/rowlayout';
	$close_tok = '<!-- /wp:kadence/rowlayout -->';
	$depth     = 0;
	$pos       = $start;
	while ( true ) {
		$no = strpos( $content, $open_tok, $pos );
		$nc = strpos( $content, $close_tok, $pos );
		if ( false === $nc ) {
			return null;
		}
		if ( false !== $no && $no < $nc ) {
			$depth++;
			$pos = $no + strlen( $open_tok );
		} else {
			$depth--;
			$pos = $nc + strlen( $close_tok );
			if ( 0 === $depth ) {
				return array( $start, $pos );
			}
		}
	}
}

function fgs11_html_row( $uid, $colid, $html ) {
	return '<!-- wp:kadence/rowlayout {"uniqueID":"' . $uid . '","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[48,"",32,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"' . $colid . '","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column' . $colid . ' inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
' . $html . '
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->';
}

/** Ordered walk of h3/p tokens; returns [intro_ps[], pairs[ [h3, joined_ps] ]] */
function fgs11_sections( $row ) {
	preg_match_all( '#<(h3) class="wp-block-heading[^>]*>(.*?)</h3>|<(p) class="has-text-color"[^>]*>(.*?)</p>#s', $row, $m, PREG_SET_ORDER );
	$intro = array();
	$pairs = array();
	$cur   = null;
	foreach ( $m as $tok ) {
		if ( ! empty( $tok[1] ) ) { // h3
			if ( null !== $cur ) {
				$pairs[] = $cur;
			}
			$cur = array( $tok[2], array() );
		} else { // p
			if ( null === $cur ) {
				$intro[] = $tok[4];
			} else {
				$cur[1][] = $tok[4];
			}
		}
	}
	if ( null !== $cur ) {
		$pairs[] = $cur;
	}
	return array( $intro, $pairs );
}

function fgs11_deband( $row ) {
	$row = preg_replace( '#("uniqueID":"[^"]+","columns":\d+,"colLayout":"[^"]+"),"bgColor":"\#f3f3f3","align":"full"#', '$1,"bgColor":"#ffffff"', $row, 1 );
	$row = str_replace( '"className":"wp-block-kadence-rowlayout alignfull"', '"className":"wp-block-kadence-rowlayout alignnone"', $row );
	return $row;
}

global $wpdb;

foreach ( $page_ids as $pid ) {
	$post    = get_post( $pid );
	$content = $post->post_content;
	$orig    = $content;
	WP_CLI::log( "---- {$pid} {$post->post_name}" );

	// collect top-level row uids
	preg_match_all( '#<!-- wp:kadence/rowlayout \{"uniqueID":"([^"]+)"#', $content, $um );
	$uids = array_unique( $um[1] );

	foreach ( $uids as $uid ) {
		$b = fgs11_row_bounds( $content, $uid );
		if ( ! $b ) {
			continue;
		}
		$row     = substr( $content, $b[0], $b[1] - $b[0] );
		$is_gray = ( false !== strpos( $row, '"bgColor":"#f3f3f3","align":"full"' ) );

		// -------- author card (white row, gray inner group, single H3) --------
		if ( ! $is_gray && false !== strpos( $row, 'background-color:#f3f3f3' ) && false !== strpos( $row, 'About the Author' ) && false === strpos( $row, 'fgs-author' ) ) {
			$new = str_replace(
				array(
					'wp:group {"style":{"color":{"background":"#f3f3f3"}',
					'<div class="wp-block-group has-background" style="border-radius:24px;background-color:#f3f3f3',
				),
				array(
					'wp:group {"className":"fgs-author","style":{"color":{"background":"#f0e5e5"}',
					'<div class="wp-block-group fgs-author has-background" style="border-radius:24px;background-color:#f0e5e5',
				),
				$row
			);
			if ( $new !== $row ) {
				$content = substr( $content, 0, $b[0] ) . $new . substr( $content, $b[1] );
				WP_CLI::log( "  {$uid}: AUTHOR -> blush card" );
			}
			continue;
		}

		if ( ! $is_gray ) {
			continue;
		}

		$has_html = ( false !== strpos( $row, '<!-- wp:html' ) );
		$has_acc  = ( false !== strpos( $row, 'wp:kadence/accordion' ) );
		$has_list = ( false !== strpos( $row, 'wp:list-item' ) );
		$has_btn  = ( false !== strpos( $row, '<!-- wp:buttons' ) );
		preg_match( '#<h2 class="wp-block-heading[^>]*>(.*?)</h2>#s', $row, $h2m );
		$h2 = isset( $h2m[1] ) ? $h2m[1] : '';

		// -------- CTA --------
		if ( $has_btn && '' !== $h2 && ! $has_acc && ! $has_html ) {
			$new = fgs11_deband( $row );
			$new = str_replace(
				array(
					'wp:group {"style":{"color":{"background":"#ffffff"}',
					'<div class="wp-block-group has-background" style="border-radius:24px;background-color:#ffffff',
				),
				array(
					'wp:group {"className":"fgs-cta","style":{"color":{"background":"#ffffff"}',
					'<div class="wp-block-group fgs-cta has-background" style="border-radius:24px;background-color:#ffffff',
				),
				$new
			);
			$content = substr( $content, 0, $b[0] ) . $new . substr( $content, $b[1] );
			WP_CLI::log( "  {$uid}: CTA -> shine panel + de-band ({$h2})" );
			continue;
		}

		// -------- tiles (related/full-range link lists) --------
		if ( $has_list && preg_match( '#Related Services|Full Range#i', $h2 ) ) {
			preg_match_all( '#<li[^>]*>\s*(?:<strong>)?<a href="([^"]+)"[^>]*>(.*?)</a>(?:</strong>)?\s*(?:—|&\#8212;|&mdash;)\s*(.*?)\s*</li>#su', $row, $tm, PREG_SET_ORDER );
			if ( count( $tm ) >= 4 ) {
				list( $intro ) = fgs11_sections( $row );
				$tiles = '';
				foreach ( $tm as $t ) {
					$tiles .= '  <a class="fgs-tile" href="' . $t[1] . '"><strong>' . $t[2] . '</strong><span>' . $t[3] . '</span></a>' . "\n";
				}
				$html = '<div class="fgs-process-header">
  <h2>' . $h2 . '</h2>' . ( $intro ? "\n  <p>" . $intro[0] . '</p>' : '' ) . '
</div>
<div class="fgs-tile-grid">
' . rtrim( $tiles ) . '
</div>';
				$colid   = '_cv' . substr( md5( $uid ), 0, 6 ) . '_c1';
				$content = substr( $content, 0, $b[0] ) . fgs11_html_row( $uid, $colid, $html ) . substr( $content, $b[1] );
				WP_CLI::log( "  {$uid}: TILES x" . count( $tm ) . " ({$h2})" );
				continue;
			}
		}

		// -------- card grid (H2 + >=3 H3-with-text, no lists/html/accordion) --------
		if ( ! $has_html && ! $has_acc && ! $has_list && '' !== $h2 ) {
			list( $intro, $pairs ) = fgs11_sections( $row );
			$all_have_text = count( $pairs ) >= 3;
			foreach ( $pairs as $pr ) {
				if ( empty( $pr[1] ) ) {
					$all_have_text = false;
				}
			}
			if ( $all_have_text ) {
				$cards = '';
				foreach ( $pairs as $pr ) {
					$cards .= '  <div class="fgs-why-card"><h3>' . $pr[0] . '</h3><p>' . implode( '</p><p>', $pr[1] ) . '</p></div>' . "\n";
				}
				$html = '<div class="fgs-process-header">
  <h2>' . $h2 . '</h2>' . ( $intro ? "\n  <p>" . implode( ' ', $intro ) . '</p>' : '' ) . '
</div>
<div class="fgs-why-grid">
' . rtrim( $cards ) . '
</div>';
				$colid   = '_cv' . substr( md5( $uid ), 0, 6 ) . '_c1';
				$content = substr( $content, 0, $b[0] ) . fgs11_html_row( $uid, $colid, $html ) . substr( $content, $b[1] );
				WP_CLI::log( "  {$uid}: GRID x" . count( $pairs ) . " ({$h2})" );
				continue;
			}
		}

		// -------- default: de-band --------
		$new = fgs11_deband( $row );
		if ( $new !== $row ) {
			$content = substr( $content, 0, $b[0] ) . $new . substr( $content, $b[1] );
			$what    = $has_html ? 'RAWHTML' : ( $has_acc ? 'ACCORDION' : 'prose' );
			WP_CLI::log( "  {$uid}: DE-BAND ({$what}" . ( $h2 ? ": {$h2}" : '' ) . ')' );
		}
	}

	if ( $content === $orig ) {
		WP_CLI::log( '  no changes.' );
		continue;
	}
	if ( $apply ) {
		$r = wp_update_post( array( 'ID' => $pid, 'post_content' => wp_slash( $content ) ), true );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( "{$pid}: " . $r->get_error_message() );
		}
		WP_CLI::log( '  WRITTEN ' . strlen( $orig ) . ' -> ' . strlen( $content ) );
	}
}

// CSS amendment: only span the last grid card across both columns when the count is odd.
$amend_marker = '/* fgs-grid-even-fix */';
$css          = (string) wp_get_custom_css();
if ( false === strpos( $css, $amend_marker ) ) {
	$css .= "\n" . $amend_marker . "\n.fgs-why-grid .fgs-why-card:last-child:nth-child(even){grid-column:auto}\n";
	if ( $apply ) {
		wp_update_custom_css_post( $css );
		WP_CLI::log( 'CSS even-count grid fix appended.' );
	} else {
		WP_CLI::log( 'CSS even-count grid fix pending (apply mode).' );
	}
}

WP_CLI::success( $apply ? 'Rollout applied.' : 'Dry run complete.' );
