<?php
// Add a "Ready for a Full Application?" CTA directly below the soft form on get-pre-approved (74).
// Light-background version matching the program-page CTA (label + gold portal + Call Keith). Idempotent.
global $wpdb;
$pid = 74;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brm-gp-fullapp') !== false) { echo "already added\n"; return; }

// find end of the SOFT FORM section (the </section> after id="pa-form")
$fp = strpos($c, 'id="pa-form"');
$secEnd = strpos($c, '</section>', $fp) + strlen('</section>');

$block = <<<'HTML'

<!-- wp:html -->
<style>
.brm-gp-fullapp{text-align:center;margin:44px auto 8px;max-width:780px;padding:0 20px;font-family:"Karla",sans-serif;}
.brm-gp-fullapp .lbl{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#037a64;margin:0 0 8px;}
.brm-gp-fullapp .sub{color:#5b6b6b;font-size:15.5px;line-height:1.55;margin:0 auto 20px;max-width:600px;}
.brm-gp-fullapp .btns{display:flex;gap:13px;justify-content:center;flex-wrap:wrap;}
.brm-gp-fullapp a{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;letter-spacing:.01em;padding:14px 28px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.brm-gp-fullapp .go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.brm-gp-fullapp .go:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}
.brm-gp-fullapp .call{background:#fff !important;color:#037a64 !important;border:2px solid #cfe4de;}
.brm-gp-fullapp .call:hover{border-color:#049F82;color:#037a64 !important;transform:translateY(-1px);}
@media(max-width:720px){.brm-gp-fullapp .btns{flex-direction:column}.brm-gp-fullapp a{width:100%;max-width:340px;margin:0 auto}}
</style>
<div class="brm-gp-fullapp">
  <p class="lbl">Ready for a Full Application?</p>
  <p class="sub">The 2-minute check above is the soft start &mdash; no credit pull, no documents. When you already know you're ready to move, skip ahead and jump straight into the full secure application.</p>
  <div class="btns">
    <a class="go" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>
    <a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a>
  </div>
</div>
<!-- /wp:html -->

HTML;

$new = substr($c, 0, $secEnd) . $block . substr($c, $secEnd);
if (!get_post_meta($pid, '_brm_getpre_backup', true)) add_post_meta($pid, '_brm_getpre_backup', wp_slash($c), true);
$wpdb->update($wpdb->posts, array('post_content' => $new), array('ID' => $pid));
clean_post_cache($pid);
echo "get-pre-approved full-app CTA added below form\n";
