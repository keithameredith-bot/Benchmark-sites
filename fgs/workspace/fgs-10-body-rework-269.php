<?php
/**
 * fgs-10-body-rework-269.php — Body design rework, EXEMPLAR page 269 (Foundation Engineering).
 * Keith 2026-06-11: kill the gray/white full-width banding; one clean canvas, card-driven rhythm.
 *
 * New pattern (copy preserved verbatim — extracted from the existing markup, re-wrapped):
 *   intro prose (lede styling via CSS) ->
 *   "Why Florida" 5-card grid ->
 *   Foundation Systems card grid (kept, band removed) ->
 *   Process as numbered steps in a blush panel ->
 *   Residential/Commercial split cards ->
 *   Related Services link tiles ->
 *   FAQ accordion (band removed) ->
 *   Author card (blush + maroon edge) ->
 *   CTA as deep-maroon shine panel.
 *
 * Idempotent: skips any row already converted. Usage: wp eval-file fgs-10-body-rework-269.php
 */

$page_id = 269;
$post    = get_post( $page_id );
$content = $post->post_content;
$orig    = $content;

/** Depth-aware extraction of one rowlayout block by uniqueID. Returns [start, end] or null. */
function fgs_row_bounds( $content, $uid ) {
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

function fgs_get_row( $content, $uid ) {
	$b = fgs_row_bounds( $content, $uid );
	return $b ? substr( $content, $b[0], $b[1] - $b[0] ) : null;
}

function fgs_replace_row( $content, $uid, $new_row ) {
	$b = fgs_row_bounds( $content, $uid );
	if ( ! $b ) {
		WP_CLI::error( "row {$uid} not found" );
	}
	return substr( $content, 0, $b[0] ) . $new_row . substr( $content, $b[1] );
}

function fgs_h3s( $row ) {
	preg_match_all( '#<h3 class="wp-block-heading[^>]*>(.*?)</h3>#s', $row, $m );
	return $m[1];
}

function fgs_ps( $row ) {
	preg_match_all( '#<p class="has-text-color"[^>]*>(.*?)</p>#s', $row, $m );
	return $m[1];
}

/** Standard wrapper: white contained row holding one custom-HTML block. */
function fgs_html_row( $uid, $colid, $pad_top, $pad_bottom, $html ) {
	return '<!-- wp:kadence/rowlayout {"uniqueID":"' . $uid . '","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[' . $pad_top . ',"",' . $pad_bottom . ',""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"' . $colid . '","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column' . $colid . ' inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
' . $html . '
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->';
}

// ---------------- 1. WHY-FLORIDA row -> 5-card grid ----------------
$uid = '269_6ff31f-58';
$row = fgs_get_row( $content, $uid );
if ( $row && false === strpos( $row, 'fgs-why-grid' ) ) {
	$h3s = fgs_h3s( $row );
	$ps  = fgs_ps( $row );
	if ( count( $h3s ) !== 5 || count( $ps ) !== 5 ) {
		WP_CLI::error( 'why-row: expected 5 h3/p pairs, got ' . count( $h3s ) . '/' . count( $ps ) );
	}
	$cards = '';
	for ( $i = 0; $i < 5; $i++ ) {
		$cards .= '  <div class="fgs-why-card"><h3>' . $h3s[ $i ] . '</h3><p>' . $ps[ $i ] . '</p></div>' . "\n";
	}
	$html = '<div class="fgs-process-header">
  <span class="kicker">The Florida Factor</span>
  <h2>Why Florida Foundation Engineering Is Its Own Thing</h2>
</div>
<div class="fgs-why-grid">
' . rtrim( $cards ) . '
</div>';
	$content = fgs_replace_row( $content, $uid, fgs_html_row( $uid, '_p6why_c1', 64, 32, $html ) );
	WP_CLI::log( 'why-row: converted to card grid.' );
} else {
	WP_CLI::log( 'why-row: already converted or missing — skip.' );
}

// ---------------- 2. SYSTEMS row: remove gray band ----------------
$content = str_replace(
	'<!-- wp:kadence/rowlayout {"uniqueID":"269_ae7e77-18","columns":1,"colLayout":"equal","bgColor":"#f3f3f3","align":"full","padding":[80,"",80,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignfull"} -->',
	'<!-- wp:kadence/rowlayout {"uniqueID":"269_ae7e77-18","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[32,"",32,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->',
	$content, $n1
);
WP_CLI::log( 'systems-row band removed: ' . ( $n1 ? 'yes' : 'already done' ) );

// ---------------- 3. PROCESS row -> numbered steps in blush panel ----------------
$uid = '269_83fe10-a8';
$row = fgs_get_row( $content, $uid );
if ( $row && false === strpos( $row, 'fgs-steps-panel' ) ) {
	$h3s = fgs_h3s( $row );
	$ps  = fgs_ps( $row );
	if ( count( $h3s ) !== 4 || count( $ps ) !== 5 ) {
		WP_CLI::error( 'process-row: expected 4 h3 + 5 p, got ' . count( $h3s ) . '/' . count( $ps ) );
	}
	$intro = $ps[0];
	$steps = '';
	for ( $i = 0; $i < 4; $i++ ) {
		$title  = preg_replace( '#^\d+\.\s*#', '', $h3s[ $i ] );
		$steps .= '    <li><div class="fgs-step-num">' . ( $i + 1 ) . '</div><div class="fgs-step-body"><h3>' . $title . '</h3><p>' . $ps[ $i + 1 ] . '</p></div></li>' . "\n";
	}
	$html = '<div class="fgs-steps-panel">
  <div class="fgs-process-header" style="margin-bottom:36px">
    <span class="kicker">Our Process</span>
    <h2>How FGS Actually Does It</h2>
    <p>' . $intro . '</p>
  </div>
  <ol class="fgs-steps">
' . rtrim( $steps ) . '
  </ol>
</div>';
	$content = fgs_replace_row( $content, $uid, fgs_html_row( $uid, '_p6process_c1', 32, 32, $html ) );
	WP_CLI::log( 'process-row: converted to step panel.' );
} else {
	WP_CLI::log( 'process-row: already converted or missing — skip.' );
}

// ---------------- 4. RES/COM row -> split cards ----------------
$uid = '269_23a4ec-9a';
$row = fgs_get_row( $content, $uid );
if ( $row && false === strpos( $row, 'fgs-split' ) ) {
	$h3s = fgs_h3s( $row );
	$ps  = fgs_ps( $row );
	if ( count( $h3s ) !== 2 || count( $ps ) !== 2 ) {
		WP_CLI::error( 'rescom-row: expected 2/2, got ' . count( $h3s ) . '/' . count( $ps ) );
	}
	$html = '<div class="fgs-process-header">
  <span class="kicker">Who We Work With</span>
  <h2>Residential vs. Commercial Foundation Work</h2>
</div>
<div class="fgs-split">
  <div class="fgs-split-card"><h3>' . $h3s[0] . '</h3><p>' . $ps[0] . '</p></div>
  <div class="fgs-split-card"><h3>' . $h3s[1] . '</h3><p>' . $ps[1] . '</p></div>
</div>';
	$content = fgs_replace_row( $content, $uid, fgs_html_row( $uid, '_p6rescom_c1', 32, 32, $html ) );
	WP_CLI::log( 'rescom-row: converted to split cards.' );
} else {
	WP_CLI::log( 'rescom-row: already converted or missing — skip.' );
}

// ---------------- 5. RELATED row -> link tiles ----------------
$uid = '269_e2ddc0-29';
$row = fgs_get_row( $content, $uid );
if ( $row && false === strpos( $row, 'fgs-tile-grid' ) ) {
	preg_match_all( '#<li[^>]*>\s*(?:<strong>)?<a href="([^"]+)"[^>]*>(.*?)</a>(?:</strong>)?\s*(?:—|&\#8212;|&mdash;)\s*(.*?)\s*</li>#su', $row, $m, PREG_SET_ORDER );
	if ( count( $m ) < 4 ) {
		WP_CLI::error( 'related-row: only matched ' . count( $m ) . ' tiles' );
	}
	$intro_ps = fgs_ps( $row );
	$tiles    = '';
	foreach ( $m as $t ) {
		$tiles .= '  <a class="fgs-tile" href="' . $t[1] . '"><strong>' . $t[2] . '</strong><span>' . $t[3] . '</span></a>' . "\n";
	}
	$html = '<div class="fgs-process-header">
  <span class="kicker">Keep Exploring</span>
  <h2>Related Services</h2>
  <p>' . ( $intro_ps[0] ?? '' ) . '</p>
</div>
<div class="fgs-tile-grid">
' . rtrim( $tiles ) . '
</div>';
	$content = fgs_replace_row( $content, $uid, fgs_html_row( $uid, '_p6related_c1', 32, 16, $html ) );
	WP_CLI::log( 'related-row: converted to ' . count( $m ) . ' tiles.' );
} else {
	WP_CLI::log( 'related-row: already converted or missing — skip.' );
}

// ---------------- 6. FAQ row: remove gray band ----------------
$content = str_replace(
	'<!-- wp:kadence/rowlayout {"uniqueID":"269_299168-a4","columns":1,"colLayout":"equal","bgColor":"#f3f3f3","align":"full",',
	'<!-- wp:kadence/rowlayout {"uniqueID":"269_299168-a4","columns":1,"colLayout":"equal","bgColor":"#ffffff",',
	$content, $n2
);
$content = preg_replace_callback(
	'#(<!-- wp:kadence/rowlayout \{"uniqueID":"269_299168-a4".*?"className":"wp-block-kadence-rowlayout) alignfull(".*?-->)#s',
	function ( $m ) { return $m[1] . ' alignnone' . $m[2]; },
	$content
);
WP_CLI::log( 'faq-row band removed: ' . ( $n2 ? 'yes' : 'already done' ) );

// ---------------- 7. AUTHOR group -> blush card with class ----------------
$row = fgs_get_row( $content, '269_30f2f8-9f' );
if ( $row && false === strpos( $row, 'fgs-author' ) ) {
	$new_row = str_replace(
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
	$content = fgs_replace_row( $content, '269_30f2f8-9f', $new_row );
	WP_CLI::log( 'author-group: blush card class applied.' );
} else {
	WP_CLI::log( 'author-group: already converted or missing — skip.' );
}

// ---------------- 8. CTA row: band removed + fgs-cta class ----------------
$row = fgs_get_row( $content, '269_829bef-68' );
if ( $row && false === strpos( $row, 'fgs-cta' ) ) {
	$new_row = str_replace(
		array(
			'"bgColor":"#f3f3f3","align":"full"',
			'"className":"wp-block-kadence-rowlayout alignfull"',
			'wp:group {"style":{"color":{"background":"#ffffff"}',
			'<div class="wp-block-group has-background" style="border-radius:24px;background-color:#ffffff',
		),
		array(
			'"bgColor":"#ffffff"',
			'"className":"wp-block-kadence-rowlayout alignnone"',
			'wp:group {"className":"fgs-cta","style":{"color":{"background":"#ffffff"}',
			'<div class="wp-block-group fgs-cta has-background" style="border-radius:24px;background-color:#ffffff',
		),
		$row
	);
	$content = fgs_replace_row( $content, '269_829bef-68', $new_row );
	WP_CLI::log( 'cta-row: shine class applied, band removed.' );
} else {
	WP_CLI::log( 'cta-row: already converted or missing — skip.' );
}

// ---------------- write ----------------
if ( $content === $orig ) {
	WP_CLI::success( 'No content changes needed.' );
} else {
	$r = wp_update_post( array( 'ID' => $page_id, 'post_content' => wp_slash( $content ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( 'page 269 written: ' . strlen( $orig ) . ' -> ' . strlen( $content ) . ' chars.' );
}

// ---------------- CSS (marker-replaced each run) ----------------
$marker_s = '/* fgs-body-pattern:start */';
$marker_e = '/* fgs-body-pattern:end */';
$css_new  = <<<'CSS'
/* — Body pattern: cards on one clean canvas — */
.fgs-why-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;max-width:1100px;margin:0 auto}
.fgs-why-card{background:#fbfbfb;border:1px solid #ece7e4;border-left:4px solid #a91513;border-radius:16px;padding:30px 32px;transition:transform .2s ease,box-shadow .2s ease}
.fgs-why-card:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(96,0,0,.09)}
.fgs-why-grid .fgs-why-card:last-child{grid-column:1/-1}
.fgs-why-card h3{margin:0 0 10px;font-size:20px;font-weight:800;color:#2d2d2d;line-height:1.3}
.fgs-why-card p{margin:0;font-size:15.5px;line-height:1.65;color:#454545}
.fgs-why-card p a{color:#a91513;font-weight:700}
.fgs-steps-panel{background:#f0e5e5;border-radius:24px;padding:56px 48px;max-width:1100px;margin:0 auto;box-shadow:inset 0 2px 0 rgba(255,255,255,.65)}
.fgs-steps{list-style:none;margin:0 auto;padding:0;max-width:780px}
.fgs-steps li{display:flex;gap:24px;padding:26px 0;border-bottom:1px solid rgba(169,21,19,.14)}
.fgs-steps li:last-child{border-bottom:0;padding-bottom:6px}
.fgs-step-num{flex:0 0 48px;height:48px;border-radius:50%;background:linear-gradient(180deg,#a91513,#7c0e0d);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:18px;box-shadow:0 4px 14px rgba(96,0,0,.28)}
.fgs-step-body h3{margin:2px 0 8px;font-size:20px;font-weight:800;color:#2d2d2d;line-height:1.3}
.fgs-step-body p{margin:0;font-size:15.5px;line-height:1.65;color:#454545}
.fgs-split{display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:1100px;margin:0 auto}
.fgs-split-card{background:#fff;border:1px solid #ece7e4;border-top:5px solid #a91513;border-radius:18px;padding:38px 36px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
.fgs-split-card h3{margin:0 0 12px;font-size:22px;font-weight:800;color:#2d2d2d}
.fgs-split-card p{margin:0;font-size:15.5px;line-height:1.68;color:#454545}
.fgs-tile-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;max-width:1100px;margin:0 auto}
.fgs-tile{display:block;background:#fff;border:1px solid #e9e4e1;border-radius:14px;padding:24px 26px;text-decoration:none;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease}
.fgs-tile:hover{border-color:#a91513;transform:translateY(-3px);box-shadow:0 12px 28px rgba(96,0,0,.10)}
.fgs-tile strong{display:block;color:#2d2d2d;font-size:16.5px;font-weight:800;margin-bottom:6px;line-height:1.3}
.fgs-tile:hover strong{color:#a91513}
.fgs-tile span{display:block;color:#676767;font-size:14px;line-height:1.55}
.fgs-author{border-left:6px solid #a91513 !important}
.fgs-cta{background:radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,.08),transparent 60%),linear-gradient(180deg,#6e0a0c 0%,#400303 55%,#270000 100%) !important;box-shadow:0 22px 50px -20px rgba(40,0,0,.5),inset 0 2px 0 0 rgba(255,255,255,.15)}
.fgs-cta h2{color:#fff !important}
.fgs-cta p{color:rgba(255,255,255,.88) !important}
.fgs-cta .wp-block-button:not(.is-style-outline) .wp-block-button__link{background:#fff !important;color:#5c0606 !important;box-shadow:0 12px 30px rgba(0,0,0,.28)}
.fgs-cta .wp-block-button:not(.is-style-outline) .wp-block-button__link svg{fill:#5c0606}
.fgs-cta .wp-block-button.is-style-outline .wp-block-button__link{background:rgba(255,255,255,.08) !important;color:#fff !important;border-color:rgba(255,255,255,.72) !important}
.page-id-269 .kb-row-layout-id269_48604e-48 p:first-of-type{font-size:20px;line-height:1.65;color:#2d2d2d}
@media (max-width:860px){
  .fgs-why-grid,.fgs-split,.fgs-tile-grid{grid-template-columns:1fr}
  .fgs-steps-panel{padding:36px 22px;border-radius:18px}
  .fgs-steps li{gap:16px;padding:20px 0}
  .fgs-step-num{flex-basis:40px;height:40px;font-size:16px}
  .fgs-why-card,.fgs-split-card{padding:26px 22px}
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $marker_s, '#' ) . '.*?' . preg_quote( $marker_e, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $marker_s . "\n" . $css_new . "\n" . $marker_e . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Body pattern CSS written.' );
