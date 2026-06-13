<?php
// Hero rollout: replace each page's first Kadence rowlayout hero with the clean teal brm-hero.
// CTA auto-detected: pages with the on-page form -> "See My Options"/#see-my-options; else "Get Pre-Approved"/get-pre-approved.
// byline per entry. H1 auto-extracted from existing hero. Backs up to _brm_hero_backup. Idempotent.
global $wpdb;

function brm_hero_html($eyebrow, $h1, $sub, $ctaLabel, $ctaHref, $withByline) {
    $byline_css = '
.brm-hero .brm-byline{display:inline-block;font-family:"Karla",-apple-system,sans-serif;font-size:14px;line-height:1.5;color:#fff;margin:6px 0 0;padding:9px 16px 10px;background:rgba(0,0,0,0.34);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);border-radius:6px;box-sizing:border-box;border-bottom:1px solid rgba(255,255,255,0.28);}
.brm-hero .brm-byline a{color:#ffd97d;text-decoration:none;font-weight:600;}
.brm-hero .brm-byline a:hover{text-decoration:underline;color:#ffe9a8;}
.brm-hero .brm-byline-sep{color:rgba(255,255,255,0.6);margin:0 6px;display:inline-block;}
.brm-hero .brm-byline-credential{color:#fff;font-weight:700;}';
    $byline = $withByline ? '
  <div class="brm-byline">Written by <a href="/keith-meredith/">Keith Meredith</a><span class="brm-byline-sep">&middot;</span><span class="brm-byline-credential">NMLS 303217</span><span class="brm-byline-sep">&middot;</span>Division President, Black Rock Mortgage</div>' : '';
    return '<!-- wp:html -->
<style>
.brm-hero{position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);color:#fff;border-radius:16px;padding:54px 40px;margin:0 0 4px;font-family:"Karla",-apple-system,sans-serif;box-sizing:border-box;}
.brm-hero *{box-sizing:border-box;}
.brm-hero .eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;margin:0 0 12px;}
.brm-hero h1{font-family:"Rubik",sans-serif;font-weight:800;color:#fff !important;font-size:clamp(30px,4.4vw,46px);line-height:1.12;letter-spacing:-.01em;margin:0 0 14px;}
.brm-hero .sub{color:#cfe0de !important;font-size:18.5px;line-height:1.55;max-width:700px;margin:0 0 26px;}
.brm-hero .btns{display:flex;gap:13px;flex-wrap:wrap;align-items:center;}
.brm-hero a.go,.brm-hero a.call{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;letter-spacing:.02em;padding:14px 28px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.brm-hero a.go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.brm-hero a.go:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}
.brm-hero a.call{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,.55);}
.brm-hero a.call:hover{border-color:#fff;background:rgba(255,255,255,.08) !important;color:#fff !important;}' . $byline_css . '
@media(max-width:720px){.brm-hero{padding:40px 22px;border-radius:12px;}.brm-hero .btns{flex-direction:column;align-items:stretch;}.brm-hero a.go,.brm-hero a.call{width:100%;}}
</style>
<div class="brm-hero">
  <p class="eyebrow">' . $eyebrow . '</p>
  <h1>' . $h1 . '</h1>
  <p class="sub">' . $sub . '</p>
  <div class="btns"><a class="go" href="' . $ctaHref . '">' . $ctaLabel . '</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div>' . $byline . '
</div>
<!-- /wp:html -->';
}

function brm_replace_hero_slug($slug, $eyebrow, $sub, $withByline) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page' ORDER BY ID LIMIT 1", $slug));
    if (!$row) { echo str_pad($slug,42)." MISSING\n"; return; }
    $pid = (int)$row->ID; $c = $row->post_content;
    if (strpos($c, 'class="brm-hero"') !== false) { echo str_pad($slug,42)." already brm-hero\n"; return; }
    // auto CTA
    if (strpos($c, 'brm-prog-cta') !== false) { $ctaLabel='See My Options'; $ctaHref='#see-my-options'; }
    else { $ctaLabel='Get Pre-Approved'; $ctaHref='/get-pre-approved/'; }
    $open='<!-- wp:kadence/rowlayout'; $close='<!-- /wp:kadence/rowlayout -->';
    $start = strpos($c,$open);
    if ($start===false) { echo str_pad($slug,42)." NO KADENCE HERO (skip - manual)\n"; return; }
    $i=$start;$depth=0;$end=null;
    while($i<strlen($c)){$no=strpos($c,$open,$i);$nc=strpos($c,$close,$i);if($nc===false)break;if($no!==false&&$no<$nc){$depth++;$i=$no+strlen($open);}else{$depth--;$i=$nc+strlen($close);if($depth===0){$end=$i;break;}}}
    if($end===null){echo str_pad($slug,42)." UNBALANCED (skip)\n";return;}
    $hero=substr($c,$start,$end-$start);
    $h1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/s',$hero,$m) ? trim($m[1]) : 'Black Rock Mortgage';
    $new = brm_hero_html($eyebrow,$h1,$sub,$ctaLabel,$ctaHref,$withByline);
    if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
    $wpdb->update($wpdb->posts,array('post_content'=>substr($c,0,$start).$new.substr($c,$end)),array('ID'=>$pid));
    clean_post_cache($pid);
    echo str_pad($slug,42)." OK [$ctaLabel] H1=\"".substr($h1,0,40)."\"\n";
}

// LOAN-PROGRAM PAGES (byline = true)
$LP = array(
  'fha-home-mortgage-loan' => array('Florida FHA Home Loans &bull; NMLS #303217','3.5% down, credit scores from 580, and seller-paid closing costs up to 6% &mdash; the most forgiving path to owning a Florida home.'),
  'florida-usda-mortgage' => array('Florida USDA Rural Development &bull; NMLS #303217','$0 down across roughly 97% of Florida&rsquo;s geography, with lower mortgage insurance than FHA. The most affordable way to buy.'),
  'conventional-mortgage-in-florida' => array('Florida Conventional Mortgages &bull; NMLS #303217','As little as 3% down for qualified buyers, with mortgage insurance that eventually drops off &mdash; the workhorse loan for strong credit.'),
  'florida-non-qm-loans' => array('Florida Non-QM Loans &bull; NMLS #303217','Bank statement, DSCR, asset-based, and 1099 programs for when traditional guidelines don&rsquo;t fit your file.'),
  'self-employed-mortgage' => array('Self-Employed Mortgages &bull; NMLS #303217','Bank statement, 1099, and P&amp;L programs that qualify business owners on real cash flow &mdash; not write-off-heavy tax returns.'),
  'bank-statement-mortgage-program' => array('Bank Statement Loans &bull; NMLS #303217','Qualify on 12 or 24 months of deposits instead of tax returns &mdash; built for Florida&rsquo;s self-employed and business owners.'),
  'florida-dscr-loan' => array('Florida DSCR Investor Loans &bull; NMLS #303217','Qualify on the property&rsquo;s rental income &mdash; no tax returns, no personal DTI. Built for Florida real estate investors.'),
  'florida-jumbo-loan' => array('Florida Jumbo Loans &bull; NMLS #303217','Financing above the conforming limit &mdash; up to $15M &mdash; with competitive rates and flexible documentation for luxury Florida homes.'),
  'condo-tel-financing-in-florida' => array('Florida Condotel Financing &bull; NMLS #303217','Specialty financing for condotels and non-warrantable condos most lenders won&rsquo;t touch &mdash; we close them across Florida.'),
  'florida-cash-out-refinance' => array('Florida Cash-Out Refinance &bull; NMLS #303217','Tap your home&rsquo;s equity &mdash; up to 100% LTV with VA &mdash; for renovations, debt payoff, or your next investment.'),
  'refinance-mortgage' => array('Florida Mortgage Refinance &bull; NMLS #303217','Lower your rate, shorten your term, or pull cash &mdash; 12 refinance options across every loan type.'),
  'home-equity-line-of-credit-in-florida' => array('Florida HELOC &bull; NMLS #303217','Access your home&rsquo;s equity with a flexible line of credit, often closing in days.'),
  'reverse-mortgages' => array('Florida Reverse Mortgages &bull; NMLS #303217','HECM purchase and refinance for homeowners 62+ &mdash; access your equity with no monthly mortgage payment.'),
  'fha-streamline-refinance' => array('FHA Streamline Refinance &bull; NMLS #303217','Lower your FHA rate fast &mdash; often no appraisal and reduced documentation. The simplest refinance for existing FHA borrowers.'),
  'temporary-rate-buydown' => array('Temporary Rate Buydowns &bull; NMLS #303217','Lock a lower payment for your first years with a 2-1 or 3-2-1 buydown &mdash; a smart way to ease into your Florida mortgage.'),
  'hometown-heroes-mortgage-program' => array('Florida Hometown Heroes &bull; NMLS #303217','Up to $35,000 toward down payment and closing costs for Florida&rsquo;s frontline workers &mdash; teachers, nurses, first responders, and more.'),
  'down-payment-assistance-in-florida' => array('Florida Down Payment Assistance &bull; NMLS #303217','Programs that put up to $35,000 toward your purchase &mdash; we&rsquo;ll find every dollar you qualify for.'),
  'florida-construction-loan' => array('Florida Construction Loans &bull; NMLS #303217','One-time-close construction loans &mdash; FHA, VA, USDA, and conventional &mdash; to build your Florida home with a single closing.'),
  'va-new-construction-loan' => array('VA New Construction &bull; NMLS #303217','Build with your VA benefit &mdash; $0 down, no monthly mortgage insurance, one closing.'),
  'florida-mobile-home-financing' => array('Florida Manufactured Home Financing &bull; NMLS #303217','FHA, VA, USDA, and conventional financing for manufactured homes on land &mdash; including singlewides most lenders refuse.'),
  'singlewide-manufactured-home-financing' => array('Singlewide Manufactured Homes &bull; NMLS #303217','Hard-to-find financing for singlewide manufactured homes on land &mdash; we close them across Florida.'),
  'usda-mortgage-for-manufactured-homes' => array('USDA Manufactured Home Loans &bull; NMLS #303217','$0-down USDA financing for newer manufactured homes in rural Florida.'),
  'refinance-manufactured-home' => array('Refinance a Manufactured Home &bull; NMLS #303217','Lower your rate or pull cash out of your Florida manufactured home.'),
  'manufactured-homes-that-have-been-moved' => array('Financing a Moved Manufactured Home &bull; NMLS #303217','Yes &mdash; we can finance a manufactured home that has been moved off its original site. Most lenders can&rsquo;t.'),
);
echo "=== LOAN-PROGRAM PAGES (byline) ===\n";
foreach ($LP as $slug=>$cfg) brm_replace_hero_slug($slug,$cfg[0],$cfg[1],true);
echo "done\n";
