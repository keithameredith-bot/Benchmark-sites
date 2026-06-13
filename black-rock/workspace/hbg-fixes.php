<?php
// HBG page: fix download link -> real PDF, fix 6 broken slugs, add Florida Survival content.
// Then delete stock Kadence pages + demo menus.
global $wpdb;

$pdfUrl = wp_get_attachment_url(987515464);
echo "PDF url: $pdfUrl\n";

$pid = 771;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (!get_post_meta($pid, '_brm_hbg_backup', true)) add_post_meta($pid, '_brm_hbg_backup', wp_slash($c), true);

// 1. download button: any reference to department-details -> PDF
$n1 = substr_count($c, 'department-details');
$c = str_replace('http://black-rock-mortgage.local/department-details/', $pdfUrl, $c);
$c = str_replace('/department-details/', $pdfUrl, $c);
echo "download link refs fixed: $n1\n";

// 2. broken slugs
$fixes = array(
  '/va-home-mortgage-loan/' => '/va-home-mortgage/',
  '/dscr-loans/' => '/florida-dscr-loan/',
  '/one-time-close-construction-loan/' => '/florida-construction-loan/',
);
foreach ($fixes as $f => $t) { $n = substr_count($c, $f); $c = str_replace($f, $t, $c); echo "fixed $f ($n)\n"; }

// 3. add Florida Survival content (condensed from PDF) before the FAQ heading
if (strpos($c, 'brm-hbg-flsurvival') === false) {
    $box = '<!-- wp:html --><!-- brm-hbg-flsurvival -->
<div style="font-family:Karla,-apple-system,sans-serif;max-width:900px;margin:30px auto;">
<h2 style="font-family:Rubik,sans-serif;font-weight:800;font-size:clamp(25px,3.2vw,34px);color:#1c2b29;">The Florida Survival Essentials</h2>
<p style="font-size:17.5px;line-height:1.7;color:#353535;">The full PDF guide covers these in depth &mdash; here&rsquo;s the short version of the Florida-specific stuff that saves (or costs) buyers real money.</p>

<div style="background:#f4faf8;border:1px solid #d9ece7;border-left:5px solid #049F82;border-radius:12px;padding:22px 24px;margin:22px 0;">
<p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#037a64;margin:0 0 8px;">The Florida inspection lineup</p>
<p style="margin:0;font-size:16.5px;line-height:1.65;">Beyond the standard home inspection (\$350&ndash;\$500), Florida adds: the <strong>4-point inspection</strong> (\$75&ndash;\$200 &mdash; your insurer requires it on most homes 15&ndash;20+ years old), the <strong>wind mitigation inspection</strong> (\$75&ndash;\$150 &mdash; voluntary, valid five years, and routinely knocks 10&ndash;50% off the windstorm part of your premium &mdash; the best \$100 you&rsquo;ll spend), the <strong>WDO/termite inspection</strong> (always required on VA in Florida), and well/septic tests on rural property. Pro move: bundle them with one company on one visit.</p>
</div>

<div style="background:#f4faf8;border:1px solid #d9ece7;border-left:5px solid #049F82;border-radius:12px;padding:22px 24px;margin:22px 0;">
<p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#037a64;margin:0 0 8px;">Insurance: the Florida boss level</p>
<p style="margin:0;font-size:16.5px;line-height:1.65;">Insurance kills more Florida deals than appraisals. Start shopping <strong>the week you go under contract</strong> &mdash; your policy must be bound before closing. <strong>The roof runs the show</strong>: shingle roofs past 15&ndash;20 years get expensive or declined, so pull the roof&rsquo;s permit age before you fall in love. Watch the <strong>hurricane deductible</strong> (2%, 5%, or 10% of dwelling coverage &mdash; on \$350,000 that&rsquo;s \$7,000 vs \$35,000 after a storm). Use an independent agent who quotes many carriers, hand them your wind mitigation report on day one &mdash; and know that <strong>flood insurance is a separate policy</strong>, mandatory in FEMA zones A/V on any federally backed loan.</p>
</div>

<div style="background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:12px;padding:22px 24px;margin:22px 0;">
<p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#b9791a;margin:0 0 8px;">&#9888;&#65039; Wire fraud warning &mdash; read this twice</p>
<p style="margin:0;font-size:16.5px;line-height:1.65;">Criminals spoof emails from title companies days before closing with convincing &ldquo;updated wiring instructions.&rdquo; <strong>Never wire money based on emailed instructions alone.</strong> Call the title company at a number you already know &mdash; not one from the email &mdash; and verify verbally. This scam takes Floridians&rsquo; life savings every single week; thirty seconds of paranoia is the cure.</p>
</div>

<div style="background:#f4faf8;border:1px solid #d9ece7;border-left:5px solid #049F82;border-radius:12px;padding:22px 24px;margin:22px 0;">
<p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#037a64;margin:0 0 8px;">After the keys: five things Florida hands you &mdash; if you file</p>
<p style="margin:0;font-size:16.5px;line-height:1.65;">1) File your <a href="/florida-property-tax-exemptions/">homestead exemption</a> by <strong>March 1</strong> &mdash; up to \$50,000 off assessed value, forever. 2) Save Our Homes then caps your assessment growth at 3%/year automatically. 3) <strong>Brace for the year-two escrow step-up</strong> &mdash; Florida reassesses taxes at your purchase price, and it lands in your escrow analysis 12&ndash;18 months in. Budgeted for, it&rsquo;s a shrug, not a shock. 4) Re-shop insurance every renewal &mdash; loyalty isn&rsquo;t rewarded in this market. 5) Know your mortgage-insurance exit: conventional PMI drops near 20&ndash;22% equity; FHA&rsquo;s MIP usually means refinancing out later &mdash; we watch that window for clients.</p>
</div>
</div>
<!-- /wp:html -->';
    $anchor = strpos($c, "Home Buyer's Guide FAQ");
    if ($anchor === false) $anchor = strpos($c, 'Home Buyer&rsquo;s Guide FAQ');
    if ($anchor !== false) {
        $hstart = strrpos(substr($c, 0, $anchor), '<!-- wp:');
        $c = substr($c, 0, $hstart) . $box . "\n\n" . substr($c, $hstart);
        echo "Florida Survival section added\n";
    } else echo "FAQ anchor not found - appended instead\n";
}
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);

// 4. delete stock Kadence demo pages
foreach (array(14, 15, 28, 44, 987513796) as $sid) {
    $t = get_the_title($sid);
    $r = wp_delete_post($sid, true);
    echo ($r ? "deleted [$sid] $t\n" : "could not delete $sid\n");
}
// 5. delete demo menus (not assigned: Primary 68, Quick Links 71, Service Request 74, Useful Links 77, Secondary 16)
foreach (array(68, 71, 74, 77, 16) as $mid) {
    $m = wp_get_nav_menu_object($mid);
    if ($m) { wp_delete_nav_menu($mid); echo "deleted menu [$mid] {$m->name}\n"; }
}
wp_cache_flush();
echo "done\n";
