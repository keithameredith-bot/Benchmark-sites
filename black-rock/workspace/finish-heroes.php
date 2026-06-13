<?php
global $wpdb;
require __DIR__ . '/hero-fn.php';

// --- 1. police-officers (15780): classic HTML, prepend hero (byline, See My Options - has form) ---
$pid = 15780;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c,'class="brm-hero"')===false) {
    $cta = strpos($c,'brm-prog-cta')!==false ? array('See My Options','#see-my-options') : array('Get Pre-Approved','/get-pre-approved/');
    $hero = brm_hero_html('First Responder Mortgage &bull; NMLS #303217','Florida Home Loans for Police Officers',
      'Up to $35,000 in down payment help, plus eliminated underwriting and processing fees &mdash; our way of giving back to Florida&rsquo;s police officers, deputies, and troopers.',
      $cta[0],$cta[1],true);
    if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
    $wpdb->update($wpdb->posts,array('post_content'=>$hero."\n\n".$c),array('ID'=>$pid));
    clean_post_cache($pid);
    echo "police-officers: hero prepended\n";
} else echo "police-officers: already has hero\n";

// --- 2. About (70) + Our Team (548): replace solid Kadence hero with teal (no byline) ---
function brm_replace_first_hero($pid,$eyebrow,$sub){
    global $wpdb;
    $c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
    if(strpos($c,'class="brm-hero"')!==false){echo "  [$pid] already brm-hero\n";return;}
    $cta = strpos($c,'brm-prog-cta')!==false ? array('See My Options','#see-my-options') : array('Get Pre-Approved','/get-pre-approved/');
    $open='<!-- wp:kadence/rowlayout';$close='<!-- /wp:kadence/rowlayout -->';
    $start=strpos($c,$open); if($start===false){echo "  [$pid] no rowlayout\n";return;}
    $i=$start;$d=0;$end=null;
    while($i<strlen($c)){$no=strpos($c,$open,$i);$nc=strpos($c,$close,$i);if($nc===false)break;if($no!==false&&$no<$nc){$d++;$i=$no+strlen($open);}else{$d--;$i=$nc+strlen($close);if($d===0){$end=$i;break;}}}
    if($end===null){echo "  [$pid] unbalanced\n";return;}
    $hero=substr($c,$start,$end-$start);
    if(!preg_match('/<h1[^>]*>(.*?)<\/h1>/s',$hero,$m)){echo "  [$pid] no H1 in hero - skip\n";return;}
    $img = preg_match('/<img[^>]+>/',$hero)?'HAS-IMG':'no-img';
    $new=brm_hero_html($eyebrow,trim($m[1]),$sub,$cta[0],$cta[1],false);
    if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
    $wpdb->update($wpdb->posts,array('post_content'=>substr($c,0,$start).$new.substr($c,$end)),array('ID'=>$pid));
    clean_post_cache($pid);
    echo "  [$pid] hero replaced (old hero img: $img)\n";
}
echo "About + Our Team:\n";
brm_replace_first_hero(70,'About Black Rock Mortgage &bull; NMLS #303217','A Florida mortgage broker with a 200+ lender network behind one conversation &mdash; better rates, lower closing costs, and you talk to Keith, not a call center.');
brm_replace_first_hero(548,'Meet the Team &bull; NMLS #303217','The people behind Black Rock Mortgage &mdash; local, licensed, and focused on getting Florida buyers to the closing table.');
echo "done\n";
