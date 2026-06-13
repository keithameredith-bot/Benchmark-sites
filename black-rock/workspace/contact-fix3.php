<?php
// Re-insert the contact form embed right after the hero (the over-eager dup check removed it).
global $wpdb;
$pid = 987513017;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'id="send-message"') !== false) { echo "embed already present\n"; return; }

$heroPos = strpos($c, 'class="brm-hero"');
$heroEnd = strpos($c, '<!-- /wp:html -->', $heroPos) + strlen('<!-- /wp:html -->');

$embed = '

<!-- wp:html -->
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

$c = substr($c, 0, $heroEnd) . $embed . substr($c, $heroEnd);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "embed re-inserted after hero. send-message anchors: " . substr_count($c, 'id="send-message"') . "\n";
