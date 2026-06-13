<?php
// Conform About (70), Keith Meredith (164), Contact (987513017) to the design system.
global $wpdb;
require_once 'C:/Users/keith/Desktop/black-rock-workspace/hero-fn.php';

function brm_find_block_end($c, $start, $name) {
    // balanced scan for nested kadence blocks
    $open = '<!-- wp:' . $name; $close = '<!-- /wp:' . $name . ' -->';
    $depth = 0; $pos = $start;
    while (true) {
        $no = strpos($c, $open, $pos + 1);
        $nc = strpos($c, $close, $pos + 1);
        if ($nc === false) return false;
        if ($no !== false && $no < $nc) { $depth++; $pos = $no; }
        else { if ($depth === 0) return $nc + strlen($close); $depth--; $pos = $nc; }
    }
}

// ---------- 1. KEITH MEREDITH (164): replace black hero ----------
$pid = 164;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brm-hero') === false) {
    if (!get_post_meta($pid, '_brm_conform_backup', true)) add_post_meta($pid, '_brm_conform_backup', wp_slash($c), true);
    $hs = strpos($c, '<!-- wp:kadence/rowlayout');
    $he = brm_find_block_end($c, $hs, 'kadence/rowlayout');
    $hero = brm_hero_html(
        'Division President &middot; NMLS #303217 &middot; Ocala, FL',
        'Keith Meredith',
        'Helping you get the right mortgage, the right way &mdash; 16+ years, \$100M+ originated, and you get me directly, not a call center.',
        'Get Pre-Approved', '/get-pre-approved/', false
    );
    $c = substr($c, 0, $hs) . $hero . substr($c, $he);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "keith-meredith: hero replaced\n";
} else echo "keith-meredith: already has brm-hero\n";

// ---------- 2. CONTACT (987513017): replace hero + form section ----------
$pid = 987513017;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (!get_post_meta($pid, '_brm_conform_backup', true)) add_post_meta($pid, '_brm_conform_backup', wp_slash($c), true);
$changed = false;
if (strpos($c, 'brm-hero') === false) {
    $hs = strpos($c, '<!-- wp:kadence/rowlayout');
    $he = brm_find_block_end($c, $hs, 'kadence/rowlayout');
    $hero = brm_hero_html(
        'We Are Easy To Reach',
        'Contact Black Rock Mortgage',
        'Call, text, email, or send a message below &mdash; you get Keith, not a call center. Replies usually land the same business day.',
        'Send a Message', '#send-message', false
    );
    $c = substr($c, 0, $hs) . $hero . substr($c, $he);
    $changed = true;
    echo "contact: hero replaced\n";
}
if (strpos($c, 'contact-form.html') === false) {
    $f = strpos($c, 'kadence/form');
    $fs = strrpos(substr($c, 0, $f), '<!-- wp:kadence/rowlayout');
    $fe = brm_find_block_end($c, $fs, 'kadence/rowlayout');
    $embed = '<!-- wp:html -->
<style>
.brm-contact-wrap{max-width:760px;margin:36px auto 10px;padding:0 16px;font-family:"Karla",-apple-system,sans-serif;}
.brm-contact-wrap .brm-c-eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#049F82;text-align:center;margin:0 0 10px;}
.brm-contact-wrap h2{font-family:"Rubik",sans-serif;font-weight:800;color:#1c2b29;text-align:center;font-size:clamp(26px,3.4vw,36px);margin:0 0 26px;}
.brm-contact-wrap iframe{width:100%;border:0;display:block;min-height:640px;overflow:hidden;}
</style>
<div class="brm-contact-wrap" id="send-message">
  <p class="brm-c-eyebrow">No Ticket Queues. No Call Centers.</p>
  <h2>Send a Message</h2>
  <iframe id="brmContact" src="/wp-content/uploads/forms/contact-form.html?v=1" title="Contact Black Rock Mortgage" scrolling="no" loading="lazy"></iframe>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){window.addEventListener("message",function(e){if(!e.data)return;if(e.data.brm==="height"){var f=document.getElementById("brmContact");if(f&&e.data.h){f.style.height=e.data.h+"px";}}});})();
</script>
<!-- /wp:html -->';
    $c = substr($c, 0, $fs) . $embed . substr($c, $fe);
    $changed = true;
    echo "contact: kadence form section -> custom n8n form\n";
}
if ($changed) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid)); clean_post_cache($pid); }

// ---------- 3. ABOUT (70): brand the black Meet-Keith section ----------
$css = wp_get_custom_css();
if (strpos($css, '/* BRM about meet-keith */') === false) {
    $css .= '

/* BRM about meet-keith */
.kb-row-layout-id70_461967-d8{background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e) !important;border-radius:16px;overflow:hidden;max-width:1200px;margin-left:auto !important;margin-right:auto !important;}
@media (max-width:720px){.kb-row-layout-id70_461967-d8{border-radius:12px;margin-left:12px !important;margin-right:12px !important;}}
';
    wp_update_custom_css_post($css);
    echo "about: meet-keith section branded (teal-dark, rounded)\n";
} else echo "about: css already present\n";
wp_cache_flush();
echo "done\n";
