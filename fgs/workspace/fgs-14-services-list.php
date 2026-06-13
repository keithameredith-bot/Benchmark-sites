<?php
/**
 * fgs-14-services-list.php — Replace the homepage 9-box services grid with the live
 * Astro site's signature interactive service list: hairline-divided rows
 * (title | hover-reveal photo | description | arrow chip); on hover the row floods
 * with the maroon gradient, text flips white, photo fades in tilted, arrow levels out.
 * Copy reused verbatim from the existing infoboxes. Contained at 1180px (fixes
 * "boxes touching the side"). Photo slots: 5 real FGS photos where they match,
 * placeholders elsewhere — single list below, easy to swap when client images land.
 * Idempotent. Usage: wp eval-file fgs-14-services-list.php
 */

$post    = get_post( 90 );
$content = $post->post_content;

if ( false !== strpos( $content, 'fgs-svc-list' ) ) {
	WP_CLI::log( 'services list already present — content step skipped.' );
} else {

	$services = array(
		array( 'Geotechnical Engineering', 'Stamped reports, foundation recommendations, and subsurface investigations.', '/geotechnical-engineering-services-florida/', 'https://placehold.co/726x482/f0e5e5/a91513?text=Photo+Coming' ),
		array( 'Sinkhole Investigation', 'GPR, SPT borings, and FL Statute 627.707-compliant evaluations.', '/sinkhole-investigation-florida/', '/wp-content/uploads/2026/05/fgs-cat-excavator-deep-sinkhole-excavation-soil-stratigraphy-florida.jpg' ),
		array( 'Geotechnical Drilling', 'SPT borings, CPT, rock coring, and direct push with modern rigs.', '/geotechnical-drilling-services-florida/', '/wp-content/uploads/2026/05/fgs-company-truck-excavator-site-investigation-florida-geotechnical.jpg' ),
		array( 'Soil Testing &amp; Lab', 'FDOT &amp; CMEC accredited in-house lab. Proctor, LBR, Atterberg, more.', '/soil-testing-laboratory-services-florida/', 'https://placehold.co/726x482/f0e5e5/a91513?text=Photo+Coming' ),
		array( 'Construction Materials Testing', 'FDOT-accredited CMT for concrete, asphalt, soils, and aggregate.', '/construction-materials-testing-florida/', '/wp-content/uploads/2026/05/fgs-roadway-materials-testing-crew-truck-compaction-florida.jpg' ),
		array( 'Concrete &amp; Asphalt Testing', 'Accredited testing. Cylinder breaks, Superpave, density coring.', '/concrete-and-asphalt-testing-florida/', '/wp-content/uploads/2026/05/fgs-concrete-core-drilling-precast-structure-team-florida.jpg' ),
		array( 'Foundation Engineering', 'Bearing capacity, pile design, helical piers, settlement analysis.', '/foundation-engineering-florida/', '/wp-content/uploads/2026/05/fgs-concrete-core-drilling-wall-workers-florida-geotechnical-services.jpg' ),
		array( 'Ground Penetrating Radar', 'Sinkhole detection, utility locating, void detection, concrete scanning.', '/ground-penetrating-radar-gpr-florida/', 'https://placehold.co/726x482/f0e5e5/a91513?text=Photo+Coming' ),
		array( 'Environmental Site Assessment', 'ASTM E1527-21 Phase I &amp; Phase II ESA for buyers, lenders, developers.', '/environmental-site-assessment-florida/', 'https://placehold.co/726x482/f0e5e5/a91513?text=Photo+Coming' ),
		array( 'Pavement Design &amp; Evaluation', 'FDOT-compliant flexible &amp; rigid pavement design, FWD testing.', '/pavement-design-evaluation-florida/', 'https://placehold.co/726x482/f0e5e5/a91513?text=Photo+Coming' ),
	);

	$rows = '';
	foreach ( $services as $s ) {
		$alt   = wp_strip_all_tags( html_entity_decode( $s[0] ) ) . ' — Florida Geotechnical Services';
		$rows .= '  <a class="fgs-svc" href="' . $s[2] . '">
    <span class="fgs-svc__bg"></span>
    <h3 class="fgs-svc__t">' . $s[0] . '</h3>
    <span class="fgs-svc__img"><img src="' . $s[3] . '" alt="' . esc_attr( $alt ) . '" loading="lazy"></span>
    <p class="fgs-svc__d">' . $s[1] . '</p>
    <span class="fgs-svc__arrow">&rarr;</span>
  </a>
';
	}

	$html = '<div class="fgs-svc-wrap">
  <div class="fgs-svc-head">
    <span class="fgs-svc-kicker">What We Do</span>
    <h2>Full-Scope Geotechnical &amp; Testing Services</h2>
    <p>Ten service lines, one firm, one accredited lab — from the first boring to the final stamped report.</p>
  </div>
  <div class="fgs-svc-list">
' . rtrim( $rows ) . '
  </div>
</div>';

	$new_section = '<!-- wp:kadence/rowlayout {"uniqueID":"90_8svc14-aa","columns":1,"colLayout":"equal","bgColor":"#ffffff","padding":[48,"",48,""],"kbVersion":2,"className":"wp-block-kadence-rowlayout alignnone"} -->
<!-- wp:kadence/column {"borderWidth":["","","",""],"uniqueID":"_hpsvclist_c1","kbVersion":2,"className":"inner-column-1"} -->
<div class="wp-block-kadence-column kadence-column_hpsvclist_c1 inner-column-1"><div class="kt-inside-inner-col"><!-- wp:html -->
' . $html . '
<!-- /wp:html --></div></div>
<!-- /wp:kadence/column -->
<!-- /wp:kadence/rowlayout -->';

	// depth-aware row removal
	$bounds = function ( $c, $uid ) {
		$open  = '<!-- wp:kadence/rowlayout {"uniqueID":"' . $uid . '"';
		$start = strpos( $c, $open );
		if ( false === $start ) {
			return null;
		}
		$ot = '<!-- wp:kadence/rowlayout';
		$ct = '<!-- /wp:kadence/rowlayout -->';
		$d  = 0;
		$p  = $start;
		while ( true ) {
			$no = strpos( $c, $ot, $p );
			$nc = strpos( $c, $ct, $p );
			if ( false === $nc ) {
				return null;
			}
			if ( false !== $no && $no < $nc ) {
				$d++;
				$p = $no + strlen( $ot );
			} else {
				$d--;
				$p = $nc + strlen( $ct );
				if ( 0 === $d ) {
					return array( $start, $p );
				}
			}
		}
	};

	// replace the header row with the new section
	$b = $bounds( $content, '90_5b9eea-62' );
	if ( ! $b ) {
		WP_CLI::error( 'services header row not found' );
	}
	$content = substr( $content, 0, $b[0] ) . $new_section . substr( $content, $b[1] );
	WP_CLI::log( 'header row replaced with fgs-svc section.' );

	// remove the four infobox rows
	foreach ( array( '90_4828d4-d2', '90_5cd21c-87', '90_9c1772-1c', '90_b8807c-3f' ) as $uid ) {
		$b = $bounds( $content, $uid );
		if ( $b ) {
			$content = substr( $content, 0, $b[0] ) . ltrim( substr( $content, $b[1] ), "\n" );
			WP_CLI::log( "removed infobox row {$uid}." );
		}
	}

	$r = wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $content ) ), true );
	if ( is_wp_error( $r ) ) {
		WP_CLI::error( $r->get_error_message() );
	}
	WP_CLI::log( 'homepage written.' );
}

