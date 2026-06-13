<?php
global $wpdb;
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='states-we-are-licensed' AND post_type='page'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, '/* brm-hover-v2 */') !== false) { echo "already v2\n"; return; }

$lender = array('al','ak','az','ca','co','fl','ga','id','il','in','ia','ks','ky','la','md','mn','ms','mo','ne','nv','nm','nc','oh','or','sc','tn','tx','ut','va','wa','wv');
$broker = array('ar','ct','dc','me','mi','mt','nj','ok','pa','wi');
$lh = implode(',', array_map(fn($s)=>".brm-usmap-svg #$s:hover", $lender));
$bh = implode(',', array_map(fn($s)=>".brm-usmap-svg #$s:hover", $broker));

$old = '.brm-usmap-svg path:hover{filter:brightness(1.25) saturate(1.15);stroke:#0f2e2d;stroke-width:1.8;}';
$new = '/* brm-hover-v2 */
.brm-usmap-svg path:hover{fill:#b9cdc8 !important;stroke:#0f2e2d !important;stroke-width:2 !important;}
' . $lh . '{fill:#06c9a4 !important;}
' . $bh . '{fill:#ffc14d !important;}';

if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
} else {
    // fallback: inject after the path base rule
    $anchor = '.brm-usmap-svg path{fill:#dfe8e5;stroke:#fff;stroke-width:1.2;transition:fill .15s ease,opacity .15s ease;cursor:pointer;}';
    if (strpos($c, $anchor) === false) { echo "no anchor found\n"; return; }
    $c = str_replace($anchor, $anchor . "\n" . $new, $c);
}

// JS: switch per-path listeners to delegation (works even if script loads late)
$oldJs = "wrap.querySelectorAll('.brm-usmap-svg path').forEach(function(p){";
if (strpos($c, $oldJs) !== false) {
    $newJs = "wrap.addEventListener('mousemove',function(e){
  var p=e.target.closest('path'); if(!p||!wrap.contains(p)){tip.style.opacity=0;return;}
  var id=p.id, n=p.getAttribute('name')||id.toUpperCase();
  var status = L.indexOf(id)>-1 ? 'We close your loan here' : (B.indexOf(id)>-1 ? 'We broker your loan here' : 'Not currently licensed');
  tip.innerHTML=n+'<span class=\"st\">'+status+'</span>';
  var r=wrap.getBoundingClientRect();
  tip.style.left=(e.clientX-r.left)+'px';
  tip.style.top=(e.clientY-r.top)+'px';
  tip.style.opacity=1;
});
wrap.addEventListener('mouseleave',function(){tip.style.opacity=0;});
/* legacy per-path block disabled */
false && wrap.querySelectorAll('.brm-usmap-svg path').forEach(function(p){";
    $c = str_replace($oldJs, $newJs, $c);
}
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "map hover v2: explicit hover fills (!important) + delegated tooltip\n";
