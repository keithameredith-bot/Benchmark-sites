<?php
// Rebuild the loan-programs (64) program directory: replace loan-row1..loan-row4 Kadence card rows
// with a comprehensive, rounded, categorized HTML directory covering ALL program pages.
global $wpdb;
$pid = 64;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (!get_post_meta($pid, '_brm_loanhub_backup', true)) add_post_meta($pid, '_brm_loanhub_backup', wp_slash($c), true);

// balanced scan helper
function brm_block_end($c, $start, $name) {
    $open = '<!-- wp:' . $name; $close = '<!-- /wp:' . $name . ' -->';
    $depth = 0; $pos = $start;
    while (true) {
        $no = strpos($c, $open, $pos + 1);
        $nc = strpos($c, $close, $pos + 1);
        if ($nc === false) return false;
        if ($no !== false && $no < $nc) { $depth++; $pos = $no; }
        else { if ($depth === 0) return $nc + strlen($close); $depth--; $pos = $nc; }
    }
}

$start = strpos($c, '<!-- wp:kadence/rowlayout {"uniqueID":"loan-row1"');
$row4 = strpos($c, '<!-- wp:kadence/rowlayout {"uniqueID":"loan-row4"');
if ($start === false || $row4 === false) { echo "row anchors not found\n"; return; }
$end = brm_block_end($c, $row4, 'kadence/rowlayout');
if ($end === false) { echo "row4 end not found\n"; return; }
echo "replacing bytes $start..$end (" . ($end-$start) . ")\n";

// ---- icon helper ----
function ic($p) {
  $icons = array(
    'bank' => '<path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/>',
    'home' => '<path d="M3 9.5 12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/>',
    'flag' => '<path d="M4 22V4M4 4c4-2 8 2 12 0v9c-4 2-8-2-12 0M16 4c2-1 4-1 4-1v9s-2 0-4 1"/>',
    'wheat' => '<path d="M12 2v20M8 6l4 3 4-3M8 11l4 3 4-3M8 16l4 3 4-3"/>',
    'gem' => '<path d="M6 3h12l4 6-10 12L2 9z M2 9h20M9 3 6 9l6 12 6-12-3-6"/>',
    'hero' => '<path d="M12 2 4 5v6c0 5 3.5 8 8 11 4.5-3 8-6 8-11V5z M9 12l2 2 4-4"/>',
    'gift' => '<path d="M20 12v9H4v-9M2 7h20v5H2zM12 22V7M12 7S9 2 6 4s6 3 6 3 3-5 6-3-6 3-6 3"/>',
    'doc' => '<path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8z M14 3v5h5M9 13h6M9 17h6"/>',
    'brief' => '<path d="M3 8h18v12H3z M8 8V5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3"/>',
    'folder' => '<path d="M3 7a1 1 0 0 1 1-1h5l2 2h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>',
    'chart' => '<path d="M3 3v18h18M7 14l3-4 3 3 5-7"/>',
    'steth' => '<path d="M5 3v6a4 4 0 0 0 8 0V3M9 13v3a5 5 0 0 0 10 0v-2M19 11a2 2 0 1 0 0 0z"/>',
    'building' => '<path d="M5 21V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v17M15 9h3a1 1 0 0 1 1 1v11M8 7h2M8 11h2M8 15h2"/>',
    'community' => '<path d="M3 21V9l6-4 6 4v12M9 21v-5h0M15 13l4-3 2 2v9M3 21h18"/>',
    'crane' => '<path d="M4 21h16M6 21V4l12 3M6 7h8M10 7v3"/>',
    'tools' => '<path d="M14.5 5.5a3.5 3.5 0 0 0-5 4.5L3 16.5 5.5 19l6.5-6.5a3.5 3.5 0 0 0 4.5-5l-2.5 2.5-2-2z"/>',
    'refi' => '<path d="M21 12a9 9 0 1 1-3-6.7M21 4v5h-5"/>',
    'cash' => '<path d="M3 6h18v12H3z M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6M6 9v6M18 9v6"/>',
    'credit' => '<path d="M3 6h18v12H3z M3 10h18M7 15h4"/>',
    'reverse' => '<path d="M3 12a9 9 0 1 0 3-6.7M3 4v5h5M12 8v4l3 2"/>',
    'down' => '<path d="M12 5v14M19 12l-7 7-7-7"/>',
  );
  $g = $icons[$p] ?? $icons['home'];
  return '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $g . '</svg>';
}

