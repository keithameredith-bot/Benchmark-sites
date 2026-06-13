<?php
// Tool/utility pages + Ocala: teal hero, NO byline. SAFETY GUARD: only replace the first rowlayout if it contains an <h1>
// (so we never replace a calculator/content rowlayout that isn't a hero).
global $wpdb;
require __DIR__ . '/hero-fn.php'; // brm_hero_html()

function brm_replace_hero_guarded($slug, $eyebrow, $sub, $withByline) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page' ORDER BY ID LIMIT 1", $slug));
    if (!$row) { echo str_pad($slug,40)." MISSING\n"; return; }
    $pid=(int)$row->ID; $c=$row->post_content;
    if (strpos($c,'class="brm-hero"')!==false) { echo str_pad($slug,40)." already brm-hero\n"; return; }
    if (strpos($c,'brm-prog-cta')!==false){$ctaLabel='See My Options';$ctaHref='#see-my-options';}else{$ctaLabel='Get Pre-Approved';$ctaHref='/get-pre-approved/';}
    $open='<!-- wp:kadence/rowlayout';$close='<!-- /wp:kadence/rowlayout -->';
    $start=strpos($c,$open);
    if($start===false){echo str_pad($slug,40)." NO KADENCE HERO\n";return;}
    $i=$start;$depth=0;$end=null;
    while($i<strlen($c)){$no=strpos($c,$open,$i);$nc=strpos($c,$close,$i);if($nc===false)break;if($no!==false&&$no<$nc){$depth++;$i=$no+strlen($open);}else{$depth--;$i=$nc+strlen($close);if($depth===0){$end=$i;break;}}}
    if($end===null){echo str_pad($slug,40)." UNBALANCED\n";return;}
    $hero=substr($c,$start,$end-$start);
    if(!preg_match('/<h1[^>]*>(.*?)<\/h1>/s',$hero,$m)){echo str_pad($slug,40)." 1st rowlayout has NO H1 - SKIP (not a hero)\n";return;}
    $h1=trim($m[1]);
    $new=brm_hero_html($eyebrow,$h1,$sub,$ctaLabel,$ctaHref,$withByline);
    if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
    $wpdb->update($wpdb->posts,array('post_content'=>substr($c,0,$start).$new.substr($c,$end)),array('ID'=>$pid));
    clean_post_cache($pid);
    echo str_pad($slug,40)." OK [$ctaLabel] H1=\"".substr($h1,0,36)."\"\n";
}

$TOOLS = array(
  'mortgage-tools' => array('Florida Mortgage Tools &bull; NMLS #303217','Calculators, a 140+ term glossary, and document checklists &mdash; everything you need to plan your Florida mortgage in one place.'),
  'mortgage-calculator' => array('Florida Mortgage Calculator &bull; NMLS #303217','Estimate your full PITI payment &mdash; principal, interest, taxes, and insurance &mdash; for any Florida home.'),
  'affordability-calculator' => array('Florida Affordability Calculator &bull; NMLS #303217','See how much house you can actually afford in Florida based on your income, debts, and down payment.'),
  'mortgage-glossary' => array('Mortgage Glossary &bull; NMLS #303217','140+ mortgage terms explained in plain English by a Florida mortgage broker.'),
  'florida-closing-costs' => array('Florida Closing Costs Estimator &bull; NMLS #303217','Estimate your Florida closing costs &mdash; doc stamps, title insurance, and prepaids &mdash; before you make an offer.'),
  'refinance-calculator' => array('Florida Refinance Calculator &bull; NMLS #303217','Should you refinance? Run the numbers and see your real break-even point.'),
  'va-funding-fee' => array('VA Funding Fee Calculator &bull; NMLS #303217','Calculate your 2026 VA funding fee by scenario &mdash; first use, subsequent use, and exemptions.'),
  'rate-buydown-calculator' => array('Florida Rate Buydown Calculator &bull; NMLS #303217','See the savings from a 2-1, 3-2-1, or discount-point buydown on your Florida mortgage.'),
  'loan-limits' => array('Florida County Loan Limits &bull; NMLS #303217','FHA and conforming loan limits for every Florida county, updated each year.'),
  'usda-eligibility' => array('Florida USDA Eligibility &bull; NMLS #303217','Check the USDA eligibility map and income limits for your Florida county &mdash; about 97% of the state qualifies.'),
  'florida-loan-program-finder' => array('Florida Loan Program Finder &bull; NMLS #303217','Answer a few questions and find the Florida mortgage program that actually fits your situation.'),
  'loan-programs' => array('Florida Mortgage Loan Programs &bull; NMLS #303217','FHA, VA, USDA, conventional, jumbo, DSCR, and more &mdash; every Florida loan program under one roof.'),
  'documents-needed-for-a-mortgage' => array('Documents Needed for a Mortgage &bull; NMLS #303217','The complete, printable checklist of what you&rsquo;ll need to get your Florida mortgage approved.'),
  'mortgage-faq' => array('Florida Mortgage FAQ &bull; NMLS #303217','Straight answers to the questions Florida buyers ask most &mdash; from a broker, not a call center.'),
);
echo "=== TOOL PAGES (no byline) ===\n";
foreach ($TOOLS as $slug=>$cfg) brm_replace_hero_guarded($slug,$cfg[0],$cfg[1],false);

echo "\n=== OCALA (no byline, like Villages) ===\n";
brm_replace_hero_guarded('ocala-mortgage-broker','Ocala &amp; Marion County &bull; NMLS #303217','16 years and $100M+ closed right here in Marion County. Local knowledge, 200+ wholesale lenders, and one conversation &mdash; with me, not a call center.',false);
echo "done\n";
