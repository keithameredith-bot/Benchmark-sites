<?php
/**
 * fgs-19-footer-polish.php — Keith 2026-06-12 evening batch:
 * 1. Stats band: "2023" stat gains an experience hook (was just "Founded in Ocala").
 * 2. "Built for Florida's Geology" (Ryan & David) -> dark torn band, white card pops on it.
 * 3. Footer rebuild: FGS letters logo (white chip), Services links column, Get Directions
 *    button, jiggle hover on links, copyright/privacy bottom row.
 * 4. Extras: empty middle footer row hidden.
 * Idempotent. Usage: wp eval-file fgs-19-footer-polish.php
 */

// ---------- 1. stats: 2023 -> experience ----------
$p   = get_post( 90 );
$new = str_replace(
	'<div class="fgs-stat"><span class="fgs-stat__n">2023</span><span class="fgs-stat__l">Founded in Ocala, built for Florida</span></div>',
	'<div class="fgs-stat"><span class="fgs-stat__n">Est. 2023</span><span class="fgs-stat__l">Built on decades of Florida field experience</span></div>',
	$p->post_content,
	$n
);
if ( $n ) {
	wp_update_post( array( 'ID' => 90, 'post_content' => wp_slash( $new ) ), true );
	WP_CLI::log( 'stats: 2023 stat strengthened.' );
} else {
	WP_CLI::log( 'stats: already updated or pattern changed.' );
}

// ---------- 2+4. CSS: founders dark band + footer middle row ----------
$ms  = '/* fgs-polish:start */';
$me  = '/* fgs-polish:end */';
$css_new = <<<'CSS'
/* — "Built for Florida's Geology": dark torn band, white card on it — */
.kb-row-layout-id90_ae7ca3-30{
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
  background-color:#2d2d2d !important;
  background-image:
    url(/wp-content/uploads/2026/06/fgs-edge-top-flipped.webp),
    url(/wp-content/uploads/2026/06/fgs-edge-bottom.webp) !important;
  background-position:center top,center bottom !important;
  background-size:100% clamp(36px,4.5vw,84px),100% clamp(32px,4vw,76px) !important;
  background-repeat:no-repeat,no-repeat !important;
}
.kb-row-layout-id90_ae7ca3-30::before{content:none !important} /* sketch off on dark */
.kb-row-layout-id90_ae7ca3-30 > .kt-row-column-wrap{padding-top:110px !important;padding-bottom:110px !important}
/* hide the empty middle footer row so it can't add dead dark space */
.site-middle-footer-wrap:not(:has(.widget)){display:none}
CSS;

$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
$css = rtrim( $css ) . "\n\n" . $ms . "\n" . $css_new . "\n" . $me . "\n";
$r   = wp_update_custom_css_post( $css );
if ( is_wp_error( $r ) ) {
	WP_CLI::error( 'CSS write failed: ' . $r->get_error_message() );
}
WP_CLI::log( 'polish CSS written.' );