$cats = array(
  array('Buy a Home', 'Government &amp; conventional', array(
    array('home','Conventional','3% down for first-time buyers','/conventional-mortgage-in-florida/'),
    array('home','FHA','3.5% down, 580+ credit','/fha-home-mortgage-loan/'),
    array('flag','VA','$0 down for veterans &amp; active duty','/va-home-mortgage/'),
    array('wheat','USDA','$0 down in eligible areas','/florida-usda-mortgage/'),
    array('gem','Jumbo','High-value homes beyond conforming limits','/florida-jumbo-loan/'),
  )),
  array('First-Time Buyer Help', 'Grants &amp; down payment assistance', array(
    array('hero','Hometown Heroes','Up to $35,000 toward your purchase','/hometown-heroes-mortgage-program/'),
    array('gift','Down Payment Assistance','Programs that cover your down payment','/down-payment-assistance-in-florida/'),
  )),
  array('Self-Employed, Investor &amp; Non-QM', 'When tax returns don&rsquo;t tell the whole story', array(
    array('doc','Bank Statement Loans','Qualify on deposits, not tax returns','/bank-statement-mortgage-program/'),
    array('brief','Self-Employed','Built for business owners &amp; 1099 earners','/self-employed-mortgage/'),
    array('folder','Non-QM Loans','Common-sense lending outside the agency box','/florida-non-qm-loans/'),
    array('chart','DSCR Investor Loans','Qualify on the property&rsquo;s rent, no income docs','/florida-dscr-loan/'),
    array('steth','Physician Loans','Low/no down, no PMI for doctors','/florida-physician-loan/'),
    array('building','Condotel Financing','Loans for condo-hotel units','/condo-tel-financing-in-florida/'),
  )),
  array('Manufactured &amp; New Construction', 'Homes most lenders won&rsquo;t touch &mdash; we close monthly', array(
    array('community','Manufactured Homes','Singlewides, doublewides, on land or moving','/florida-mobile-home-financing/'),
    array('crane','One-Time-Close Construction','Build with a single closing','/florida-construction-loan/'),
    array('tools','VA Construction','$0-down build for veterans','/va-new-construction-loan/'),
    array('building','Spec Construction (Builders)','For builders &amp; investors &mdash; no payments during the build','/spec-construction-loans/'),
  )),
  array('Refinance &amp; Home Equity', 'Lower your rate or tap your equity', array(
    array('refi','Refinance','Lower your rate or change your term','/refinance-mortgage/'),
    array('cash','Cash-Out Refinance','Turn home equity into cash','/florida-cash-out-refinance/'),
    array('credit','HELOC','A line of credit against your home','/home-equity-line-of-credit-in-florida/'),
    array('refi','FHA Streamline','Fast, low-doc FHA-to-FHA refi','/fha-home-mortgage-loan/fha-streamline-refinance/'),
    array('wheat','USDA Streamline','Simple refi for USDA homeowners','/usda-refinance-program/'),
    array('reverse','Reverse Mortgage','Tap equity at 55+, no monthly payment','/reverse-mortgages/'),
    array('down','Rate Buydown','Temporarily lower your rate','/temporary-rate-buydown/'),
  )),
);

$html = '<!-- wp:html -->
<style>
.brm-lp{max-width:1180px;margin:10px auto 0;padding:0 20px;font-family:"Karla",-apple-system,sans-serif;}
.brm-lp *{box-sizing:border-box;}
.brm-lp-cat{margin:0 0 34px;}
.brm-lp-eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:11.5px;color:#037a64;margin:0 0 3px;}
.brm-lp-cat h3{font-family:"Rubik",sans-serif;font-weight:800;color:#1c2b29;font-size:clamp(20px,2.4vw,26px);margin:0 0 16px;line-height:1.2;}
.brm-lp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;}
@media(max-width:900px){.brm-lp-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:600px){.brm-lp-grid{grid-template-columns:1fr;}}
.brm-lp-card{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e3edea;border-radius:18px;padding:18px 18px;text-decoration:none !important;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease;}
.brm-lp-card:hover{transform:translateY(-3px);border-color:#5dcaa5;box-shadow:0 16px 34px -18px rgba(15,46,45,.4);}
.brm-lp-ic{flex:0 0 auto;width:46px;height:46px;border-radius:14px;background:#eafaf6;display:flex;align-items:center;justify-content:center;}
.brm-lp-body{flex:1;min-width:0;}
.brm-lp-name{display:block;font-family:"Rubik",sans-serif;font-weight:700;font-size:16px;color:#1c2b29;line-height:1.25;}
.brm-lp-desc{display:block;font-size:13.5px;color:#6b7d79;line-height:1.4;margin-top:2px;}
.brm-lp-arrow{flex:0 0 auto;font-family:"Rubik",sans-serif;font-weight:700;color:#F5A524;font-size:18px;transition:transform .16s ease;}
.brm-lp-card:hover .brm-lp-arrow{transform:translateX(3px);}
.brm-lp-help{background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,.14),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);border-radius:18px;padding:30px 32px;margin:8px auto 30px;max-width:1180px;color:#fff;text-align:center;}
.brm-lp-help p{margin:0;font-size:16.5px;line-height:1.6;color:#cfe0de;}
.brm-lp-help strong{color:#fff;}
.brm-lp-help a{color:#F5A524;font-weight:700;text-decoration:none;}
</style>
<div class="brm-lp">
';
foreach ($cats as $cat) {
  $html .= '<div class="brm-lp-cat"><p class="brm-lp-eyebrow">' . $cat[1] . '</p><h3>' . $cat[0] . '</h3><div class="brm-lp-grid">';
  foreach ($cat[2] as $card) {
    $html .= '<a class="brm-lp-card" href="' . $card[3] . '"><span class="brm-lp-ic">' . ic($card[0]) . '</span><span class="brm-lp-body"><span class="brm-lp-name">' . $card[1] . '</span><span class="brm-lp-desc">' . $card[2] . '</span></span><span class="brm-lp-arrow">&rarr;</span></a>';
  }
  $html .= '</div></div>';
}
$html .= '<div class="brm-lp-help"><p><strong>Not sure which fits?</strong> That&rsquo;s the easy part &mdash; tell me your situation and I&rsquo;ll match you to the right program from 200+ lenders. <a href="/get-pre-approved/">Get your free pre-approval &rarr;</a></p></div>
</div>
<!-- /wp:html -->';

$c = substr($c, 0, $start) . $html . substr($c, $end);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "loan hub directory rebuilt (" . strlen($html) . " bytes inserted)\n";
