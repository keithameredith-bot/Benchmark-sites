<?php
global $wpdb;

// 1. Bump "Ready for a Full Application?" gap 80 -> 110 on all CTAs + homepage
$rows = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%readylabel%'");
$n=0; foreach($rows as $r){ $c=str_replace('text-align:center;margin:80px 0 0;}','text-align:center;margin:110px 0 0;}',$r->post_content); if($c!==$r->post_content){$wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$r->ID));clean_post_cache($r->ID);$n++;} }
echo "spacing 80->110 on $n pages\n";

// 2. Add "Physician Loans" to the Loans dropdown in the primary menu (term 2)
$menu_id=2; $items=wp_get_nav_menu_items($menu_id);
$haveIt=false; $loansId=null; $nonqmOrder=null;
foreach($items as $it){
    if($it->title==='Physician Loans') $haveIt=true;
    if(rtrim($it->url,'/') === home_url('/loan-programs') || $it->title==='Loans') $loansId=$it->ID;
}
if(!$loansId){ // fallback: find by url contains loan-programs at top level
    foreach($items as $it){ if((int)$it->menu_item_parent===0 && strpos($it->url,'loan-programs')!==false){$loansId=$it->ID;break;} }
}
if($haveIt){ echo "menu: Physician Loans already present\n"; }
elseif(!$loansId){ echo "menu: Loans parent not found - skipped\n"; }
else {
    $cid=wp_update_nav_menu_item($menu_id,0,array(
      'menu-item-title'=>'Physician Loans','menu-item-url'=>home_url('/florida-physician-loan/'),
      'menu-item-status'=>'publish','menu-item-type'=>'custom','menu-item-parent-id'=>$loansId,
    ));
    echo "menu: added Physician Loans (item $cid) under Loans (parent $loansId)\n";
}

// 3. Gainesville highlight callout -> physician page (idempotent)
$gid=(int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='gainesville-mortgage-broker' AND post_type='page'");
if($gid){
    $c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$gid");
    if(strpos($c,'florida-physician-loan')===false){
        $callout='<!-- wp:html --><div class="brm-callout gold" style="font-family:Karla,sans-serif;"><span class="tag" style="color:#b9791a;font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;">For UF Health &amp; the medical community</span><p style="margin:6px 0 0;font-size:17.5px;line-height:1.7;">Gainesville runs on medicine &mdash; and doctors get their own loan. Our <a href="/florida-physician-loan/">Florida physician loan</a> offers <strong>100% financing up to $2M, no PMI</strong>, flexible student-loan treatment, and the ability to qualify on a signed contract before residency or your attending role even starts. Residents, fellows, dentists, pharmacists, vets, and CRNAs all qualify.</p></div><!-- /wp:html -->';
        // insert after the first </ul> in the "Why Gainesville" section, else append before FAQ
        $anchor='<h2>Loan Programs I Close in Alachua County</h2>';
        $pos=strpos($c,$anchor);
        if($pos!==false){ $c=substr($c,0,$pos).$callout."\n\n".substr($c,$pos); }
        else { $c.=$callout; }
        $wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$gid));
        clean_post_cache($gid);
        echo "gainesville: physician highlight added\n";
    } else echo "gainesville: physician link already present\n";
}
