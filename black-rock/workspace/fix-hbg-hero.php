<?php
global $wpdb;
require __DIR__ . '/hero-fn.php';
$pid = 771;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c,'class="brm-hero"')!==false) { echo "already brm-hero\n"; return; }
$cta = strpos($c,'brm-prog-cta')!==false ? array('See My Options','#see-my-options') : array('Get Pre-Approved','/get-pre-approved/');
$open='<!-- wp:kadence/rowlayout';$close='<!-- /wp:kadence/rowlayout -->';
$start=strpos($c,$open);
$i=$start;$d=0;$end=null;
while($i<strlen($c)){$no=strpos($c,$open,$i);$nc=strpos($c,$close,$i);if($nc===false)break;if($no!==false&&$no<$nc){$d++;$i=$no+strlen($open);}else{$d--;$i=$nc+strlen($close);if($d===0){$end=$i;break;}}}
$hero=substr($c,$start,$end-$start);
$h1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/s',$hero,$m)?trim($m[1]):"Florida Home Buyer's Survival Guide";
$new = brm_hero_html('Free Florida Home Buyer Resource &bull; NMLS #303217', $h1,
  'Everything a first-time Florida buyer needs &mdash; from credit and budgeting to closing day &mdash; in one free, no-jargon guide written by a local broker who&rsquo;s closed thousands of these.',
  $cta[0], $cta[1], false);
if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
$wpdb->update($wpdb->posts,array('post_content'=>substr($c,0,$start).$new.substr($c,$end)),array('ID'=>$pid));
clean_post_cache($pid);
echo "home-buyers-survival-guide hero -> teal (H1: $h1)\n";
