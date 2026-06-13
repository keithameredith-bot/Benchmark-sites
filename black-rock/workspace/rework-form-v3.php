<?php
// v3 form CTA: tighter gap above buttons + real "Call Keith" button (paired, like homepage hero).
// Regenerates the brm-prog-cta block in place on every page that has it, preserving H2/LEAD.
global $wpdb;

$NEWFORM = <<<'TPL'
<!-- wp:html -->
<style>
.brm-prog-cta {
  --pt-accent: #5dcaa5; --pt-gold: #f5a524;
  position: relative;
  background: radial-gradient(120% 90% at 80% -10%, rgba(93,202,165,0.16), transparent 60%), linear-gradient(180deg, #0f2e2d 0%, #0a1f1e 100%);
  color: #fff; padding: 90px 24px 88px; border-radius: 20px; max-width: 1200px; margin: 48px auto;
  overflow: hidden; font-family: "Karla", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-sizing: border-box;
}
.brm-prog-cta *, .brm-prog-cta *::before, .brm-prog-cta *::after { box-sizing: border-box; }
.brm-prog-cta-wrap { max-width: 1180px; margin: 0 auto; }
.brm-prog-cta-eyebrow { font-family: "Rubik", sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 0.18em; font-size: 12.5px; color: var(--pt-accent); text-align: center; margin: 0 0 14px; }
.brm-prog-cta h2 { font-family: "Rubik", sans-serif; color: #fff !important; text-align: center; font-size: clamp(30px, 4vw, 44px); text-transform: uppercase; font-weight: 800; margin: 0 0 18px; line-height: 1.15; letter-spacing: -0.005em; }
.brm-prog-cta-lead { color: #cfe0de !important; text-align: center !important; max-width: 720px; margin: 0 auto 36px !important; font-size: 17px; line-height: 1.6; }
.brm-prog-cta-form-wrap { max-width: 1000px; margin: 0 auto; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); border-radius: 10px; padding: 28px; -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); }
.brm-prog-cta-form-wrap iframe { width: 100%; border: 0; display: block; min-height: 700px; overflow: hidden; border-radius: 6px; background: #fff; }
.brm-prog-cta-actions { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; align-items: center; margin: 54px 0 0; }
.brm-prog-cta-actions a { display: inline-flex; align-items: center; justify-content: center; font-family: "Rubik", sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.01em; line-height: 1.35; padding: 15px 30px; border-radius: 6px; text-decoration: none !important; transition: all 180ms ease; }
.brm-prog-cta-portal { background: var(--pt-gold) !important; color: #1a1a1a !important; border: 2px solid var(--pt-gold); }
.brm-prog-cta-portal:hover { background: #ffb944 !important; border-color: #ffb944; color: #1a1a1a !important; transform: translateY(-1px); }
.brm-prog-cta-callbtn { background: transparent !important; color: #fff !important; border: 2px solid rgba(255,255,255,0.55); }
.brm-prog-cta-callbtn:hover { border-color: #fff; background: rgba(255,255,255,0.08) !important; color: #fff !important; transform: translateY(-1px); }
@media (max-width: 720px) {
  .brm-prog-cta { padding: 60px 18px 60px; border-radius: 14px; margin: 32px 12px; }
  .brm-prog-cta-form-wrap { padding: 16px; border-radius: 6px; }
  .brm-prog-cta-actions { flex-direction: column; margin-top: 42px; }
  .brm-prog-cta-actions a { width: 100%; max-width: 360px; }
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

    <div class="brm-prog-cta-actions">
      <a class="brm-prog-cta-portal" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>
      <a class="brm-prog-cta-callbtn" href="tel:3526194959">Call Keith: 352-619-4959</a>
    </div>
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
    $marker = strpos($c, 'brm-prog-cta');
    $fStart = strrpos(substr($c, 0, $marker), '<!-- wp:html -->');
    $fEnd = strpos($c, '<!-- /wp:html -->', $marker) + strlen('<!-- /wp:html -->');
    $block = substr($c, $fStart, $fEnd - $fStart);
    preg_match('/<h2>(.*?)<\/h2>/s', $block, $mh);
    preg_match('/<p class="brm-prog-cta-lead">(.*?)<\/p>/s', $block, $ml);
    $h2 = isset($mh[1]) ? trim($mh[1]) : 'Get Your Pre-Approval in 24 Hours';
    $lead = isset($ml[1]) ? trim($ml[1]) : "Tell us your scenario and we'll have you pre-approved in 24 hours.";
    $newForm = str_replace(array('{{H2}}','{{LEAD}}'), array($h2, $lead), $NEWFORM);
    $newC = substr($c, 0, $fStart) . $newForm . substr($c, $fEnd);
    $wpdb->update($wpdb->posts, array('post_content' => $newC), array('ID' => $pid));
    clean_post_cache($pid);
    echo str_pad($p->post_name,40)." v3 OK\n";
}
// homepage gap fix
$home = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
$home2 = str_replace('.brm-home-final-already {' . "\n" . '  text-align: center;' . "\n" . '  margin: 80px 0 0;', '.brm-home-final-already {' . "\n" . '  text-align: center;' . "\n" . '  margin: 48px 0 0;', $home);
if ($home2 === $home) { // fallback simple replace
    $home2 = preg_replace('/(\.brm-home-final-already\s*\{[^}]*?margin:\s*)80px(\s*0\s*0)/', '${1}48px${2}', $home);
}
if ($home2 !== $home) { $wpdb->update($wpdb->posts, array('post_content' => $home2), array('ID' => 38)); clean_post_cache(38); echo "homepage gap 80->48px OK\n"; }
else { echo "homepage gap: pattern not matched (check manually)\n"; }
