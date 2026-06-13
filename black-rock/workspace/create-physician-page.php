<?php
// Create /florida-physician-loan/ — dedicated medical professional loan program page.
// Hero+byline, design system, Keith's voice, FAQ+schema, lead form, AIOSEO title/meta.
global $wpdb;
require __DIR__ . '/hero-fn.php';

$slug = 'florida-physician-loan';
$exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s", $slug));
if ($exists) { echo "already exists ($exists)\n"; return; }

$author = (int) $wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID=88");
if (!$author) $author = 1;

$css = file_get_contents(__DIR__.'/article-css.html');
$bio = '/wp-content/uploads/2026/04/Keith-Meredith-division-president-of-black-rock-mortgage.webp';
$hero = brm_hero_html(
  'Florida Physician &amp; Medical Professional Loans &bull; NMLS #303217',
  'Florida Physician Loans',
  '100% financing up to $2M, no mortgage insurance, and underwriting that actually understands student debt and a signed contract that hasn&rsquo;t started yet &mdash; built for the doctors and medical professionals who earned it.',
  'See My Options', '#see-my-options', true);

$body = <<<HTML
<!-- wp:html -->
<div class="brm-article">
<p class="brm-lead">Medical professionals don&rsquo;t fit the traditional lending mold &mdash; and they shouldn&rsquo;t have to. You finished training with six figures of student debt, you&rsquo;re starting a job you haven&rsquo;t technically started yet, and a normal underwriter looks at that and says &ldquo;come back in two years.&rdquo; My physician loan program looks at the same file and says &ldquo;welcome home.&rdquo; 100% financing, no PMI, and we can close on the strength of your signed contract before your first paycheck ever hits.</p>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">100%</div><div class="l">financing (0% down)</div><div class="s">Purchase or rate/term, up to the full loan amount</div></div>
  <div class="brm-stat"><div class="n">$2M</div><div class="l">max loan amount</div><div class="s">No mortgage insurance at any loan size</div></div>
  <div class="brm-stat"><div class="n">680</div><div class="l">minimum FICO</div><div class="s">No first-time-buyer overlays, no PMI, ever</div></div>
</div>

<div class="brm-callout gold"><span class="tag">The headline</span><p>Most loans punish you for being early in a medical career &mdash; the debt, the gap between training and income, the lack of a long W-2 history. This program is built to do the opposite: <strong>$0 down up to $2 million, no mortgage insurance, and the ability to qualify on a contract with a start date up to 150 days out.</strong></p></div>

<h2>Why Doctors Need a Different Loan</h2>
<p>Here&rsquo;s what trips up a conventional file and how the physician program handles it instead:</p>
<ul>
<li><strong>Student debt.</strong> A standard loan counts your full student-loan balance against you, even in deferment. This program offers real flexibility on how that debt is treated &mdash; so a residency&rsquo;s worth of loans doesn&rsquo;t torpedo your ratios.</li>
<li><strong>You haven&rsquo;t started yet.</strong> Residents, fellows, and newly-hired attendings can qualify on <strong>future income</strong> &mdash; a signed offer letter or employment contract with a start date within 150 days of closing. Buy before day one on the job.</li>
<li><strong>No down payment saved.</strong> 100% financing means you don&rsquo;t have to drain savings or wait years to buy &mdash; and gift funds are allowed, including for reserves.</li>
<li><strong>No mortgage insurance.</strong> Putting nothing down normally means PMI for years. Not here &mdash; no MI at any loan amount up to $2M, which keeps your monthly payment meaningfully lower.</li>
</ul>

