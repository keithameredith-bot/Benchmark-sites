<?php
// Add VA-style brm-prog-cta lead form to core + niche loan program pages.
// - Idempotent (skips pages already having brm-prog-cta).
// - FHA: replaces its old inline iframe form block in place (no duplicate).
// - Others: inserts the form immediately before the final CTA heading (matches VA exactly).
// - Backs up original content to postmeta _brm_formcta_backup_20260611.
// EXCLUDED by instruction: VA (template/done), reverse mortgage, ALL manufactured, new construction, tools.
global $wpdb;

$FORM_TPL = <<<'TPL'
<!-- wp:html -->
<style>
.brm-prog-cta {
  --pt: #008376;
  --pt-dark: #006B5F;
  --pt-deep: #0f2e2d;
  --pt-deeper: #0a1f1e;
  --pt-accent: #5dcaa5;
  --pt-gold: #f5a524;
  position: relative;
  background:
    radial-gradient(120% 90% at 80% -10%, rgba(93,202,165,0.16), transparent 60%),
    linear-gradient(180deg, #0f2e2d 0%, #0a1f1e 100%);
  color: #fff;
  padding: 90px 24px 100px;
  border-radius: 20px;
  max-width: 1200px;
  margin: 48px auto;
  overflow: hidden;
  font-family: "Karla", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  box-sizing: border-box;
}
.brm-prog-cta *, .brm-prog-cta *::before, .brm-prog-cta *::after { box-sizing: border-box; }
.brm-prog-cta-wrap {
  max-width: 1180px;
  margin: 0 auto;
}
.brm-prog-cta-eyebrow {
  font-family: "Rubik", sans-serif;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.18em;
  font-size: 12.5px;
  color: var(--pt-accent);
  text-align: center;
  margin: 0 0 14px;
}
.brm-prog-cta h2 {
  font-family: "Rubik", sans-serif;
  color: #fff !important;
  text-align: center;
  font-size: clamp(30px, 4vw, 44px);
  text-transform: uppercase;
  font-weight: 800;
  margin: 0 0 18px;
  line-height: 1.15;
  letter-spacing: -0.005em;
}
.brm-prog-cta-lead {
  color: #cfe0de !important;
  text-align: center !important;
  max-width: 720px;
  margin: 0 auto 36px !important;
  font-size: 17px;
  line-height: 1.6;
}
.brm-prog-cta-form-wrap {
  max-width: 1000px;
  margin: 0 auto;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 10px;
  padding: 28px;
  -webkit-backdrop-filter: blur(6px);
  backdrop-filter: blur(6px);
}
.brm-prog-cta-form-wrap iframe {
  width: 100%;
  border: 0;
  display: block;
  min-height: 700px;
  overflow: hidden;
  border-radius: 6px;
  background: #fff;
}
.brm-prog-cta-arrive {
  text-align: center;
  margin: 80px 0 0;
}
.brm-prog-cta-arrive a {
  display: inline-block;
  max-width: 560px;
  padding: 14px 32px;
  background: var(--pt-gold) !important;
  color: #1a1a1a !important;
  font-family: "Rubik", sans-serif;
  font-weight: 700;
  font-size: 15.5px;
  letter-spacing: 0.01em;
  line-height: 1.35;
  border-radius: 6px;
  border: 2px solid var(--pt-gold);
  text-decoration: none !important;
  transition: all 180ms ease;
}
.brm-prog-cta-arrive a:hover {
  background: #ffb944 !important;
  border-color: #ffb944;
  color: #1a1a1a !important;
  transform: translateY(-1px);
}
@media (max-width: 720px) {
  .brm-prog-cta { padding: 60px 18px 70px; border-radius: 14px; margin: 32px 12px; }
  .brm-prog-cta-form-wrap { padding: 16px; border-radius: 6px; }
  .brm-prog-cta-arrive { margin-top: 60px; }
  .brm-prog-cta-arrive a { display: block; margin: 0 auto; max-width: 360px; }
}
</style>

<div class="brm-prog-cta" id="see-my-options">
  <div class="brm-prog-cta-wrap">
    <p class="brm-prog-cta-eyebrow">Ready When You Are</p>
    <h2>{{H2}}</h2>
    <p class="brm-prog-cta-lead">{{LEAD}}</p>

    <div class="brm-prog-cta-form-wrap">
      <iframe id="brmPreapproval"
              src="http://black-rock-mortgage.local/wp-content/uploads/forms/preapproval-form.html"
              title="See what you qualify for - Black Rock Mortgage"
              scrolling="no" loading="eager"></iframe>
    </div>

    <p class="brm-prog-cta-arrive"><a href="https://coast2coastmortgage.my1003app.com/303217/register">Ready for a full app? Apply Directly Through Our Secure Portal</a></p>
  </div>
</div>

<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){
  window.addEventListener('message', function(e){
    if(!e.data) return;
    if(e.data.brm === 'height'){
      var f = document.getElementById('brmPreapproval');
      if(f && e.data.h){ f.style.height = e.data.h + 'px'; }
    }
  });
})();
</script>
<!-- /wp:html -->
TPL;

