<?php
// Round 2 of Keith's answers: bond softening, mfg neighborhoods, FHA condition reality-check,
// engineer-report expectations, work-history + credit-score FAQs, builder links.
global $wpdb;

function brm_repl2($slugOrId, $swaps, $label) {
    global $wpdb;
    if (is_numeric($slugOrId)) $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE ID=%d", $slugOrId));
    else $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slugOrId));
    if (!$row) { echo "MISS $label\n"; return; }
    $c = $row->post_content; $n = 0;
    foreach ($swaps as $from => $to) {
        if (strpos($c, $from) !== false) { $c = str_replace($from, $to, $c); $n++; }
        elseif (strpos($c, $to) === false) echo "  WARN [$label]: " . substr($from,0,60) . "\n";
    }
    if ($n) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID)); clean_post_cache($row->ID); }
    echo "$label: $n swaps\n";
}

function brm_box($tag, $title, $body) {
    return '<!-- wp:html --><!-- ' . $tag . ' --><div style="background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:12px;padding:24px 26px;margin:30px auto;max-width:900px;font-family:Karla,-apple-system,sans-serif;"><p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#b9791a;margin:0 0 8px;">' . $title . '</p><p style="margin:0;font-size:17px;line-height:1.65;color:#353535;">' . $body . '</p></div><!-- /wp:html -->';
}
function brm_before_form2($slug, $html, $marker) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$row) { echo "MISS $slug\n"; return; }
    $c = $row->post_content;
    if (strpos($c, $marker) !== false) { echo "$slug: already\n"; return; }
    $fp = strpos($c, 'brm-prog-cta');
    if ($fp === false) { $c .= "\n\n" . $html; }
    else { $fs = strrpos(substr($c, 0, $fp), '<!-- wp:html -->'); $c = substr($c, 0, $fs) . $html . "\n\n" . substr($c, $fs); }
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID));
    clean_post_cache($row->ID);
    echo "$slug: inserted\n";
}

// ---- A. Soften Villages bond claims ----
brm_repl2('the-villages-mortgage-broker', array(
  "VA loans, reverse-for-purchase, and retirement-smart lending &mdash; from a broker who actually understands bond assessments, fixed-income qualifying, and how The Villages really works."
  => "VA loans, reverse-for-purchase, and retirement-smart lending &mdash; from a broker who understands how bonds and assessments hit your qualifying numbers, how fixed-income files really work, and how The Villages really buys.",
  "That payment has to be counted correctly in your debt-to-income ratio, and whether to pay the bond off at closing is a real financial decision. I run it both ways for you."
  => "That payment has to be counted correctly in your debt-to-income ratio &mdash; get it wrong and an approval that should sail can stall. Whether to pay the bond off at closing is a financial-planning call for you and your advisor; on the mortgage side, my job is making sure it's counted right either way.",
  "Should you pay off the bond at closing or carry it? It depends on the bond balance, the interest rate on it, and how long you plan to stay. There&rsquo;s no universal right answer &mdash; but there is a right answer <em>for you</em>, and I&rsquo;ll show you the math both ways before you decide."
  => "Should you pay off the bond at closing or carry it? It depends on the balance, its rate, and how long you plan to stay &mdash; that one&rsquo;s worth a conversation with your financial planner. What I make sure of on the mortgage side: the bond and assessments are entered correctly in qualifying, whichever way you go.",
  "<p>Sometimes yes, sometimes no &mdash; it depends on the bond balance, its interest rate, and how long you&rsquo;ll own the home. I&rsquo;ll run the numbers both ways so you can make the call with real figures instead of a guess.</p>"
  => "<p>It depends on the balance, its rate, and how long you&rsquo;ll own the home &mdash; a question worth taking to your financial planner. On the mortgage side, what matters is that the bond payment is counted correctly in your qualifying numbers, and we make sure it is.</p>",
  '{"@type":"Question","name":"Should I pay off the bond when I buy in The Villages?","acceptedAnswer":{"@type":"Answer","text":"It depends on the bond balance, its interest rate, and how long you plan to own. A broker can run the numbers both ways so you decide with real figures."}}'
  => '{"@type":"Question","name":"Should I pay off the bond when I buy in The Villages?","acceptedAnswer":{"@type":"Answer","text":"It depends on the balance, its rate, and how long you will own the home - a question worth discussing with your financial planner. On the mortgage side, what matters is that the bond payment is counted correctly in qualifying."}}',
), 'villages-bond-soften');

