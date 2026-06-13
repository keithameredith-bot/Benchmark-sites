<?php
// Weave Keith's questionnaire answers in: inline 2026 fixes, real-closing stories, competitor-myth sections,
// HH funding specifics, current USDA turn time. All idempotent with reporting.
global $wpdb;

function brm_repl($pid, $swaps, $label) {
    global $wpdb;
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    $n = 0;
    foreach ($swaps as $from => $to) {
        if (strpos($c, $from) !== false) { $c = str_replace($from, $to, $c); $n++; }
        elseif (strpos($c, $to) === false) echo "  WARN [$label] miss: " . substr($from,0,55) . "\n";
    }
    if ($n) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid)); clean_post_cache($pid); }
    echo "$label: $n swaps\n";
}

function brm_insert_before_form($slug, $html, $marker) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$row) { echo "MISS $slug\n"; return; }
    $c = $row->post_content;
    if (strpos($c, $marker) !== false) { echo "$slug: already inserted\n"; return; }
    $fp = strpos($c, 'brm-prog-cta');
    if ($fp === false) { echo "$slug: NO FORM, appending at end\n"; $c .= "\n\n" . $html; }
    else {
        $fs = strrpos(substr($c, 0, $fp), '<!-- wp:html -->');
        $c = substr($c, 0, $fs) . $html . "\n\n" . substr($c, $fs);
    }
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID));
    clean_post_cache($row->ID);
    echo "$slug: inserted\n";
}

function brm_story($tag, $title, $body) {
    return '<!-- wp:html --><!-- ' . $tag . ' --><div style="background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:12px;padding:24px 26px;margin:30px auto;max-width:900px;font-family:Karla,-apple-system,sans-serif;"><p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#b9791a;margin:0 0 8px;">' . $title . '</p><p style="margin:0;font-size:17px;line-height:1.65;color:#353535;">' . $body . '</p></div><!-- /wp:html -->';
}

// ---- 1. FHA page inline 2026 fixes ----
brm_repl(56, array(
  'The FHA loan amount limits for 2025 are lower' => 'The FHA loan amount limits for 2026 are lower',
  "it's \$524,225 for a single family home" => "it's \$541,287 for a single family home",
  'Counties like Broward have a limit of \$659,121' => 'Counties like Broward have a limit of \$667,000',
), 'fha-inline-2026');

// ---- 2. USDA turn times: current-as-of line ----
brm_repl(623, array(
  "updated continuously.</p>" => "updated continuously.</p>\n<p><strong>Current as of June 11, 2026:</strong> the Florida USDA office is reviewing applications received <strong>June 2</strong> &mdash; right at a <strong>9-business-day turn time</strong>. We update this whenever we check the hotline; call it yourself anytime for the live number.</p>",
), 'turn-times-current');

// ---- 3. Hometown Heroes funding specifics ----
brm_repl(15715, array(
  'Funds will be available in July.' => 'The state approved \$50 million in the May 29 budget &mdash; new funds are available July 1, 2026.',
), 'hh-page-funding');
$gid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='florida-first-time-home-buyer-grants'");
brm_repl($gid, array(
  "they're exhausted right now, with the next release expected in July" => "they're exhausted right now &mdash; the state approved \$50 million on May 29, with new funds available July 1, 2026",
), 'grants-funding');

// ---- 4. REAL CLOSING STORIES ----
brm_insert_before_form('florida-mobile-home-financing',
  brm_story('brm-story-dunnellon', 'Real closing &mdash; Dunnellon, 2026',
  'We just closed a first-time buyer on a beautiful 2010 doublewide on a spacious rural lot in Dunnellon &mdash; <strong>\$230,000, \$0 down, USDA financing</strong>. The seller contributed to closing costs, so the buyer&rsquo;s entire out-of-pocket was about \$1,500: the appraisal, the contract deposit, and a couple of inspections. We even arranged for the engineer to collect his tie-down inspection fee at closing instead of upfront. One more thing most lenders get wrong out here: <strong>insurance</strong>. Manufactured-home policies kill more deals than credit does &mdash; we know how to shop the policy so it satisfies the guidelines, and we&rsquo;ve saved deals other lenders lost purely on insurance.'),
  'brm-story-dunnellon');