<h2>Program Highlights</h2>
<div class="brm-tablewrap"><table class="brm-table">
<thead><tr><th>Feature</th><th>Details</th></tr></thead>
<tbody>
<tr><td>Max loan amount</td><td class="yes">$2,000,000</td></tr>
<tr><td>Max LTV</td><td class="yes">100% (purchase or rate/term)</td></tr>
<tr><td>Mortgage insurance</td><td class="yes">None</td></tr>
<tr><td>Minimum FICO</td><td>680</td></tr>
<tr><td>Occupancy</td><td>Primary residence only</td></tr>
<tr><td>First-time buyer overlays</td><td class="yes">None</td></tr>
<tr><td>Student loans</td><td>Flexible treatment</td></tr>
<tr><td>Gift funds</td><td class="yes">Allowed, including for reserves</td></tr>
<tr><td>Asset depletion</td><td>Supplemental asset depletion allowed</td></tr>
<tr><td>Future income</td><td>Offer letter / contract with a start date within 150 days of the note date</td></tr>
</tbody></table></div>

<h2>Who Qualifies</h2>
<p>This program is built for a specific, hard-working group &mdash; whether you&rsquo;re an established practitioner or still in training (residents, fellows, and interns are welcome):</p>
<ul>
<li>Medical Doctors (MD)</li>
<li>Doctors of Osteopathy (DO)</li>
<li>Dentists (DDS / DMD) and Doctors of Dental Medicine</li>
<li>Ophthalmologists</li>
<li>Psychiatrists</li>
<li>Doctors of Pharmacy (PharmD)</li>
<li>Doctors of Veterinary Medicine (DVM)</li>
<li>Doctors of Podiatric Medicine (DPM)</li>
<li>Certified Registered Nurse Anesthetists (CRNA)</li>
</ul>

<h2>How We Document Your Income</h2>
<p>Two clean paths, whichever fits where you are in your career:</p>
<ul>
<li><strong>Standard full-doc</strong> &mdash; one or two years of income verification for established professionals.</li>
<li><strong>Future income</strong> &mdash; qualify on a signed offer letter or employment contract with a start date within <strong>150 days</strong> of the note date. Perfect for residents finishing training or attendings relocating to a new practice.</li>
</ul>

<div class="brm-callout"><span class="tag">The Florida angle</span><p>Florida&rsquo;s medical communities are booming &mdash; UF Health and Shands in <a href="/gainesville-mortgage-broker/">Gainesville</a>, the hospital systems across Ocala, Tampa, Orlando, Jacksonville, and Miami. If you&rsquo;re relocating for residency, a fellowship, or a new attending role anywhere in Florida (or one of the 40+ states I&rsquo;m licensed in), this program travels with you.</p></div>

<div class="brm-keith"><div class="av"><img src="$bio" alt="Keith Meredith, Florida mortgage broker" /></div><div><p class="tag">Keith's take</p><p>I&rsquo;ve watched too many new doctors get told to &ldquo;wait two years&rdquo; by a big-bank loan officer who didn&rsquo;t understand the file. A resident with a signed attending contract is one of the safest borrowers I can think of &mdash; guaranteed income, a career that isn&rsquo;t going anywhere. This program prices that reality correctly. If you&rsquo;ve got a contract in hand and a closet full of student loans, let&rsquo;s talk before you assume you can&rsquo;t buy.</p></div></div>

<div class="brm-takeaway"><h3>The bottom line</h3><p>Get your home loan the way the rest of your finances should work &mdash; built around your actual career, not a generic underwriting box. 100% financing, no PMI, up to $2M, and we can close before your first day on the job.</p></div>

<h2>Physician Loan FAQ</h2>
<div class="brm-faq">
<details open><summary>Can I buy before I start my new job or residency?</summary><div class="a"><p>Yes. We can qualify you on future income using a signed offer letter or employment contract, as long as your start date is within 150 days of the note date. You can close on your home before your first paycheck arrives.</p></div></details>
<details><summary>Do I really put nothing down?</summary><div class="a"><p>Correct &mdash; up to 100% financing on a purchase or rate/term refinance, to a maximum loan amount of $2,000,000, with no mortgage insurance. Gift funds are allowed, including for reserves, if you want to bring some money in.</p></div></details>
<details><summary>How are my student loans treated?</summary><div class="a"><p>With flexibility built for medical careers, rather than counting your full balance against you the way a conventional loan does. Send me your situation and I&rsquo;ll show you exactly how it pencils out.</p></div></details>
<details><summary>Which professions qualify?</summary><div class="a"><p>MDs, DOs, dentists (DDS/DMD), ophthalmologists, psychiatrists, doctors of pharmacy, veterinarians, podiatrists, and CRNAs &mdash; including residents, fellows, and interns.</p></div></details>
<details><summary>Is this only for first-time buyers?</summary><div class="a"><p>No. There are no first-time-buyer overlays. Established practitioners use it for the 100% financing and the no-PMI structure just as often as new doctors do. It is for a primary residence only.</p></div></details>
<details><summary>What credit score do I need?</summary><div class="a"><p>A 680 minimum FICO. If you&rsquo;re close, let&rsquo;s talk &mdash; medical professionals often have thin-but-clean credit, and there are ways to strengthen a file.</p></div></details>
</div>