// ---- B. Manufactured-home neighborhoods (local color) ----
brm_before_form2('florida-mobile-home-financing',
  brm_box('brm-mfg-hoods', 'Where the manufactured homes are',
  'If you&rsquo;re shopping Marion County and the Nature Coast, these are the neighborhoods I finance in constantly: <strong>Rainbow Lake Estates</strong> in the Dunnellon area, <strong>Silver Springs Manor</strong> between Ocala and Belleview (great homes, typically <strong>\$150,000&ndash;\$250,000</strong>), <strong>Ocala Estates</strong>, and <strong>the Falls of Ocala</strong>. Tell me the neighborhood and I&rsquo;ll usually know the land, the setups, and what the appraiser will want before we ever order it.'),
  'brm-mfg-hoods');
brm_repl2('belleview-mortgage-broker', array(
  "<strong><a href=\"/florida-mobile-home-financing/\">Manufactured homes on land</a></strong> are a huge share of the local market"
  => "<strong><a href=\"/florida-mobile-home-financing/\">Manufactured homes on land</a></strong> are a huge share of the local market &mdash; <strong>Silver Springs Manor</strong>, between Ocala and Belleview, is a favorite with great homes typically running \$150,000&ndash;\$250,000"
), 'belleview-hoods');

// ---- C. FHA condition reality check ----
brm_before_form2('fha-home-mortgage-loan',
  brm_box('brm-fha-condition', 'A reality check on FHA &amp; property condition',
  'Some realtors steer sellers away from FHA offers over property condition &mdash; usually off one odd past experience &mdash; and most of the time it&rsquo;s unwarranted. Here&rsquo;s the truth from someone who closes FHA every month: the home needs to be in <strong>working order</strong>, that&rsquo;s it. No exposed wire at a receptacle (an FHA appraiser flags that where a conventional appraiser won&rsquo;t), no unrepaired ceiling leaks, no holes in the wall, no chipping lead paint. The home can be <strong>completely outdated</strong> and FHA is fine with it. Should a basic, fixable item really keep a seller from accepting an FHA buyer? I don&rsquo;t think so &mdash; and the same goes for VA. Sometimes my job is giving the buyer <em>and</em> the realtor that reality check.'),
  'brm-fha-condition');

// ---- D. Engineer report expectations (conventional, mfg) ----
brm_before_form2('florida-mobile-home-financing',
  brm_box('brm-mfg-engineer', 'What surprises people: the engineer report',
  'A common assumption from clients <em>and</em> realtors: &ldquo;conventional financing doesn&rsquo;t need an engineer report on a manufactured home.&rdquo; <strong>Most of the time, it does.</strong> The rare exception is a home with nothing attached but the steps &mdash; then no report. But the moment there&rsquo;s a porch, decking, or an awning (and there usually is), the underwriter will call for an engineer to inspect the tie-downs after reviewing the appraisal. And don&rsquo;t assume a brand-new setup passes automatically &mdash; you&rsquo;d be surprised how often we find a loose tie-down or a gap between a pier and the frame on a new install. We prep you for the possibilities upfront, so nothing lands as a giant surprise mid-deal.'),
  'brm-mfg-engineer');

// ---- E+F. Requirements article: work-history + credit-score FAQs + body cross-ref update ----
$reqId = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='requirements-to-buy-a-house-in-florida'");
brm_repl2($reqId, array(
  "Lenders want a two-year work history (not necessarily the same job) and stable, documentable income."
  => "Lenders want a two-year work history &mdash; not necessarily the same job, and it&rsquo;s fine to be starting a new job, even in a new field, or your first job out of school (your schooling can count toward history). One or two job changes in the last two years is not a deal killer.",
  "<p>Minimums by loan type &mdash; and remember, lenders pull specific FICO versions, not the score your banking app shows (<a href=\"/do-mortgage-lenders-use-fico-or-vantagescore/\">here&rsquo;s the difference</a>):</p>"
  => "<p>Minimums by loan type. One big 2026 change: for years, lenders used only old FICO models &mdash; never the score your banking app shows. As of April 2026, <strong>VantageScore 4.0 is accepted</strong> on conventional loans (and we run it on VA too), which often scores higher for thin-credit files (<a href=\"/do-mortgage-lenders-use-fico-or-vantagescore/\">full breakdown here</a>):</p>",
), 'requirements-body');

