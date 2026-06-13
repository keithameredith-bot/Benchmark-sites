<?php
// Point the brm-prog-cta iframe on mfg + construction pages to their custom form files.
// These pages currently have NO brm-prog-cta form (they were in the excluded list) — so ADD the full CTA block.
global $wpdb;

function brm_cta_block($h2, $lead, $formfile) {
    return '<!-- wp:html -->
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
    <h2>' . $h2 . '</h2>
    <p class="brm-prog-cta-lead">' . $lead . '</p>
    <div class="brm-prog-cta-form-wrap">
      <iframe id="brmPreapproval" src="http://black-rock-mortgage.local/wp-content/uploads/forms/' . $formfile . '?v=1" title="Get started with Black Rock Mortgage" scrolling="no" loading="eager"></iframe>
    </div>
    <p class="brm-prog-cta-readylabel">Ready for a Full Application?</p>
    <div class="brm-prog-cta-actions">
      <a class="brm-prog-cta-portal" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>
      <a class="brm-prog-cta-callbtn" href="tel:3526194959">Call Keith: 352-619-4959</a>
    </div>
  </div>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){window.addEventListener("message",function(e){if(!e.data)return;if(e.data.brm==="height"){var f=document.getElementById("brmPreapproval");if(f&&e.data.h){f.style.height=e.data.h+"px";}}});})();
</script>
<!-- /wp:html -->';
}

$targets = array(
  'florida-mobile-home-financing' => array('Get Your Manufactured Home Pre-Approval', 'Singlewide or doublewide, on land or moving onto it &mdash; tell me about the home and I&rsquo;ll match the right program. No SSN or credit pull on this form.', 'manufactured-form.html'),
  'florida-construction-loan' => array('Start Your Construction Loan', 'Tell me about your land, your plans, and your timeline &mdash; I&rsquo;ll match you to the right one-time-close program. No SSN or credit pull on this form.', 'construction-form.html'),
);

foreach ($targets as $slug => $cfg) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    if (!$row) { echo "MISS $slug\n"; continue; }
    $c = $row->post_content; $pid = (int)$row->ID;
    if (strpos($c, 'brm-prog-cta') !== false) {
        // already has a (generic) CTA — just point its iframe at the custom form
        $c = preg_replace('/preapproval-form\.html(\?v=\d+)?/', $cfg[2] . '?v=1', $c);
        $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
        clean_post_cache($pid);
        echo "$slug: existing form -> {$cfg[2]}\n";
        continue;
    }
    // add the CTA before the final heading (or append). Insert before the LAST brm-keith/story or at end of brm-article.
    $block = brm_cta_block($cfg[0], $cfg[1], $cfg[2]);
    // place right before the closing of the article wrapper if present, else append
    $marker = '</div>' . "\n" . '<!-- /wp:html -->'; // end of a brm-article html block — unreliable; just append cleanly
    if (!get_post_meta($pid, '_brm_customform_backup', true)) add_post_meta($pid, '_brm_customform_backup', wp_slash($c), true);
    $c = $c . "\n\n" . $block;
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "$slug: custom CTA added ({$cfg[2]})\n";
}
echo "done\n";
