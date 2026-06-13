<?php
// WWU: UWM Platinum section + exhaustive loan-program menu + UWM in correspondent FAQ.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// ---- 1. UWM into the correspondent FAQ answer
$old = 'Our correspondent panel includes Freedom Mortgage, PennyMac, and NewRez, plus non-QM correspondent channels for deals outside agency guidelines.';
$new = 'Our correspondent panel includes Freedom Mortgage, PennyMac, and NewRez, plus non-QM correspondent channels for deals outside agency guidelines &mdash; and on the wholesale side we hold Platinum status with UWM, the #1 lender in the country.';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

// ---- 2. UWM PLATINUM section + PROGRAM MENU, inserted before the branding section
$anchor = '<!-- BRANDING PATHS -->';
$uwm = '<!-- UWM PLATINUM -->
<div class="sec">
  <div style="background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.14),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);border-radius:16px;padding:46px 38px;color:#fff;max-width:1140px;margin:0 auto;">
    <p class="kick" style="color:#5dcaa5;">Heavyweight In Your Corner</p>
    <h2 style="color:#fff;">Platinum with UWM &mdash; the #1 lender in America</h2>
    <p class="lead" style="color:#cfe0de;">United Wholesale Mortgage isn&rsquo;t just the biggest wholesale lender &mdash; it&rsquo;s the biggest lender in the country, period. Our Platinum account status puts its full arsenal behind every file you write:</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:24px;" class="wwu-uwm-grid">
      <style>@media(max-width:880px){.wwu-uwm-grid{grid-template-columns:1fr !important;}}</style>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Free 1% one-year buydowns</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Year-round incentives for your buyers &mdash; like a free 1% rate buydown for year one. A closing gift your retail competitor can&rsquo;t match.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Appraisal credits &amp; refi incentives</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Appraisal credits at closing and recurring refinance incentives &mdash; running every day, no promotion required.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">No doc stamps on UWM&rarr;UWM refis</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">In Florida, UWM-to-UWM refinances skip the doc stamps &mdash; real money your client sees on the closing disclosure.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">VantageScore + free credit reports</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Qualify buyers on VantageScore 4.0 and run credit reports free &mdash; stop eating $100+ per file in pull costs.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Detroit training &mdash; on their dime</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Get flown to UWM headquarters for an exhaustive menu of product and technology trainings. They invest in you directly.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Platinum-tier service</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Priority underwriting, faster turn times, and dedicated concierge support &mdash; direct access, not a phone queue.</p></div>
    </div>
  </div>
</div>

<!-- PROGRAM MENU -->
<div class="sec">
  <p class="kick">The Menu</p>
  <h2>Everything you can originate here</h2>
  <p class="lead">Your bank&rsquo;s rate sheet has maybe six of these. Between 200+ wholesale lenders, the correspondent panel, and non-QM channels &mdash; if it can be financed, you can write it:</p>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:24px;" class="wwu-menu-grid">
    <style>@media(max-width:880px){.wwu-menu-grid{grid-template-columns:1fr !important;}}.wwu-menu-card ul{margin:0;padding:0 0 0 2px;list-style:none;}.wwu-menu-card li{font-size:14.5px;color:#465552;line-height:1.5;padding:5px 0 5px 24px;position:relative;}.wwu-menu-card li::before{content:"";position:absolute;left:0;top:10px;width:14px;height:14px;background:url(\'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23049F82" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>\') no-repeat center/contain;}</style>
    <div class="wwu-card wwu-menu-card"><h3>Agency &amp; government</h3><ul>
      <li>Conventional (Fannie &amp; Freddie)</li><li>FHA &mdash; incl. 203(k) rehab &amp; streamline refis</li><li>VA &mdash; purchase, IRRRL, VA jumbo</li><li>USDA &mdash; purchase &amp; streamline</li><li>Jumbo &amp; super jumbo</li><li>Down payment assistance &amp; Hometown Heroes</li><li>Mortgage Credit Certificates (MCC)</li>
    </ul></div>
    <div class="wwu-card wwu-menu-card"><h3>Non-QM &amp; specialty</h3><ul>
      <li>Bank statement loans (12 &amp; 24 mo)</li><li>P&amp;L-only &amp; 1099-only programs</li><li>DSCR &mdash; incl. short-term rental</li><li>Asset depletion / asset utilization</li><li>ITIN &amp; foreign national</li><li>Recent credit event (fresh out of BK/foreclosure)</li><li>Physician &amp; professional loans</li><li>Interest-only &amp; 40-year terms</li><li>Condotels &amp; non-warrantable condos</li>
    </ul></div>
    <div class="wwu-card wwu-menu-card"><h3>Construction, equity &amp; commercial</h3><ul>
      <li>One-time-close construction (FHA/VA/USDA/conv)</li><li>Renovation &mdash; HomeStyle &amp; ChoiceRenovation</li><li>Manufactured homes &mdash; incl. singlewides</li><li>HELOCs, HELOANs &amp; piggyback seconds</li><li>Reverse mortgages (HECM &amp; jumbo reverse)</li><li>Fix-and-flip &amp; bridge</li><li>SBA loans (7a &amp; 504)</li><li>Commercial &mdash; multifamily, mixed-use, hotels</li><li>Land &amp; lot loans</li>
    </ul></div>
  </div>
  <p style="text-align:center;font-size:15px;color:#465552;margin-top:18px;">Stop referring deals out. Stop saying no. <strong>Every &ldquo;no&rdquo; your bank made you give is a commission you didn&rsquo;t earn.</strong></p>
</div>

<!-- BRANDING PATHS -->';
if (strpos($c, 'UWM PLATINUM') === false) { $c = str_replace($anchor, $uwm, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "UWM + program menu: $n changes\n";