// add 2 FAQs to requirements (after the 70-year-old FAQ added earlier)
$row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE ID=%d", $reqId));
$c = $row->post_content;
if (strpos($c, 'brm-faq-credithistory') === false) {
    $anchor = "no monthly mortgage payment at all.</p></div></details>";
    $newFaqs = '<!-- brm-faq-credithistory --><details><summary>I just started a new job &mdash; can I still get a mortgage?</summary><div class="a"><p>Usually, yes. It&rsquo;s fine to be starting a job right out of school (your education can count toward the two-year history), and fine to be starting a new job &mdash; even in a new field. We can even close using an offer letter with a start date. Heavy job-hopping weighs on the automated underwriting models, but one or two changes in the last two years is not a deal killer.</p></div></details>
<details><summary>Is my Credit Karma score accurate for a mortgage?</summary><div class="a"><p>For years the honest answer was no &mdash; mortgages ran on old FICO models, not the VantageScore your app shows. That changed in April 2026: <strong>VantageScore 4.0 is now accepted</strong> by Fannie Mae and Freddie Mac, and we run it on conventional and VA loans today. It can genuinely help thin-credit files &mdash; it ignores paid and medical collections and can score newer credit. <a href="/do-mortgage-lenders-use-fico-or-vantagescore/">Full breakdown of what changed here</a>.</p></div></details>';
    $p = strpos($c, $anchor);
    if ($p !== false) {
        $c = substr($c, 0, $p + strlen($anchor)) . "\n" . $newFaqs . substr($c, $p + strlen($anchor));
        $sAnchor = "\n]}\n</script>";
        if (substr_count($c, $sAnchor) === 1) {
            $sNew = ',
{"@type":"Question","name":"I just started a new job - can I still get a mortgage?","acceptedAnswer":{"@type":"Answer","text":"Usually yes. Starting a job out of school is fine (education can count toward the two-year history), and starting a new job, even in a new field, is fine - including closing with an offer letter. One or two job changes in two years is not a deal killer."}},
{"@type":"Question","name":"Is my Credit Karma score accurate for a mortgage?","acceptedAnswer":{"@type":"Answer","text":"For years no - mortgages used old FICO models, not VantageScore. As of April 2026, VantageScore 4.0 is accepted by Fannie Mae and Freddie Mac and can be used on conventional and VA loans, which often helps thin-credit files since it ignores paid and medical collections."}}';
            $c = str_replace($sAnchor, $sNew . "\n]}\n</script>", $c);
        } else echo "  requirements: schema anchor issue\n";
        $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$reqId));
        clean_post_cache($reqId);
        echo "requirements: 2 FAQs added\n";
    } else echo "requirements: FAQ anchor not found\n";
} else echo "requirements FAQs: already\n";

// rent-to-own cross-ref update
brm_repl2('rent-to-own-homes-in-florida', array(
  "Maybe. But don&rsquo;t guess &mdash; the free apps show a VantageScore, and <a href=\"/do-mortgage-lenders-use-fico-or-vantagescore/\">mortgage lenders use different FICO versions</a>, so plenty of renters are closer than they think."
  => "Maybe. But don&rsquo;t guess &mdash; and here&rsquo;s good news: as of April 2026, <a href=\"/do-mortgage-lenders-use-fico-or-vantagescore/\">VantageScore 4.0 is accepted on conventional loans</a>, so the score your app shows is closer to reality than it&rsquo;s ever been. Plenty of renters are closer to qualifying than they think.",
), 'rent-to-own-credit');

// ---- G. Builder links on construction page ----
brm_before_form2('florida-construction-loan',
  brm_box('brm-builders', 'Builders we close with',
  'A construction loan goes smoother when the lender and builder already know each other&rsquo;s process. Two local builders we work with and recommend: <a href="https://jscfla.com/" target="_blank" rel="noopener"><strong>JSC Construction</strong></a> (barndominiums, container homes, and custom builds across North Central Florida) and <a href="https://shamrockconstruction.com/" target="_blank" rel="noopener"><strong>Shamrock Construction</strong></a>. Building with someone else? No problem &mdash; we&rsquo;ll get your builder approved and keep the one-time close on schedule.'),
  'brm-builders');

echo "done\n";
