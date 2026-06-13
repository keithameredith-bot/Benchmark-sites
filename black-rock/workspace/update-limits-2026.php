<?php
// 2026 limits: swap FHA page tier table to 2026 + add interactive county lookup tool to /loan-limits/.
global $wpdb;

// ---------- 1. FHA PAGE (56): heading, intro, table, footnote ----------
$pid = 56;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$orig = $c;
$c = str_replace('2025 Florida FHA Loan Limits by County', '2026 Florida FHA Loan Limits by County', $c);
$c = str_replace("Here's the 2025 breakdown.", "Here's the 2026 breakdown.", $c);
$c = str_replace('published 2025 FHA Forward Mortgage Limits', 'published 2026 FHA Forward Mortgage Limits', $c);

// replace the first wp:table after the limits heading
$hp = strpos($c, '2026 Florida FHA Loan Limits by County');
$ts = strpos($c, '<!-- wp:table', $hp);
$teEnd = strpos($c, '<!-- /wp:table -->', $ts) + strlen('<!-- /wp:table -->');
$newTable = <<<'HTML'
<!-- wp:table {"className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table class="has-fixed-layout"><thead><tr><th>County / Tier</th><th>1 Unit</th><th>2 Unit</th><th>3 Unit</th><th>4 Unit</th></tr></thead><tbody><tr><td><strong>Standard limit (most FL counties, incl. Marion, Alachua, Citrus)</strong></td><td>$541,287</td><td>$693,050</td><td>$837,700</td><td>$1,041,125</td></tr><tr><td>Manatee &amp; Sarasota</td><td>$547,400</td><td>$700,750</td><td>$847,050</td><td>$1,052,700</td></tr><tr><td>Baker, Clay, Duval, Nassau &amp; St. Johns (Jacksonville)</td><td>$580,750</td><td>$743,450</td><td>$898,700</td><td>$1,116,850</td></tr><tr><td>Martin, St. Lucie, Okaloosa &amp; Walton</td><td>$603,750</td><td>$772,900</td><td>$934,250</td><td>$1,161,050</td></tr><tr><td>Broward, Miami-Dade &amp; Palm Beach</td><td>$667,000</td><td>$853,900</td><td>$1,032,150</td><td>$1,282,700</td></tr><tr><td>Collier (Naples)</td><td>$764,750</td><td>$979,000</td><td>$1,183,400</td><td>$1,470,700</td></tr><tr><td>Monroe (Florida Keys)</td><td>$990,150</td><td>$1,267,600</td><td>$1,532,200</td><td>$1,904,150</td></tr></tbody></table></figure>
<!-- /wp:table -->
HTML;
$c = substr($c, 0, $ts) . $newTable . substr($c, $teEnd);
if ($c !== $orig) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid)); clean_post_cache($pid); echo "FHA page table -> 2026\n"; }