// slug => [H2, LEAD]
$targets = array(
    'florida-usda-mortgage' => array("Get Your USDA Pre-Approval in 24 Hours", "We'll check your address for USDA eligibility, run your numbers, and have you pre-approved in 24 hours — $0 down in eligible Florida areas."),
    'fha-home-mortgage-loan' => array("Get Your FHA Pre-Approval in 24 Hours", "3.5% down and credit scores from 580. Tell us your scenario and we'll have you pre-approved in 24 hours."),
    'florida-jumbo-loan' => array("Get Your Jumbo Loan Pre-Approval", "Financing above the conforming limit with competitive rates and flexible documentation. Get pre-approved in 24 hours."),
    'condo-tel-financing-in-florida' => array("Get Your Condotel Pre-Approval", "Condotel and non-warrantable condo financing most lenders won't touch. Tell us about the unit and we'll get you an answer fast."),
    'bank-statement-mortgage-program' => array("Get Your Bank Statement Loan Pre-Approval", "Qualify on 12 or 24 months of bank statements — no tax returns. Get pre-approved in 24 hours."),
    'fha-streamline-refinance' => array("Get Your FHA Streamline Pre-Approval", "Lower your FHA rate fast — often no appraisal and reduced documentation. See what you qualify for in 24 hours."),
    'home-loans-for-police-officers' => array("Get Your Hometown Heroes Pre-Approval", "Up to $35,000 toward your purchase for Florida's frontline heroes. Get pre-approved in 24 hours."),
    'temporary-rate-buydown' => array("Get Your Rate Buydown Pre-Approval", "Lock a lower payment for your first years with a 2-1 or 3-2-1 buydown. Tell us your scenario and we'll run the numbers."),
    'florida-dscr-loan' => array("Get Your DSCR Loan Pre-Approval", "Qualify on the property's rental income — no tax returns, no personal DTI. Tell us about the deal and we'll size it up fast."),
    'conventional-mortgage-in-florida' => array("Get Your Conventional Pre-Approval", "As little as 3% down for qualified buyers, with cancellable mortgage insurance. Get pre-approved in 24 hours."),
    'self-employed-mortgage' => array("Get Your Self-Employed Mortgage Pre-Approval", "Bank statement, 1099, and P&L programs built for business owners. Get pre-approved in 24 hours."),
    'florida-non-qm-loans' => array("Get Your Non-QM Pre-Approval", "Bank statement, DSCR, asset-based, and 1099 programs for when traditional guidelines don't fit. Send us your file."),
    'florida-cash-out-refinance' => array("Get Your Cash-Out Refinance Pre-Approval", "Tap your Florida home's equity — up to 100% LTV with VA. See your numbers in 24 hours."),
    'refinance-mortgage' => array("Get Your Refinance Pre-Approval", "Lower your rate, shorten your term, or pull cash — 12 refi options across every loan type. Get a free review."),
    'home-equity-line-of-credit-in-florida' => array("Get Your HELOC Pre-Approval", "Access your equity with a flexible line of credit, often closing in days. See your offer in minutes."),
);

foreach ($targets as $slug => $copy) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    if (!$row) { echo str_pad($slug,40)." MISSING\n"; continue; }
    $pid = (int) $row->ID; $c = $row->post_content;

    if (strpos($c, 'brm-prog-cta') !== false) { echo str_pad($slug,40)." SKIP (already has form)\n"; continue; }

    $form = str_replace(array('{{H2}}','{{LEAD}}'), array(json_decode('"'.$copy[0].'"'), json_decode('"'.$copy[1].'"')), $FORM_TPL);

    $newC = null; $mode = '';
    if (strpos($c, 'brmPreapproval') !== false) {
        // FHA-style: replace old inline form wp:html block in place
        $ifi = strpos($c, 'brmPreapproval');
        $start = strrpos(substr($c, 0, $ifi), '<!-- wp:html -->');
        $endMark = '<!-- /wp:html -->';
        $end = strpos($c, $endMark, $ifi);
        if ($start === false || $end === false) { echo str_pad($slug,40)." ERROR (old form bounds)\n"; continue; }
        $end += strlen($endMark);
        $newC = substr($c, 0, $start) . $form . substr($c, $end);
        $mode = 'REPLACED old form';
    } else {
        // insert before the final CTA heading (its preceding wp: block opener)
        $lastH2 = strrpos($c, '<h2');
        if ($lastH2 === false) { echo str_pad($slug,40)." ERROR (no h2)\n"; continue; }
        $opener = strrpos(substr($c, 0, $lastH2), '<!-- wp:');
        if ($opener === false) { echo str_pad($slug,40)." ERROR (no block opener)\n"; continue; }
        $newC = substr($c, 0, $opener) . $form . "\n\n" . substr($c, $opener);
        $mode = 'INSERTED before final CTA';
    }

    if (!get_post_meta($pid, '_brm_formcta_backup_20260611', true)) {
        add_post_meta($pid, '_brm_formcta_backup_20260611', wp_slash($c), true);
    }
    $wpdb->update($wpdb->posts, array('post_content' => $newC), array('ID' => $pid));
    clean_post_cache($pid);
    echo str_pad($slug,40)." OK ($mode, post $pid)\n";
}
