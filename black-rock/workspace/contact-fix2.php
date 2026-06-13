<?php
// Excise the ENTIRE old form section (rowlayout 45e17c-fa, balanced scan) and put the embed at its spot.
global $wpdb;
$pid = 987513017;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");

function brm_find_block_end2($c, $start, $name) {
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

$s = strpos($c, '<!-- wp:kadence/rowlayout {"uniqueID":"987513017_45e17c-fa"');
if ($s === false) { echo "section not found (already fixed?)\n"; return; }
$e = brm_find_block_end2($c, $s, 'kadence/rowlayout');

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

$c = substr($c, 0, $s) . $embed . substr($c, $e);
// remove the earlier misplaced embed if it survived inside the excised range it didn't — check duplicates
if (substr_count($c, 'brm-contact-wrap') > 1) {
    // drop the second occurrence's whole wp:html block
    $first = strpos($c, 'brm-contact-wrap');
    $second = strpos($c, 'brm-contact-wrap', $first + 10);
    $bs = strrpos(substr($c, 0, $second), '<!-- wp:html -->');
    $be = strpos($c, '<!-- /wp:html -->', $second) + strlen('<!-- /wp:html -->');
    $c = substr($c, 0, $bs) . substr($c, $be);
    echo "duplicate embed removed\n";
}
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "old form section excised; embed placed. kadence/form remaining: " . substr_count($c, 'wp:kadence/form') . ", embeds: " . substr_count($c, 'brm-contact-wrap') . "\n";
