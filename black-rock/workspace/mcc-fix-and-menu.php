<?php
// 1. MCC discontinued: banner on MCC page (830) + post (864), remove from WWU menu + grants article + closing costs.
// 2. Rework WWU program menu: 6 balanced groups flowing in CSS columns (no uneven card bottoms).
global $wpdb;

$banner = '<!-- wp:html --><!-- brm-mcc-notice -->
<div style="background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:12px;padding:20px 24px;margin:0 0 26px;font-family:Karla,-apple-system,sans-serif;">
<p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#b9791a;margin:0 0 6px;">Program Status: Discontinued</p>
<p style="margin:0;font-size:16px;line-height:1.65;color:#353535;"><strong>Florida&rsquo;s MCC program is no longer offered.</strong> The good news: better help exists today. <a href="/hometown-heroes-mortgage-program/">Hometown Heroes</a> offers up to \$35,000 toward your purchase, and <a href="/down-payment-assistance-in-florida/">Florida&rsquo;s down payment assistance programs</a> remain active. This page stays up for reference &mdash; <a href="/get-pre-approved/">get pre-approved</a> and we&rsquo;ll match you to what&rsquo;s available now.</p>
</div>
<!-- /wp:html -->';

foreach (array(830, 864) as $pid) {
    $c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    if ($c && strpos($c, 'brm-mcc-notice') === false) {
        // insert after hero if present, else prepend
        $heroPos = strpos($c, 'class="brm-hero"');
        if ($heroPos !== false) {
            $heroEnd = strpos($c, '<!-- /wp:html -->', $heroPos) + strlen('<!-- /wp:html -->');
            $c = substr($c, 0, $heroEnd) . "\n\n" . $banner . substr($c, $heroEnd);
        } else $c = $banner . "\n\n" . $c;
        $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
        clean_post_cache($pid);
        echo "[$pid] discontinued banner added\n";
    }
}

// grants article: fix MCC mention if it claims availability
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987515421");
$i = stripos($c, 'MCC');
if ($i !== false) echo "grants article MCC context: ..." . preg_replace('/\s+/', ' ', strip_tags(substr($c, max(0,$i-200), 420))) . "...\n";

// closing costs page MCC context
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987514711");
$i = stripos($c, 'MCC');
if ($i === false) $i = stripos($c, 'Mortgage Credit Certificate');
if ($i !== false) echo "closing-costs MCC context: ..." . preg_replace('/\s+/', ' ', strip_tags(substr($c, max(0,$i-200), 420))) . "...\n";

// ---- 2. WWU menu rework: remove MCC + rebalance into 6 flowing groups
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$s = strpos($c, '<!-- PROGRAM MENU -->');
$e = strpos($c, '<!-- BRANDING PATHS -->');
if ($s !== false && $e !== false) {
    $menu = '<!-- PROGRAM MENU -->
<div class="sec">
  <p class="kick">The Menu</p>
  <h2>Everything you can originate here</h2>
  <p class="lead">Your bank&rsquo;s rate sheet has maybe six of these. Between 200+ wholesale lenders, the correspondent panel, and non-QM channels &mdash; if it can be financed, you can write it:</p>
  <style>
  .wwu-menu2{columns:3;column-gap:18px;max-width:1080px;margin:26px auto 0;}
  @media(max-width:980px){.wwu-menu2{columns:2;}}
  @media(max-width:640px){.wwu-menu2{columns:1;}}
  .wwu-menu2 .grp{break-inside:avoid;-webkit-column-break-inside:avoid;background:#fff;border:1px solid #e3edea;border-radius:14px;padding:22px 22px 16px;margin:0 0 18px;}
  .wwu-menu2 .grp h3{font-family:Rubik,sans-serif;font-weight:700;color:#1c2b29;font-size:16px;margin:0 0 10px;text-transform:uppercase;letter-spacing:.05em;}
  .wwu-menu2 ul{margin:0;padding:0;list-style:none;}
  .wwu-menu2 li{font-size:14.5px;color:#465552;line-height:1.5;padding:5px 0 5px 24px;position:relative;}
  .wwu-menu2 li::before{content:"";position:absolute;left:0;top:10px;width:14px;height:14px;background:url(\'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23049F82" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>\') no-repeat center/contain;}
  </style>
  <div class="wwu-menu2">
    <div class="grp"><h3>Agency &amp; Government</h3><ul>
      <li>Conventional (Fannie &amp; Freddie)</li><li>FHA &mdash; incl. 203(k) rehab &amp; streamline</li><li>VA &mdash; purchase, IRRRL, VA jumbo</li><li>USDA &mdash; purchase &amp; streamline</li><li>Jumbo &amp; super jumbo</li><li>Down payment assistance &amp; Hometown Heroes</li>
    </ul></div>
    <div class="grp"><h3>Self-Employed &amp; Non-QM</h3><ul>
      <li>Bank statement loans (12 &amp; 24 mo)</li><li>P&amp;L-only &amp; 1099-only</li><li>Asset depletion / utilization</li><li>ITIN &amp; foreign national</li><li>Recent credit event programs</li><li>Interest-only &amp; 40-year terms</li>
    </ul></div>
    <div class="grp"><h3>Specialty Property &amp; Borrower</h3><ul>
      <li>Manufactured homes &mdash; incl. singlewides</li><li>Condotels &amp; non-warrantable condos</li><li>Physician &amp; professional loans</li><li>Land &amp; lot loans</li>
    </ul></div>
    <div class="grp"><h3>Construction &amp; Renovation</h3><ul>
      <li>One-time-close construction (FHA/VA/USDA/conv)</li><li>HomeStyle &amp; ChoiceRenovation</li><li>Fix-and-flip &amp; bridge</li>
    </ul></div>
    <div class="grp"><h3>Equity &amp; Reverse</h3><ul>
      <li>HELOCs, HELOANs &amp; piggyback seconds</li><li>Reverse mortgages &mdash; HECM &amp; jumbo reverse</li>
    </ul></div>
    <div class="grp"><h3>Investor &amp; Commercial</h3><ul>
      <li>DSCR &mdash; incl. short-term rental</li><li>SBA loans (7a &amp; 504)</li><li>Multifamily, mixed-use &amp; hotels</li>
    </ul></div>
  </div>
  <p style="text-align:center;font-size:15px;color:#465552;margin-top:8px;">Stop referring deals out. Stop saying no. <strong>Every &ldquo;no&rdquo; your bank made you give is a commission you didn&rsquo;t earn.</strong></p>
</div>

';
    $c = substr($c, 0, $s) . $menu . substr($c, $e);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "WWU menu reworked (MCC removed, 6 balanced groups)\n";
}
wp_cache_flush();
echo "done\n";
