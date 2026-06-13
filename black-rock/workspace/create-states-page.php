<?php
global $wpdb;
require __DIR__ . '/hero-fn.php';
$slug='states-we-are-licensed';
if ($wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s",$slug))) { echo "exists\n"; return; }
$author=(int)$wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID=88"); if(!$author)$author=1;
$css=file_get_contents(__DIR__.'/article-css.html');

// Categorized from NMLS 376205 license types (lender/banker/lending/company/financing = correspondent; broker-only = broker)
$lender = array('Alabama','Alaska','Arizona','California','Colorado','Florida','Georgia','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maryland','Minnesota','Mississippi','Missouri','Nebraska','Nevada','New Mexico','North Carolina','Ohio','Oregon','South Carolina','Tennessee','Texas','Utah','Virginia','Washington','West Virginia');
$broker = array('Arkansas','Connecticut','District of Columbia','Maine','Michigan','Montana','New Jersey','Oklahoma','Pennsylvania','Wisconsin','U.S. Virgin Islands');
$lc = count(array_diff($lender, array())); $bc = count($broker);

$chips = function($arr,$cls) {
    $h=''; foreach($arr as $s) $h.="<span class=\"st-chip $cls\">$s</span>"; return $h;
};

$hero=brm_hero_html('Licensed in 40+ States &bull; NMLS #376205 / #303217','States We&rsquo;re Licensed In',
  'Black Rock Mortgage &mdash; a division of Coast 2 Coast Mortgage &mdash; lends across the country. Florida is home, but we close loans (and recruit loan officers) coast to coast.',
  'Get Pre-Approved','/get-pre-approved/',false);

$style = <<<'CSS'
<!-- wp:html -->
<style>
.brm-states .st-legend{display:flex;gap:22px;flex-wrap:wrap;margin:18px 0 6px;font-family:"Rubik",sans-serif;font-size:13.5px;font-weight:600;}
.brm-states .st-legend span{display:inline-flex;align-items:center;gap:8px;}
.brm-states .st-key{width:16px;height:16px;border-radius:4px;display:inline-block;}
.brm-states .st-key.lend{background:#049F82;} .brm-states .st-key.brk{background:#F5A524;} .brm-states .st-key.no{background:#e2ece9;}
.brm-states .st-grid{display:flex;flex-wrap:wrap;gap:9px;margin:14px 0 6px;}
.brm-states .st-chip{font-family:"Karla",sans-serif;font-size:14.5px;font-weight:600;padding:9px 15px;border-radius:8px;border:1px solid transparent;}
.brm-states .st-chip.lend{background:#eafaf6;color:#036b58;border-color:#bfe3d9;}
.brm-states .st-chip.brk{background:#fff6e6;color:#9a6410;border-color:#f6e2bd;}
</style>
<!-- /wp:html -->
CSS;

$lenderChips = $chips($lender,'lend');
$brokerChips = $chips($broker,'brk');

$body = <<<HTML
<!-- wp:html -->
<div class="brm-article brm-states">
<p class="brm-lead">We&rsquo;re licensed in <strong>40 states plus Washington D.C. and the U.S. Virgin Islands</strong>. In most of them we&rsquo;re a correspondent lender &mdash; meaning we close and fund your loan in-house &mdash; and in the rest we broker to a wholesale partner. Either way, you get our 200+ lender network and one local point of contact.</p>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">40</div><div class="l">states + DC &amp; USVI</div><div class="s">A truly national footprint from a Florida base</div></div>
  <div class="brm-stat"><div class="n">31</div><div class="l">correspondent states</div><div class="s">Where we close &amp; fund your loan directly</div></div>
  <div class="brm-stat"><div class="n">200+</div><div class="l">wholesale lenders</div><div class="s">Behind every loan, in every state</div></div>
</div>

<div class="brm-callout gold"><span class="tag">Loan officers &mdash; we&rsquo;re hiring</span><p>Every state on this map is a state you can <strong>originate in with us</strong>. If you&rsquo;re a licensed LO (or ready to get licensed) looking for a broker with correspondent muscle and a real local brand, this is your map of opportunity. <a href="/work-with-us/">See what it&rsquo;s like to work with us &rarr;</a></p></div>

<div class="st-legend">
  <span><i class="st-key lend"></i> Correspondent &mdash; we close your loan</span>
  <span><i class="st-key brk"></i> Broker &mdash; we place your loan</span>
  <span><i class="st-key no"></i> Not currently licensed</span>
</div>

<h2>Correspondent States &mdash; We Close Your Loan</h2>
<p>In these states we&rsquo;re a licensed mortgage lender, so we underwrite, close, and fund in-house &mdash; faster control of your file end to end.</p>
<div class="st-grid">$lenderChips</div>

<h2>Broker States &mdash; We Place Your Loan</h2>
<p>Here we broker your loan to one of our 200+ wholesale partners &mdash; same shopping power, same local service.</p>
<div class="st-grid">$brokerChips</div>

<div class="brm-callout"><span class="tag">Don&rsquo;t see your state?</span><p>Licensing changes regularly and we add states often. Call or text <a href="tel:3526194959">352-619-4959</a> and we&rsquo;ll tell you straight whether we can help where you are &mdash; or point you in the right direction.</p></div>

<div class="brm-midcta"><h3>Wherever you are, let&rsquo;s see what you qualify for</h3><p>Same 2-minute check, same local broker, 40+ states. No credit pull to start.</p><div class="btns"><a class="go" href="/get-pre-approved/">Get Pre-Approved</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div></div>

<p style="font-size:13px;color:#5b6b6b;margin-top:22px;"><em>Licensing per NMLS Consumer Access (Coast 2 Coast Mortgage, NMLS #376205). Correspondent vs. broker designation reflects license type and is subject to change &mdash; verify current authority for your state with us. Equal Housing Lender.</em></p>
</div>
<!-- /wp:html -->
HTML;

$content = $css . "\n" . $style . "\n" . $hero . "\n\n" . $body;
$pid = wp_insert_post(array('post_title'=>"States We're Licensed In",'post_name'=>$slug,'post_content'=>$content,'post_status'=>'publish','post_type'=>'page','post_author'=>$author), true);
if (is_wp_error($pid)) { echo "ERR: ".$pid->get_error_message()."\n"; return; }
$c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$c=preg_replace_callback('/content:(\s*)"([0-9a-fA-F]{4})"/', function($m){return 'content:'.$m[1].'"\\'.$m[2].'"';}, $c);
$wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$pid));
$pt=$wpdb->prefix.'aioseo_posts';
$wpdb->insert($pt,array('post_id'=>$pid,'title'=>'States We&rsquo;re Licensed In — 40+ States | Black Rock Mortgage','description'=>'Black Rock Mortgage (a division of Coast 2 Coast, NMLS #376205) is licensed in 40 states plus DC and USVI. See where we lend as a correspondent vs. broker.','created'=>current_time('mysql',true),'updated'=>current_time('mysql',true)));
clean_post_cache($pid);
echo "states page PUBLISHED (id $pid) at /$slug/ | lender:".count($lender)." broker:".count($broker)."\n";