brm_insert_before_form('the-villages-mortgage-broker',
  brm_story('brm-story-hecm', 'Real closing &mdash; The Villages, 2026',
  'A client sold their Rhode Island home and moved to The Villages year-round. They put <strong>60% down on an \$800,000 home with a HECM for purchase</strong> &mdash; no monthly mortgage payment for as long as they live there. Their investments stay positioned for their heirs exactly as planned, and if there&rsquo;s equity left in the home down the road, that passes to the heirs too. They&rsquo;re living the Villages life completely payment-free. That&rsquo;s what this strategy looks like when it&rsquo;s structured right.'),
  'brm-story-hecm');

brm_insert_before_form('florida-physician-loan',
  brm_story('brm-story-physician', 'Real closing &mdash; Marion County, 2026',
  'A physician fresh out of training came to us with strong income, heavy student loans, and &mdash; like most new doctors &mdash; no time yet to build savings. A big bank would call that &ldquo;come back in two years.&rdquo; We closed him into a <strong>\$550,000 Marion County home with \$0 down</strong> using this program. His student loans didn&rsquo;t sink the ratios, and his income did exactly what everyone knows a physician&rsquo;s income does: showed up.'),
  'brm-story-physician');

brm_insert_before_form('hometown-heroes-mortgage-program',
  brm_story('brm-story-hh', 'How my clients actually use it',
  'The classic Hometown Heroes client has the income and the credit &mdash; just not the down payment. The program&rsquo;s 5% covers FHA&rsquo;s 3.5% requirement <em>and then some</em>, and with a typical 3% seller concession on top, my clients are getting into homes with <strong>little to no money out of pocket</strong>. No geographic limitations &mdash; and yes, it works on manufactured homes. We&rsquo;ve closed those too.'),
  'brm-story-hh');

// ---- 5. WHAT OTHER LENDERS GET WRONG ----
brm_insert_before_form('singlewide-manufactured-home-financing',
  brm_story('brm-myth-singlewide', 'What other lenders get wrong',
  'I can&rsquo;t count the calls from veterans who were told they &ldquo;can&rsquo;t use VA entitlement on a singlewide.&rdquo; <strong>That is not a VA rule &mdash; it&rsquo;s that lender&rsquo;s overlay</strong>, dressed up as policy. The VA has zero issue financing a singlewide manufactured home. Same story with the &ldquo;required&rdquo; engineer report on VA manufactured loans: <strong>the VA doesn&rsquo;t require it</strong>. When a lender&rsquo;s overlay tells you no, the program itself often says yes &mdash; you just need a broker who works from the actual guidelines.'),
  'brm-myth-singlewide');

brm_insert_before_form('manufactured-homes-that-have-been-moved',
  brm_story('brm-myth-moved', 'What other lenders get wrong',
  'Most lenders flatly refuse a manufactured home that&rsquo;s been moved &mdash; and they&rsquo;ll tell you no program allows it. Not true: <strong>the VA allows financing of a manufactured home that has been moved once</strong>. That&rsquo;s the difference between a lender&rsquo;s overlay and the actual guideline &mdash; and it&rsquo;s a deal we can close that almost nobody else will touch.'),
  'brm-myth-moved');

brm_insert_before_form('self-employed-mortgage',
  brm_story('brm-myth-se', 'What other lenders get wrong',
  'Here&rsquo;s a guideline competitors miss constantly: with conventional financing, <strong>if you&rsquo;ve been self-employed for five years or more, you can qualify with just one year of tax returns</strong>. Plain and simple. We love turning that &ldquo;no&rdquo; from another lender into a &ldquo;yes&rdquo; &mdash; not with tricks, just by actually knowing the guidelines.'),
  'brm-myth-se');

brm_insert_before_form('condo-tel-financing-in-florida',
  brm_story('brm-myth-condo', 'What other lenders get wrong',
  'A recent save: a non-warrantable condo where every other lender demanded the condo association carry a master flood policy &mdash; which it didn&rsquo;t have. With 200+ wholesale lenders, we found one perfectly fine with <strong>the borrower carrying their own flood policy</strong>. The other lender always wants to say it can&rsquo;t be done. Then we get the borrower to the closing table and just smile. Anyone can do the cookie-cutter deals &mdash; the tricky ones are where a real broker earns it. And when a deal genuinely needs time? We say that too. False hope hurts worse than &ldquo;let&rsquo;s wait this one out.&rdquo;'),
  'brm-myth-condo');

echo "done\n";
