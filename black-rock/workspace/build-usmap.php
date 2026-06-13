<?php
// Insert interactive licensed-states US map into /states-we-are-licensed/ (after hero). Idempotent.
// SVG: @svg-maps/usa (MIT). Categories from NMLS 376205 (see PROJECT-STATUS).
global $wpdb;
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='states-we-are-licensed' AND post_type='page'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brm-usmap') !== false) { echo "map already inserted\n"; return; }

$svg = file_get_contents('C:/Users/keith/Desktop/black-rock-workspace/us-states.svg');
if (!$svg) { echo "svg not readable\n"; return; }
// strip xml decl if any; ensure single root svg kept
$svg = preg_replace('/<\?xml[^>]*\?>/', '', $svg);
// give the svg a class hook
$svg = preg_replace('/<svg /', '<svg class="brm-usmap-svg" ', $svg, 1);

$lender = array('al','ak','az','ca','co','fl','ga','id','il','in','ia','ks','ky','la','md','mn','ms','mo','ne','nv','nm','nc','oh','or','sc','tn','tx','ut','va','wa','wv');
$broker = array('ar','ct','dc','me','mi','mt','nj','ok','pa','wi');
$lendSel = implode(',', array_map(fn($s)=>".brm-usmap-svg #$s", $lender));
$brokSel = implode(',', array_map(fn($s)=>".brm-usmap-svg #$s", $broker));

$block = <<<HTML

<!-- wp:html -->
<!-- brm-usmap : map data (c) @svg-maps/usa (MIT) -->
<style>
.brm-usmap{max-width:980px;margin:10px auto 6px;font-family:"Karla",-apple-system,sans-serif;position:relative;}
.brm-usmap-svg{width:100%;height:auto;display:block;}
.brm-usmap-svg path{fill:#dfe8e5;stroke:#fff;stroke-width:1.2;transition:fill .15s ease,opacity .15s ease;cursor:pointer;}
$lendSel{fill:#049F82;}
$brokSel{fill:#F5A524;}
.brm-usmap-svg path:hover{opacity:.78;}
.brm-usmap-tip{position:absolute;pointer-events:none;background:#0f2e2d;color:#fff;font-family:"Rubik",sans-serif;font-size:13px;font-weight:600;padding:8px 12px;border-radius:8px;white-space:nowrap;transform:translate(-50%,-130%);opacity:0;transition:opacity .12s ease;z-index:5;box-shadow:0 6px 18px rgba(0,0,0,.25);}
.brm-usmap-tip .st{color:#5dcaa5;display:block;font-size:11px;text-transform:uppercase;letter-spacing:.08em;font-weight:700;margin-top:2px;}
.brm-usmap-note{font-size:13px;color:#5b6b6b;text-align:center;margin:10px 0 0;}
</style>
<div class="brm-usmap" id="brm-usmap">
$svg
<div class="brm-usmap-tip" role="tooltip"></div>
<p class="brm-usmap-note">Hover any state &middot; Teal = we close your loan in-house &middot; Gold = we broker your loan &middot; Gray = not currently licensed. Also licensed in the U.S. Virgin Islands.</p>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1">
(function(){
var wrap=document.getElementById('brm-usmap'); if(!wrap) return;
var tip=wrap.querySelector('.brm-usmap-tip');
var L="al ak az ca co fl ga id il in ia ks ky la md mn ms mo ne nv nm nc oh or sc tn tx ut va wa wv".split(" ");
var B="ar ct dc me mi mt nj ok pa wi".split(" ");
wrap.querySelectorAll('.brm-usmap-svg path').forEach(function(p){
  p.addEventListener('mousemove',function(e){
    var id=p.id, n=p.getAttribute('name')||id.toUpperCase();
    var status = L.indexOf(id)>-1 ? 'We close your loan here' : (B.indexOf(id)>-1 ? 'We broker your loan here' : 'Not currently licensed');
    tip.innerHTML=n+'<span class="st">'+status+'</span>';
    var r=wrap.getBoundingClientRect();
    tip.style.left=(e.clientX-r.left)+'px';
    tip.style.top=(e.clientY-r.top)+'px';
    tip.style.opacity=1;
  });
  p.addEventListener('mouseleave',function(){ tip.style.opacity=0; });
});
})();
</script>
<!-- /wp:html -->

HTML;

// insert after the hero (first closing wp:html)
$he = strpos($c, '<!-- /wp:html -->') + strlen('<!-- /wp:html -->');
$c = substr($c, 0, $he) . $block . substr($c, $he);
$wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $pid));
clean_post_cache($pid);
echo "interactive US map inserted (post $pid, content now " . strlen($c) . " bytes)\n";
