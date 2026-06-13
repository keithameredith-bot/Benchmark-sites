<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=74");
// the wrapper div class around the iframe
$i = strpos($c, '<iframe id="brmPreapproval"');
$wrapStart = strrpos(substr($c,0,$i), '<div class="');
echo "wrapper before iframe: " . substr($c, $wrapStart, 80) . "\n\n";
// find iframe-related CSS (search 'iframe' in style)
$o=0;
while(($p=stripos($c,'iframe',$o))!==false){
  $ctx = substr($c, max(0,$p-60), 160);
  if (strpos($ctx,'{')!==false || strpos($ctx,'height')!==false) echo "iframe css ctx @$p: " . preg_replace('/\s+/',' ',$ctx) . "\n";
  $o=$p+6;
}
echo "\n=== any min-height/height near 'brmPreapproval' selector in CSS ===\n";
preg_match_all('/#brmPreapproval[^{]*\{[^}]*\}|\.gp-[a-z\-]*\s*iframe[^{]*\{[^}]*\}/', $c, $m);
foreach ($m[0] as $r) echo $r . "\n";