<p style="font-size:14px;color:#5b6b6b;margin-top:24px;"><em>Program guidelines reflect current investor terms and can change. Final terms depend on full underwriting. Black Rock Mortgage is a division of Coast 2 Coast Mortgage, NMLS #303217.</em></p>

</div>
<!-- /wp:html -->
HTML;

$form = <<<'FORM'
<!-- wp:html -->
<style>
.brm-prog-cta{--pt-accent:#5dcaa5;--pt-gold:#f5a524;position:relative;background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.16),transparent 60%),linear-gradient(180deg,#0f2e2d 0%,#0a1f1e 100%);color:#fff;padding:90px 24px 88px;border-radius:20px;max-width:1200px;margin:48px auto;overflow:hidden;font-family:"Karla",-apple-system,sans-serif;box-sizing:border-box;}
.brm-prog-cta *,.brm-prog-cta *::before,.brm-prog-cta *::after{box-sizing:border-box;}
.brm-prog-cta-wrap{max-width:1180px;margin:0 auto;}
.brm-prog-cta-eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.18em;font-size:12.5px;color:var(--pt-accent);text-align:center;margin:0 0 14px;}
.brm-prog-cta h2{font-family:"Rubik",sans-serif;color:#fff !important;text-align:center;font-size:clamp(30px,4vw,44px);text-transform:uppercase;font-weight:800;margin:0 0 18px;line-height:1.15;}
.brm-prog-cta-lead{color:#cfe0de !important;text-align:center !important;max-width:720px;margin:0 auto 36px !important;font-size:17px;line-height:1.6;}
.brm-prog-cta-form-wrap{max-width:1000px;margin:0 auto;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:28px;-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);}
.brm-prog-cta-form-wrap iframe{width:100%;border:0;display:block;min-height:700px;overflow:hidden;border-radius:6px;background:#fff;}
.brm-prog-cta-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:110px 0 0;}
.brm-prog-cta-actions{margin:16px 0 0 !important;display:flex;flex-wrap:wrap;gap:14px;justify-content:center;align-items:center;}
.brm-prog-cta-actions a{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:15px;letter-spacing:.01em;line-height:1.35;padding:15px 30px;border-radius:6px;text-decoration:none !important;transition:all 180ms ease;}
.brm-prog-cta-portal{background:var(--pt-gold) !important;color:#1a1a1a !important;border:2px solid var(--pt-gold);}
.brm-prog-cta-portal:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}
.brm-prog-cta-callbtn{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,0.55);}
.brm-prog-cta-callbtn:hover{border-color:#fff;background:rgba(255,255,255,0.08) !important;color:#fff !important;transform:translateY(-1px);}
@media (max-width:720px){.brm-prog-cta{padding:60px 18px 60px;border-radius:14px;margin:32px 12px;}.brm-prog-cta-form-wrap{padding:16px;border-radius:6px;}.brm-prog-cta-readylabel{margin-top:88px;}.brm-prog-cta-actions{flex-direction:column;}.brm-prog-cta-actions a{width:100%;max-width:360px;}}
</style>
<div class="brm-prog-cta" id="see-my-options">
  <div class="brm-prog-cta-wrap">
    <p class="brm-prog-cta-eyebrow">Ready When You Are</p>
    <h2>Get Your Physician Loan Pre-Approval</h2>
    <p class="brm-prog-cta-lead">Tell me where you are &mdash; in training, a signed contract in hand, or established in practice. I&rsquo;ll match you to the right physician program and have you pre-approved fast. No SSN or credit pull on this form.</p>
    <div class="brm-prog-cta-form-wrap">
      <iframe id="brmPreapproval" src="http://black-rock-mortgage.local/wp-content/uploads/forms/preapproval-form.html?v=2" title="See what you qualify for - Black Rock Mortgage" scrolling="no" loading="eager"></iframe>
    </div>
    <p class="brm-prog-cta-readylabel">Ready for a Full Application?</p>
    <div class="brm-prog-cta-actions">
      <a class="brm-prog-cta-portal" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>
      <a class="brm-prog-cta-callbtn" href="tel:3526194959">Call Keith: 352-619-4959</a>
    </div>
  </div>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){window.addEventListener('message',function(e){if(!e.data)return;if(e.data.brm==='height'){var f=document.getElementById('brmPreapproval');if(f&&e.data.h){f.style.height=e.data.h+'px';}}});})();
