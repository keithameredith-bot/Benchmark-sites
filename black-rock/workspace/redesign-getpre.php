<?php
// Full redesign of /get-pre-approved/ (74) in the new design system. Conversion-focused, matches the site.
// Preserves all messaging (2-min check, How It Works, credit-check explainer, Keith's note, testimonials, FAQ + schema).
global $wpdb;
require __DIR__ . '/hero-fn.php';
$pid = 74;
$css = file_get_contents(__DIR__.'/article-css.html');
$photo = '/wp-content/uploads/2026/04/Keith-Meredith-division-president-of-black-rock-mortgage.webp';
$form = 'http://black-rock-mortgage.local/wp-content/uploads/forms/preapproval-form.html?v=2';

$hero = brm_hero_html(
  'Florida Mortgage Pre-Approval &bull; NMLS #303217',
  'See What You Qualify For',
  'Start with a free 2-minute check &mdash; no credit pull, no obligation. A real Florida broker reviews every one personally and reaches out, usually the same day.',
  'Start the 2-Minute Check', '#pa-form', false);

$gpcss = <<<'CSS'
<!-- wp:html -->
<style>
.brm-gp2{font-family:"Karla",-apple-system,sans-serif;color:#353535;}
.brm-gp2 .gp-formcard{background:#fff;border:1px solid #e2ece9;border-radius:16px;box-shadow:0 12px 40px -18px rgba(4,159,130,.22);padding:10px;margin:8px 0 6px;}
.brm-gp2 .gp-formhead{text-align:center;padding:24px 20px 6px;}
.brm-gp2 .gp-formhead h2{font-family:"Rubik",sans-serif;font-weight:800;font-size:26px;color:#1c2b29;margin:0 0 8px;}
.brm-gp2 .gp-formhead p{color:#5b6b6b;font-size:16px;margin:0;}
.brm-gp2 .gp-formcard iframe{width:100%;border:0;display:block;min-height:700px;border-radius:10px;background:#fff;overflow:hidden;}
.brm-gp2 .gp-reassure{text-align:center;color:#5b6b6b;font-size:13.5px;padding:6px 12px 16px;}
.brm-gp2 .gp-reassure b{color:#037a64;}
.brm-gp2 .gp-fullapp{text-align:center;margin:30px auto 4px;}
.brm-gp2 .gp-fullapp .lbl{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#037a64;margin:0 0 14px;}
.brm-gp2 .gp-fullapp .btns{display:flex;gap:13px;justify-content:center;flex-wrap:wrap;}
.brm-gp2 .gp-fullapp a{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;padding:14px 28px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.brm-gp2 .gp-fullapp .go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.brm-gp2 .gp-fullapp .go:hover{background:#ffb944 !important;border-color:#ffb944;transform:translateY(-1px);}
.brm-gp2 .gp-fullapp .call{background:#fff !important;color:#037a64 !important;border:2px solid #cfe4de;}
.brm-gp2 .gp-fullapp .call:hover{border-color:#049F82;}
.brm-gp2 .gp-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin:24px 0;}
.brm-gp2 .gp-step{position:relative;background:linear-gradient(180deg,#f4faf8,#eef6f4);border:1px solid #d9ece7;border-radius:14px;padding:26px 22px 22px;}
.brm-gp2 .gp-step .num{width:38px;height:38px;border-radius:10px;background:#049F82;color:#fff;font-family:"Rubik",sans-serif;font-weight:800;font-size:18px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;}
.brm-gp2 .gp-step h3{font-family:"Rubik",sans-serif;font-weight:700;font-size:18px;color:#1c2b29;margin:0 0 7px;}
.brm-gp2 .gp-step p{font-size:15px;line-height:1.55;color:#41524f;margin:0;}
.brm-gp2 .gp-note{display:grid;grid-template-columns:160px 1fr;gap:28px;align-items:center;background:#0f2e2d;border-radius:18px;padding:32px 34px;margin:30px 0;color:#eaf5f2;}
.brm-gp2 .gp-note img{width:160px;height:160px;object-fit:cover;border-radius:16px;display:block;}
.brm-gp2 .gp-note h3{font-family:"Rubik",sans-serif;font-weight:800;font-size:23px;color:#fff;margin:0 0 10px;}
.brm-gp2 .gp-note p{color:#cfe0de !important;font-size:16.5px;line-height:1.6;margin:0 0 10px;}
.brm-gp2 .gp-note .sig{color:#5dcaa5;font-weight:700;font-family:"Rubik",sans-serif;font-size:14px;}
.brm-gp2 .gp-reviews{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin:24px 0;}
.brm-gp2 .gp-review{background:#fff;border:1px solid #e2ece9;border-radius:14px;padding:24px 22px;}
.brm-gp2 .gp-review .stars{color:#F5A524;font-size:16px;letter-spacing:2px;margin-bottom:10px;}
.brm-gp2 .gp-review p{font-size:15.5px;line-height:1.6;color:#41524f;margin:0 0 12px;font-style:italic;}
.brm-gp2 .gp-review .who{font-weight:700;color:#1c2b29;font-size:14px;}
@media(max-width:820px){.brm-gp2 .gp-steps,.brm-gp2 .gp-reviews{grid-template-columns:1fr;}.brm-gp2 .gp-note{grid-template-columns:1fr;text-align:center;justify-items:center;}.brm-gp2 .gp-note img{margin:0 auto;}}
</style>
<!-- /wp:html -->
CSS;

$body = <<<HTML
<!-- wp:html -->
<div class="brm-article brm-gp2">

<div class="gp-formcard" id="pa-form">
  <div class="gp-formhead">
    <h2>Start Your Free 2-Minute Check</h2>
    <p>No credit pull. No documents. Just a few quick questions so Keith can point you in the right direction.</p>
  </div>
  <iframe id="brmPreapproval" src="$form" scrolling="no" loading="eager" title="See what you qualify for - Black Rock Mortgage"></iframe>
  <p class="gp-reassure">&#128274; <b>No SSN, no credit pull, no documents</b> on this form &mdash; by design. Equal Housing Lender.</p>
</div>

<div class="gp-fullapp">
  <p class="lbl">Ready for a Full Application?</p>
  <div class="btns">
    <a class="go" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>
    <a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a>
  </div>
</div>

<h2>How It Works</h2>
<p class="brm-lead">Two simple stages &mdash; start soft, finish verified. You&rsquo;re never bounced between strangers.</p>
<div class="gp-steps">
  <div class="gp-step"><div class="num">1</div><h3>The 2-Minute Check</h3><p>Answer a few quick questions about what you&rsquo;re trying to do &mdash; no documents, no obligation, no credit pull. Takes about two minutes.</p></div>
  <div class="gp-step"><div class="num">2</div><h3>Keith Reaches Out</h3><p>I personally review your answers and call or text to walk through your options and what you&rsquo;d qualify for. Real guidance, zero pressure.</p></div>
  <div class="gp-step"><div class="num">3</div><h3>Verified Pre-Approval</h3><p>Ready to make offers? Complete the full secure application (~12 min, includes a credit check). I review within 24 hours and send your verified letter &mdash; valid 90 days.</p></div>
</div>

<div class="brm-callout"><span class="tag">About the credit check</span><p>The 2-minute check above has <strong>no credit pull</strong>. The full application does include a hard credit check &mdash; and that&rsquo;s a good thing: it means your pre-approval is fully verified, the kind realtors and sellers actually take seriously. The score impact is typically just a few points and fades within months, and FICO counts all mortgage inquiries in a 14&ndash;45 day window as a single inquiry, so you can shop lenders without stacking the impact.</p></div>

<div class="gp-note">
  <img src="$photo" alt="Keith Meredith, Florida mortgage broker" />
  <div>
    <h3>A Personal Note Before You Start</h3>
    <p>Hey, I&rsquo;m Keith &mdash; and I&rsquo;ll personally review your information. No call center, no bouncing between loan officers. Just one local Florida broker who&rsquo;s been doing this for over a decade.</p>
    <p>Not ready to fill anything out? Rather just talk through your situation first? Call or text me directly &mdash; I&rsquo;d rather have a 5-minute conversation than have you guessing.</p>
    <p class="sig">Keith Meredith &middot; Division President &middot; NMLS #303217</p>
  </div>
</div>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">16 Yrs</div><div class="l">closing Florida loans</div><div class="s">Over a decade of local experience on your side</div></div>
  <div class="brm-stat"><div class="n">$100M+</div><div class="l">funded</div><div class="s">Purchases, refinances, USDA, manufactured &amp; more</div></div>
  <div class="brm-stat"><div class="n">5&#9733; / 65+</div><div class="l">Google reviews</div><div class="s">Real Florida clients, not bought ratings</div></div>
</div>

<h2>What Florida Buyers Are Saying</h2>
<div class="gp-reviews">
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;I was able to purchase my first home with the guidance and help from Keith Meredith. Starting 2026 off as a homeowner with such gratitude for Keith and his team!&rdquo;</p><div class="who">&mdash; Bailee S., Dunnellon FL</div></div>
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;Keith and his team were incredibly helpful! The process flowed seamlessly from application to closing. I highly recommend Keith and his team!&rdquo;</p><div class="who">&mdash; Christine C., The Villages FL</div></div>
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;Keith is so easy to work with. Professional and keeps an open line of communication, which is much appreciated in this industry! We&rsquo;ll definitely use him again and refer him to everyone we know.&rdquo;</p><div class="who">&mdash; Amy G., New Smyrna Beach FL</div></div>
</div>

<h2>Pre-Approval FAQ</h2>
<div class="brm-faq">
<details open><summary>Do I have to do a credit check to start?</summary><div class="a"><p>No. The 2-minute check at the top of this page has no credit pull and no obligation &mdash; it just helps me understand your situation so I can reach out with real guidance. A hard pull only happens later, if and when you choose the full application for a verified pre-approval letter.</p></div></details>
<details><summary>Will applying hurt my credit score?</summary><div class="a"><p>The full application uses a hard credit check so I can give you a fully verified pre-approval. A hard inquiry typically lowers your score by a few points and recovers within months &mdash; and FICO treats all mortgage inquiries in a 14&ndash;45 day window as one, so shopping lenders won&rsquo;t stack up against you.</p></div></details>
<details><summary>How long does pre-approval take?</summary><div class="a"><p>Within 24 hours on weekdays. The full application takes about 12 minutes; once it&rsquo;s in, I personally review your file and get back to you the same or next business day.</p></div></details>
<details><summary>What&rsquo;s the difference between pre-qualification and pre-approval?</summary><div class="a"><p>A pre-qualification is a quick estimate. A pre-approval is verified &mdash; credit pulled, income and assets reviewed. Realtors and sellers want to see a real pre-approval before they take your offer seriously.</p></div></details>
<details><summary>How long is my pre-approval valid?</summary><div class="a"><p>90 days. If you haven&rsquo;t found a home in that window, we&rsquo;ll re-verify a couple of items and refresh the letter.</p></div></details>
<details><summary>What if I&rsquo;m not ready to apply yet?</summary><div class="a"><p>That&rsquo;s exactly what the 2-minute check is for &mdash; start there with no credit pull, or call or text me at <a href="tel:3526194959">352-619-4959</a> to talk it through first. We can map out a plan with zero pressure.</p></div></details>
</div>

<div class="brm-midcta"><h3>Let&rsquo;s find out what you qualify for</h3><p>The 2-minute check is the easiest first step &mdash; no credit pull, no documents, and a real person on the other end. Or just call me.</p><div class="btns"><a class="go" href="#pa-form">Start the 2-Minute Check</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div></div>

</div>
<!-- /wp:html -->

<!-- wp:html -->
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/get-pre-approved/#faq","mainEntity":[
{"@type":"Question","name":"Do I have to do a credit check to start?","acceptedAnswer":{"@type":"Answer","text":"No. The 2-minute check has no credit pull and no obligation. A hard pull only happens later if you choose the full application for a verified pre-approval letter."}},
{"@type":"Question","name":"Will applying hurt my credit score?","acceptedAnswer":{"@type":"Answer","text":"The full application uses a hard credit check. It typically lowers your score by a few points and recovers within months, and FICO treats all mortgage inquiries in a 14 to 45 day window as one."}},
{"@type":"Question","name":"How long does pre-approval take?","acceptedAnswer":{"@type":"Answer","text":"Within 24 hours on weekdays. The full application takes about 12 minutes; Keith personally reviews your file and responds the same or next business day."}},
{"@type":"Question","name":"What is the difference between pre-qualification and pre-approval?","acceptedAnswer":{"@type":"Answer","text":"A pre-qualification is a quick estimate. A pre-approval is verified with credit pulled and income and assets reviewed, which realtors and sellers take seriously."}},
{"@type":"Question","name":"How long is my pre-approval valid?","acceptedAnswer":{"@type":"Answer","text":"90 days. If you have not found a home in that window, a couple of items are re-verified and the letter is refreshed."}},
{"@type":"Question","name":"What if I am not ready to apply yet?","acceptedAnswer":{"@type":"Answer","text":"Start with the 2-minute check with no credit pull, or call or text Keith at 352-619-4959 to talk it through first."}}
]}
</script>
<!-- /wp:html -->
HTML;

$content = $css . "\n" . $gpcss . "\n" . $hero . "\n\n" . $body;
if (!get_post_meta($pid,'_brm_getpre_redesign_backup',true)) add_post_meta($pid,'_brm_getpre_redesign_backup',wp_slash($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid")),true);
$wpdb->update($wpdb->posts, array('post_content'=>$content), array('ID'=>$pid));
clean_post_cache($pid);
echo "get-pre-approved REDESIGNED (".str_word_count(strip_tags($body))." visible words)\n";