// ---------- 3. footer widget rebuild ----------
$footer = <<<'HTML'
<!-- wp:html -->
<style>
.fgs-footer-nap{background:#2d2d2d;padding:56px 24px 28px 24px}
.fgs-footer-nap__inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.6fr 1.4fr 1.1fr 1fr;gap:36px}
@media (max-width:980px){.fgs-footer-nap__inner{grid-template-columns:1fr 1fr;gap:28px}}
@media (max-width:560px){.fgs-footer-nap__inner{grid-template-columns:1fr;gap:24px}}
.fgs-footer-nap h3{color:#ffffff;font-size:17px;font-weight:800;letter-spacing:1px;margin:0 0 12px 0;line-height:1.3}
.fgs-footer-nap h4{color:#e0837c;font-size:13px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin:0 0 12px 0}
.fgs-footer-nap h4 + h4, .fgs-footer-nap p + h4{margin-top:22px}
.fgs-footer-nap p{color:#ffffff;font-size:15px;line-height:1.7;margin:0}
.fgs-footer-nap p.muted{color:#cccccc;line-height:1.6}
.fgs-footer-nap a{color:#ffffff;text-decoration:none}
.fgs-footer-nap a:hover{color:#e0837c}
.fgs-footer-nap .hours{color:#cccccc}
.fgs-f-logo{display:inline-block;background:#ffffff;border-radius:12px;padding:10px 16px;margin-bottom:16px}
.fgs-f-logo img{display:block;width:140px;height:auto}
@keyframes fgsJiggle{0%{transform:translateX(0) rotate(0)}30%{transform:translateX(4px) rotate(.8deg)}55%{transform:translateX(2px) rotate(-.7deg)}80%{transform:translateX(3px) rotate(.4deg)}100%{transform:translateX(3px) rotate(0)}}
.fgs-f-links{list-style:none;margin:0;padding:0;columns:2;column-gap:24px}
@media (max-width:560px){.fgs-f-links{columns:1}}
.fgs-f-links li{margin:0 0 9px;break-inside:avoid}
.fgs-f-links a{display:inline-block;color:#cccccc;font-size:14px;line-height:1.45}
.fgs-f-links a:hover{color:#ffffff;animation:fgsJiggle .45s ease both}
.fgs-footer-nap p a:hover,.fgs-f-directions:hover{animation:fgsJiggle .45s ease both}
.fgs-f-directions{display:inline-block;margin-top:12px;padding:9px 18px;border:1px solid rgba(255,255,255,.45);border-radius:9px;font-size:14px;font-weight:700;color:#ffffff;transition:background .2s ease,border-color .2s ease}
.fgs-f-directions:hover{background:#a91513;border-color:#a91513;color:#ffffff !important}
.fgs-f-bottom{max-width:1200px;margin:44px auto 0;padding-top:20px;border-top:1px solid rgba(255,255,255,.12);color:#999999;font-size:13px;text-align:center}
.fgs-f-bottom a{color:#cccccc}
.fgs-f-bottom a:hover{color:#ffffff}
</style>

<div class="fgs-footer-nap">
  <div class="fgs-footer-nap__inner">

    <div>
      <span class="fgs-f-logo"><img src="/wp-content/uploads/2026/06/fgs-logo-letters.png" alt="FGS — Florida Geotechnical Services" loading="lazy" width="140" height="70"></span>
      <h3>FLORIDA GEOTECHNICAL SERVICES, LLC</h3>
      <p class="muted">FDOT &amp; CMEC accredited geotechnical engineering. 45+ years of engineering experience. Industry-leading turnaround statewide from our Ocala office.</p>
    </div>

    <div>
      <h4>Services</h4>
      <ul class="fgs-f-links">
        <li><a href="/geotechnical-engineering-services-florida/">Geotechnical Engineering</a></li>
        <li><a href="/sinkhole-investigation-florida/">Sinkhole Investigation</a></li>
        <li><a href="/geotechnical-drilling-services-florida/">Geotechnical Drilling</a></li>
        <li><a href="/soil-testing-laboratory-services-florida/">Soil Testing &amp; Lab</a></li>
        <li><a href="/construction-materials-testing-florida/">Materials Testing</a></li>
        <li><a href="/concrete-and-asphalt-testing-florida/">Concrete &amp; Asphalt</a></li>
        <li><a href="/foundation-engineering-florida/">Foundation Engineering</a></li>
        <li><a href="/ground-penetrating-radar-gpr-florida/">Ground Penetrating Radar</a></li>
        <li><a href="/environmental-site-assessment-florida/">Environmental (ESA)</a></li>
        <li><a href="/pavement-design-evaluation-florida/">Pavement Design</a></li>
      </ul>
    </div>

    <div>
      <h4>Contact</h4>
      <p><a href="tel:+13526199292"><strong>(352) 619-9292</strong></a><br><a href="mailto:rtownsend@fgsfl.net" style="color:#cccccc">rtownsend@fgsfl.net</a></p>
      <h4>Office</h4>
      <p>302 SW 33rd Ave<br>Ocala, FL 34474<br><span class="hours">Mon–Fri 8:00am–5:00pm ET</span></p>
      <a class="fgs-f-directions" href="https://maps.google.com/?q=302+SW+33rd+Ave+Ocala+FL+34474" target="_blank" rel="noopener">Get Directions →</a>
    </div>

    <div>
      <h4>Accreditations</h4>
      <p>FDOT Accredited Lab<br>CMEC Accredited<br>Florida P.E. #58334<br>FDOT Work Groups 9.1 – 9.4.1</p>
    </div>

  </div>
  <div class="fgs-f-bottom">© 2026 Florida Geotechnical Services, LLC &nbsp;·&nbsp; <a href="/privacy-policy/">Privacy Policy</a> &nbsp;·&nbsp; Serving all 67 Florida counties from Ocala</div>
</div>
<!-- /wp:html -->
HTML;

$opt = get_option( 'widget_block' );
if ( false !== strpos( $opt[20]['content'], 'fgs-f-links' ) ) {
	WP_CLI::log( 'footer: already rebuilt — skip.' );
} else {
	$opt[20]['content'] = $footer;
	update_option( 'widget_block', $opt );
	WP_CLI::log( 'footer widget rebuilt (logo, services links, directions, jiggle).' );
}

WP_CLI::success( 'Polish round applied.' );
