<?php
// Rework the brm-prog-cta form block on all pages that have it:
//  1. DELETE the redundant bottom CTA section (everything after the form block).
//  2. Add space above the gold "arrive" portal button.
//  3. Add a desktop phone button under it (hidden on mobile — sticky bar covers calling).
// Preserves each page's H2/LEAD. Idempotent (regenerates from a fresh template each run).
// Reversible: backs up to postmeta _brm_formcta_v2_backup_20260611.
global $wpdb;

$NEWFORM = <<<'TPL'
<!-- wp:html -->
<style>
.brm-prog-cta {
  --pt-accent: #5dcaa5;
  --pt-gold: #f5a524;
  position: relative;
  background:
    radial-gradient(120% 90% at 80% -10%, rgba(93,202,165,0.16), transparent 60%),
    linear-gradient(180deg, #0f2e2d 0%, #0a1f1e 100%);
  color: #fff;
  padding: 90px 24px 90px;
  border-radius: 20px;
  max-width: 1200px;
  margin: 48px auto;
  overflow: hidden;
  font-family: "Karla", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  box-sizing: border-box;
}
.brm-prog-cta *, .brm-prog-cta *::before, .brm-prog-cta *::after { box-sizing: border-box; }
.brm-prog-cta-wrap { max-width: 1180px; margin: 0 auto; }
.brm-prog-cta-eyebrow {
  font-family: "Rubik", sans-serif;
  font-weight: 700; text-transform: uppercase; letter-spacing: 0.18em;
  font-size: 12.5px; color: var(--pt-accent); text-align: center; margin: 0 0 14px;
}
.brm-prog-cta h2 {
  font-family: "Rubik", sans-serif; color: #fff !important; text-align: center;
  font-size: clamp(30px, 4vw, 44px); text-transform: uppercase; font-weight: 800;
  margin: 0 0 18px; line-height: 1.15; letter-spacing: -0.005em;
}
.brm-prog-cta-lead {
  color: #cfe0de !important; text-align: center !important; max-width: 720px;
  margin: 0 auto 36px !important; font-size: 17px; line-height: 1.6;
}
.brm-prog-cta-form-wrap {
  max-width: 1000px; margin: 0 auto;
  background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12);
  border-radius: 10px; padding: 28px;
  -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
}
.brm-prog-cta-form-wrap iframe {
  width: 100%; border: 0; display: block; min-height: 700px; overflow: hidden;
  border-radius: 6px; background: #fff;
}
.brm-prog-cta-arrive { text-align: center; margin: 104px 0 0 !important; }
.brm-prog-cta-arrive a {
  display: inline-block; max-width: 560px; padding: 14px 32px;
  background: var(--pt-gold) !important; color: #1a1a1a !important;
  font-family: "Rubik", sans-serif; font-weight: 700; font-size: 15.5px;
  letter-spacing: 0.01em; line-height: 1.35; border-radius: 6px;
  border: 2px solid var(--pt-gold); text-decoration: none !important;
  transition: all 180ms ease;
}
.brm-prog-cta-arrive a:hover {
  background: #ffb944 !important; border-color: #ffb944; color: #1a1a1a !important;
  transform: translateY(-1px);
}
.brm-prog-cta-call { text-align: center; margin: 18px 0 0 !important; }
.brm-prog-cta-call a {
  color: #cfe0de !important; font-family: "Rubik", sans-serif; font-weight: 600;
  font-size: 14.5px; text-decoration: none !important; border-bottom: 1px solid rgba(255,255,255,0.25);
  padding-bottom: 2px; transition: color 160ms ease, border-color 160ms ease;
}
.brm-prog-cta-call a:hover { color: #fff !important; border-color: #fff; }
@media (max-width: 720px) {
  .brm-prog-cta { padding: 60px 18px 64px; border-radius: 14px; margin: 32px 12px; }
  .brm-prog-cta-form-wrap { padding: 16px; border-radius: 6px; }
  .brm-prog-cta-arrive { margin-top: 80px !important; }
  .brm-prog-cta-arrive a { display: block; margin: 0 auto; max-width: 360px; }
  .brm-prog-cta-call { display: none; }
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
    <p class="brm-prog-cta-call"><a href="tel:3526194959">Prefer to talk first? Call Keith: 352-619-4959</a></p>
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

$pages = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%brm-prog-cta%'");
foreach ($pages as $p) {
    $c = $p->post_content; $pid = (int) $p->ID;
    $fStart = strpos($c, '<!-- wp:html -->');
    // ensure this wp:html is the form (contains brm-prog-cta)
    while ($fStart !== false && strpos($c, 'brm-prog-cta', $fStart) > strpos($c, '<!-- /wp:html -->', $fStart)) {
        $fStart = strpos($c, '<!-- wp:html -->', $fStart + 5);
    }
    if ($fStart === false) { echo str_pad($p->post_name,40)." no form block?\n"; continue; }
    $fEndMark = '<!-- /wp:html -->';
    $fEnd = strpos($c, $fEndMark, $fStart) + strlen($fEndMark);
    $block = substr($c, $fStart, $fEnd - $fStart);

    // extract H2 + LEAD from existing block
    preg_match('/<h2>(.*?)<\/h2>/s', $block, $mh);
    preg_match('/<p class="brm-prog-cta-lead">(.*?)<\/p>/s', $block, $ml);
    $h2 = isset($mh[1]) ? trim($mh[1]) : 'Get Your Pre-Approval in 24 Hours';
    $lead = isset($ml[1]) ? trim($ml[1]) : "Tell us your scenario and we'll have you pre-approved in 24 hours.";

    $tail = substr($c, $fEnd);
    $tailHeading = preg_match('/<h2[^>]*>(.*?)<\/h2>/s', $tail, $mt) ? trim(strip_tags($mt[1])) : '(none)';

    $newForm = str_replace(array('{{H2}}','{{LEAD}}'), array($h2, $lead), $NEWFORM);
    $newC = rtrim(substr($c, 0, $fStart)) . "\n\n" . $newForm . "\n";

    if (!get_post_meta($pid, '_brm_formcta_v2_backup_20260611', true)) {
        add_post_meta($pid, '_brm_formcta_v2_backup_20260611', wp_slash($c), true);
    }
    $wpdb->update($wpdb->posts, array('post_content' => $newC), array('ID' => $pid));
    clean_post_cache($pid);
    echo str_pad($p->post_name,40)." OK (dropped bottom CTA: '$tailHeading', " . strlen($tail) . " bytes)\n";
}