</script>
<!-- /wp:html -->
FORM;

$faqschema = <<<'SCHEMA'

<!-- wp:html -->
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/florida-physician-loan/#faq","mainEntity":[
{"@type":"Question","name":"Can I buy before I start my new job or residency?","acceptedAnswer":{"@type":"Answer","text":"Yes. You can qualify on future income using a signed offer letter or employment contract with a start date within 150 days of the note date, and close before your first paycheck."}},
{"@type":"Question","name":"Do I really put nothing down on a physician loan?","acceptedAnswer":{"@type":"Answer","text":"Yes, up to 100% financing on a purchase or rate/term refinance to a maximum loan amount of $2,000,000, with no mortgage insurance. Gift funds are allowed, including for reserves."}},
{"@type":"Question","name":"How are student loans treated on a physician loan?","acceptedAnswer":{"@type":"Answer","text":"With flexibility built for medical careers rather than counting the full balance against you the way a conventional loan does."}},
{"@type":"Question","name":"Which professions qualify for the physician loan?","acceptedAnswer":{"@type":"Answer","text":"MDs, DOs, dentists (DDS/DMD), ophthalmologists, psychiatrists, doctors of pharmacy, veterinarians, podiatrists, and CRNAs, including residents, fellows, and interns."}},
{"@type":"Question","name":"Is the physician loan only for first-time buyers?","acceptedAnswer":{"@type":"Answer","text":"No. There are no first-time-buyer overlays. It is for a primary residence only, and established practitioners use it as often as new doctors."}},
{"@type":"Question","name":"What credit score do I need for a physician loan?","acceptedAnswer":{"@type":"Answer","text":"A 680 minimum FICO."}}
]}
</script>
<!-- /wp:html -->
SCHEMA;

$content = $css . "\n\n" . $hero . "\n\n" . $body . "\n\n" . $form . "\n\n" . $faqschema;

$pid = wp_insert_post(array(
  'post_title' => 'Florida Physician Loans',
  'post_name' => $slug,
  'post_content' => $content,
  'post_status' => 'publish',
  'post_type' => 'page',
  'post_author' => $author,
), true);
if (is_wp_error($pid)) { echo "ERROR: ".$pid->get_error_message()."\n"; return; }

$pt = $wpdb->prefix . 'aioseo_posts';
$wpdb->insert($pt, array(
  'post_id' => $pid,
  'title' => 'Florida Physician Loans — 100% Financing, No PMI for Doctors | Black Rock',
  'description' => 'Florida physician home loans: 100% financing up to $2M, no PMI, 680 FICO, and qualify on a signed contract before you start. For doctors, dentists, CRNAs, pharmacists &amp; more.',
  'created' => current_time('mysql', true),
  'updated' => current_time('mysql', true),
));
echo "physician page PUBLISHED (id $pid) at /$slug/\n";