// ---------- CSS ----------
$ms  = '/* fgs-svc:start */';
$me  = '/* fgs-svc:end */';
$new = <<<'CSS'
/* — Interactive service list (live-site treatment) — */
.fgs-svc-wrap{max-width:1180px;margin:0 auto;padding:0 8px}
.fgs-svc-head{text-align:center;max-width:760px;margin:0 auto 30px}
.fgs-svc-kicker{display:inline-block;background:#f0e5e5;color:#a91513;font-weight:700;font-size:13px;letter-spacing:1.5px;text-transform:uppercase;padding:7px 14px;border-radius:8px;margin-bottom:14px}
.fgs-svc-head h2{font-size:40px;font-weight:800;color:#2d2d2d;margin:0 0 10px;line-height:1.15}
.fgs-svc-head p{font-size:17px;color:#676767;margin:0;line-height:1.6}
.fgs-svc-list{border-bottom:1px solid #e6dfdb}
.fgs-svc{position:relative;display:grid;grid-template-columns:3fr 3.2fr 4fr 52px;align-items:center;gap:32px;padding:24px 26px;text-decoration:none;border-top:1px solid #e6dfdb}
.fgs-svc__bg{position:absolute;inset:5px 0;background:radial-gradient(120% 120% at 85% -10%,rgba(255,255,255,.10),transparent 60%),linear-gradient(180deg,#a91513 0%,#7c0e0d 100%);border-radius:18px;opacity:0;transition:opacity .28s ease;z-index:0}
.fgs-svc > *:not(.fgs-svc__bg){position:relative;z-index:1}
.fgs-svc__t{margin:0;font-size:21px;font-weight:800;color:#2d2d2d;line-height:1.25;transition:color .25s ease}
.fgs-svc__img{display:block;height:112px;border-radius:14px;overflow:hidden;opacity:0;transform:rotate(-4deg) scale(.96);transition:opacity .3s ease,transform .3s ease;box-shadow:0 10px 26px rgba(0,0,0,.25)}
.fgs-svc__img img{width:100%;height:100%;object-fit:cover;display:block}
.fgs-svc__d{margin:0;font-size:15px;line-height:1.55;color:#676767;transition:color .25s ease}
.fgs-svc__arrow{display:flex;align-items:center;justify-content:center;width:46px;height:46px;border-radius:50%;background:#2d2d2d;color:#ffffff;font-size:20px;font-weight:700;transform:rotate(-45deg);transition:transform .3s ease,background .3s ease,color .3s ease}
.fgs-svc:hover .fgs-svc__bg{opacity:1}
.fgs-svc:hover .fgs-svc__t{color:#ffffff}
.fgs-svc:hover .fgs-svc__d{color:rgba(255,255,255,.92)}
.fgs-svc:hover .fgs-svc__img{opacity:1;transform:rotate(-3deg) scale(1)}
.fgs-svc:hover .fgs-svc__arrow{background:#ffffff;color:#a91513;transform:rotate(0deg)}
@media (max-width:1024px){
  .fgs-svc{grid-template-columns:1fr 44px;gap:8px 16px;padding:20px 8px}
  .fgs-svc__img{display:none}
  .fgs-svc__d{grid-column:1 / -1}
  .fgs-svc__arrow{width:40px;height:40px;font-size:17px;grid-row:1;grid-column:2}
  .fgs-svc__bg{inset:3px -4px}
  .fgs-svc-head h2{font-size:28px}
}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::success( 'Service list CSS written.' );
