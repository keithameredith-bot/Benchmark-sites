<?php
// MAP V3: replace the whole map block. Colors + status baked into each path as attributes.
// fill= inline (unbeatable), data-status for JS, <title> child for native tooltips.
global $wpdb;
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='states-we-are-licensed' AND post_type='page'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");

// 1. remove the old map block: from '<!-- wp:html -->\n<!-- brm-usmap' to its closing '<!-- /wp:html -->'
$start = strpos($c, '<!-- brm-usmap');
if ($start === false) { echo "old map marker not found\n"; return; }
$blockStart = strrpos(substr($c, 0, $start), '<!-- wp:html -->');
$blockEnd = strpos($c, '<!-- /wp:html -->', $start) + strlen('<!-- /wp:html -->');
echo "removing old block: " . ($blockEnd - $blockStart) . " bytes\n";

// 2. preprocess the SVG
$svg = file_get_contents('C:/Users/keith/Desktop/black-rock-workspace/us-states.svg');
$svg = preg_replace('/<\?xml[^>]*\?>/', '', $svg);
$svg = preg_replace('/<svg /', '<svg class="brm-usmap-svg" ', $svg, 1);

$lender = array('al','ak','az','ca','co','fl','ga','id','il','in','ia','ks','ky','la','md','mn','ms','mo','ne','nv','nm','nc','oh','or','sc','tn','tx','ut','va','wa','wv');
$broker = array('ar','ct','dc','me','mi','mt','nj','ok','pa','wi');

$svg = preg_replace_callback('/<path\s+id="([a-z]{2})"\s+name="([^"]+)"/', function($m) use ($lender, $broker) {
    $id = $m[1]; $name = $m[2];
    if (in_array($id, $lender)) { $fill = '#049F82'; $hover = '#06c9a4'; $status = 'We close your loan here'; }
    elseif (in_array($id, $broker)) { $fill = '#F5A524'; $hover = '#ffc14d'; $status = 'We broker your loan here'; }
    else { $fill = '#dfe8e5'; $hover = '#c4d6d1'; $status = 'Not currently licensed'; }
    return '<path id="' . $id . '" name="' . $name . '" fill="' . $fill . '" data-hover="' . $hover . '" data-status="' . $status . '"';
}, $svg, -1, $count);
echo "preprocessed $count state paths\n";

// add native <title> tooltips: inject right after each path's d attr close (before stroke etc.)... simpler: append <title> inside path is invalid (path is self-closing?) — check
// @svg-maps paths are NOT self-closing? they end '/>' typically. Convert: '<path ... />' -> '<path ...><title>Name — status</title></path>' via callback on full path tags
$svg = preg_replace_callback('/<path ([^>]*?)\/>/s', function($m) {
    $attrs = $m[1];
    if (preg_match('/name="([^"]+)"/', $attrs, $nm) && preg_match('/data-status="([^"]+)"/', $attrs, $st)) {
        return '<path ' . $attrs . '><title>' . $nm[1] . ' — ' . $st[1] . '</title></path>';
    }
    return $m[0];
}, $svg);

$block = <<<HTML
<!-- wp:html -->
<!-- brm-usmap-v3 : map data (c) @svg-maps/usa (MIT) -->
<style>
.brm-usmap{max-width:980px;margin:10px auto 6px;font-family:"Karla",-apple-system,sans-serif;position:relative;}
.brm-usmap-svg{width:100%;height:auto;display:block;}
.brm-usmap-svg path{stroke:#fff;stroke-width:1.2;cursor:pointer;}
.brm-usmap-tip{position:absolute;pointer-events:none;background:#0f2e2d;color:#fff;font-family:"Rubik",sans-serif;font-size:13px;font-weight:600;padding:8px 12px;border-radius:8px;white-space:nowrap;transform:translate(-50%,-130%);opacity:0;transition:opacity .12s ease;z-index:5;box-shadow:0 6px 18px rgba(0,0,0,.25);}
.brm-usmap-tip .st{color:#5dcaa5;display:block;font-size:11px;text-transform:uppercase;letter-spacing:.08em;font-weight:700;margin-top:2px;}
.brm-usmap-note{font-size:16px;font-weight:600;color:#1c2b29;text-align:center;margin:16px 0 0;display:flex;gap:18px;justify-content:center;flex-wrap:wrap;align-items:center;font-family:"Rubik",sans-serif;}
.brm-usmap-note .k{display:inline-flex;align-items:center;gap:8px;}
.brm-usmap-note .sw{width:18px;height:18px;border-radius:5px;display:inline-block;}
</style>
<div class="brm-usmap" id="brm-usmap">
$svg
<div class="brm-usmap-tip" role="tooltip"></div>
<p class="brm-usmap-note"><span class="k"><span class="sw" style="background:#049F82"></span>We close your loan</span><span class="k"><span class="sw" style="background:#F5A524"></span>We broker your loan</span><span class="k"><span class="sw" style="background:#dfe8e5"></span>Not licensed</span><span class="k" style="color:#5b6b6b;font-weight:400;">+ U.S. Virgin Islands &middot; hover any state</span></p>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1">
(function(){
var wrap=document.getElementById('brm-usmap'); if(!wrap) return;
var tip=wrap.querySelector('.brm-usmap-tip'); var cur=null;
wrap.addEventListener('mousemove',function(e){
  var p=e.target.closest('path');
  if(cur&&cur!==p){cur.setAttribute('fill',cur.getAttribute('data-fill')||cur.getAttribute('fill'));cur=null;}
  if(!p||!wrap.contains(p)){tip.style.opacity=0;return;}
  if(cur!==p){
    if(!p.getAttribute('data-fill'))p.setAttribute('data-fill',p.getAttribute('fill'));
    p.setAttribute('fill',p.getAttribute('data-hover')||p.getAttribute('fill'));
    cur=p;
  }
  tip.innerHTML=(p.getAttribute('name')||'')+'<span class="st">'+(p.getAttribute('data-status')||'')+'</span>';
  var r=wrap.getBoundingClientRect();
  tip.style.left=(e.clientX-r.left)+'px'; tip.style.top=(e.clientY-r.top)+'px'; tip.style.opacity=1;
});
wrap.addEventListener('mouseleave',function(){tip.style.opacity=0;if(cur){cur.setAttribute('fill',cur.getAttribute('data-fill'));cur=null;}});
})();
</script>
<!-- /wp:html -->
HTML;

$c = substr($c, 0, $blockStart) . $block . substr($c, $blockEnd);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "MAP V3 installed (content " . strlen($c) . " bytes)\n";