// ---------- 2. LOAN LIMITS PAGE (987514594): lookup tool + title 2026 ----------
$pid = 987514594;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'brm-limits-tool') === false) {
$tool = <<<'HTML'

<!-- wp:html -->
<style>
.brm-limits-tool{font-family:"Karla",-apple-system,sans-serif;max-width:980px;margin:26px auto;}
.brm-limits-tool .lt-search{width:100%;padding:15px 18px;font-size:17px;border:2px solid #cfe4de;border-radius:10px;font-family:inherit;box-sizing:border-box;}
.brm-limits-tool .lt-search:focus{outline:none;border-color:#049F82;}
.brm-limits-tool .lt-meta{font-size:13.5px;color:#5b6b6b;margin:10px 2px 14px;}
.brm-limits-tool .lt-wrap{overflow-x:auto;border:1px solid #e2ece9;border-radius:12px;}
.brm-limits-tool table{width:100%;border-collapse:collapse;min-width:680px;}
.brm-limits-tool th{background:#0f2e2d;color:#fff;font-family:"Rubik",sans-serif;font-size:13px;text-align:left;padding:12px 14px;position:sticky;top:0;}
.brm-limits-tool td{padding:11px 14px;border-top:1px solid #eef3f1;font-size:14.5px;}
.brm-limits-tool tr:nth-child(even) td{background:#f7fbfa;}
.brm-limits-tool td.cty{font-weight:700;color:#1c2b29;}
.brm-limits-tool .hi td{background:#fff8ec !important;}
</style>
<div class="brm-limits-tool" id="limits-tool">
  <input class="lt-search" type="text" placeholder="Type your county &mdash; e.g. Marion, Duval, Collier..." aria-label="Search Florida county loan limits">
  <p class="lt-meta">2026 limits, all 67 Florida counties &middot; FHA single-family + conventional conforming (1 unit) &middot; multi-unit limits available &mdash; ask us</p>
  <div class="lt-wrap"><table><thead><tr><th>County</th><th>FHA (1 unit)</th><th>FHA (2 unit)</th><th>Conforming (1 unit)</th><th>Conforming (2 unit)</th></tr></thead><tbody id="lt-body"></tbody></table></div>
</div>
<script data-cfasync="false" data-no-optimize="1" data-no-defer="1">
(function(){
var T={s:[541287,693050,837700,1041125],ms:[547400,700750,847050,1052700],jx:[580750,743450,898700,1116850],mw:[603750,772900,934250,1161050],se:[667000,853900,1032150,1282700],cl:[764750,979000,1183400,1470700],mo:[990150,1267600,1532200,1904150]};
var CONF=[832750,1066250,1288800,1601750], CONF_MONROE=[990150,1267600,1532200,1904150];
var C={"Alachua":"s","Baker":"jx","Bay":"s","Bradford":"s","Brevard":"s","Broward":"se","Calhoun":"s","Charlotte":"s","Citrus":"s","Clay":"jx","Collier":"cl","Columbia":"s","DeSoto":"s","Dixie":"s","Duval":"jx","Escambia":"s","Flagler":"s","Franklin":"s","Gadsden":"s","Gilchrist":"s","Glades":"s","Gulf":"s","Hamilton":"s","Hardee":"s","Hendry":"s","Hernando":"s","Highlands":"s","Hillsborough":"s","Holmes":"s","Indian River":"s","Jackson":"s","Jefferson":"s","Lafayette":"s","Lake":"s","Lee":"s","Leon":"s","Levy":"s","Liberty":"s","Madison":"s","Manatee":"ms","Marion":"s","Martin":"mw","Miami-Dade":"se","Monroe":"mo","Nassau":"jx","Okaloosa":"mw","Okeechobee":"s","Orange":"s","Osceola":"s","Palm Beach":"se","Pasco":"s","Pinellas":"s","Polk":"s","Putnam":"s","Santa Rosa":"s","Sarasota":"ms","Seminole":"s","St. Johns":"jx","St. Lucie":"mw","Sumter":"s","Suwannee":"s","Taylor":"s","Union":"s","Volusia":"s","Wakulla":"s","Walton":"mw","Washington":"s"};
function fmt(n){return "$"+n.toLocaleString();}
var body=document.getElementById("lt-body");
function render(filter){
  var html="";
  Object.keys(C).forEach(function(name){
    if(filter && name.toLowerCase().indexOf(filter)===-1) return;
    var fha=T[C[name]], conf=(name==="Monroe")?CONF_MONROE:CONF;
    html+='<tr class="'+(filter?'hi':'')+'"><td class="cty">'+name+'</td><td>'+fmt(fha[0])+'</td><td>'+fmt(fha[1])+'</td><td>'+fmt(conf[0])+'</td><td>'+fmt(conf[1])+'</td></tr>';
  });
  body.innerHTML=html||'<tr><td colspan="5">No county matches &mdash; check the spelling.</td></tr>';
}
render("");
document.querySelector(".brm-limits-tool .lt-search").addEventListener("input",function(){render(this.value.trim().toLowerCase());});
})();
</script>
<!-- /wp:html -->

HTML;
    // insert right after the hero block (first closing wp:html)
    $he = strpos($c, '<!-- /wp:html -->') + strlen('<!-- /wp:html -->');
    $c = substr($c, 0, $he) . $tool . substr($c, $he);
    $c = str_replace('(2025)', '(2026)', $c);
    $c = str_replace('2025 FHA', '2026 FHA', $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "loan-limits: 2026 lookup tool added\n";
} else echo "loan-limits: tool already present\n";

// AIOSEO title 2025 -> 2026 on loan-limits
$t = $wpdb->prefix.'aioseo_posts';
$row = $wpdb->get_row($wpdb->prepare("SELECT id, title, description FROM $t WHERE post_id=%d", $pid));
if ($row && strpos($row->title,'2025')!==false) {
    $wpdb->update($t, array('title'=>str_replace('2025','2026',$row->title), 'description'=>str_replace('2025','2026',(string)$row->description), 'updated'=>current_time('mysql',true)), array('id'=>$row->id));
    echo "loan-limits AIOSEO title -> 2026\n";
}
$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_title=REPLACE(post_title,'(2025)','(2026)') WHERE ID=%d", $pid));
echo "done\n";
