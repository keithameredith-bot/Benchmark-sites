<?php
global $wpdb;
require __DIR__ . '/hero-fn.php';
$slug='reviews';
if ($wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s",$slug))) { echo "exists\n"; return; }
$author=(int)$wpdb->get_var("SELECT post_author FROM {$wpdb->posts} WHERE ID=88"); if(!$author)$author=1;
$css=file_get_contents(__DIR__.'/article-css.html');
$hero=brm_hero_html('Client Reviews &bull; NMLS #303217','What Florida Buyers Say',
  'Real reviews from real Florida clients &mdash; neighbors I&rsquo;ve helped buy, build, and refinance. Not aggregated, not bought.',
  'Get Pre-Approved','/get-pre-approved/',false);

$reviewcss = <<<'CSS'
<!-- wp:html -->
<style>
.brm-rev .gp-reviews{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin:24px 0;}
.brm-rev .gp-review{background:#fff;border:1px solid #e2ece9;border-radius:14px;padding:24px 22px;}
.brm-rev .gp-review .stars{color:#F5A524;font-size:16px;letter-spacing:2px;margin-bottom:10px;}
.brm-rev .gp-review p{font-size:15.5px;line-height:1.6;color:#41524f;margin:0 0 12px;font-style:italic;}
.brm-rev .gp-review .who{font-weight:700;color:#1c2b29;font-size:14px;}
.brm-rev .gp-googlewrap{background:#f7fbfa;border:1px solid #e2ece9;border-radius:16px;padding:26px 24px;margin:22px 0;}
@media(max-width:820px){.brm-rev .gp-reviews{grid-template-columns:1fr;}}
</style>
<!-- /wp:html -->
CSS;

$body = <<<HTML
<!-- wp:html -->
<div class="brm-article brm-rev">
<p class="brm-lead">When you work with me, you&rsquo;re not a loan number in a queue &mdash; you&rsquo;re a neighbor. Here&rsquo;s what Florida buyers and homeowners have said after closing with Black Rock Mortgage.</p>

<div class="brm-stats">
  <div class="brm-stat"><div class="n">5&#9733;</div><div class="l">average rating</div><div class="s">Across Google &mdash; real, verified clients</div></div>
  <div class="brm-stat"><div class="n">65+</div><div class="l">Google reviews</div><div class="s">And counting, from buyers across Florida</div></div>
  <div class="brm-stat"><div class="n">16 Yrs</div><div class="l">closing Florida loans</div><div class="s">Over a decade of five-star experiences</div></div>
</div>

<h2>Featured Reviews</h2>
<div class="gp-reviews">
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;I was able to purchase my first home with the guidance and help from Keith Meredith. Starting 2026 off as a homeowner with such gratitude for Keith and his team!&rdquo;</p><div class="who">&mdash; Bailee S., Dunnellon FL</div></div>
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;Keith and his team were incredibly helpful! The process flowed seamlessly from application to closing. I highly recommend Keith and his team!&rdquo;</p><div class="who">&mdash; Christine C., The Villages FL</div></div>
  <div class="gp-review"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&ldquo;Keith is so easy to work with. Professional and keeps an open line of communication, which is much appreciated in this industry! We&rsquo;ll definitely use him again and refer him to everyone we know.&rdquo;</p><div class="who">&mdash; Amy G., New Smyrna Beach FL</div></div>
</div>

<h2>All Our Google Reviews</h2>
<div class="gp-googlewrap">
[trustindex no-registration=google]
</div>

<div class="brm-midcta"><h3>Ready to start your own five-star experience?</h3><p>The free 2-minute check is the easiest first step &mdash; no credit pull, and you talk to me, not a call center.</p><div class="btns"><a class="go" href="/get-pre-approved/">Get Pre-Approved</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div></div>
</div>
<!-- /wp:html -->
HTML;

$content = $css . "\n" . $reviewcss . "\n" . $hero . "\n\n" . $body;
$pid = wp_insert_post(array('post_title'=>'Client Reviews','post_name'=>$slug,'post_content'=>$content,'post_status'=>'publish','post_type'=>'page','post_author'=>$author), true);
if (is_wp_error($pid)) { echo "ERR: ".$pid->get_error_message()."\n"; return; }
// fix any stripped glyphs from wp_insert_post
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$c = preg_replace_callback('/content:(\s*)"([0-9a-fA-F]{4})"/', function($m){return 'content:'.$m[1].'"\\'.$m[2].'"';}, $c);
$wpdb->update($wpdb->posts,array('post_content'=>$c),array('ID'=>$pid));
$pt=$wpdb->prefix.'aioseo_posts';
$wpdb->insert($pt,array('post_id'=>$pid,'title'=>'Client Reviews — 5-Star Florida Mortgage Broker | Black Rock Mortgage','description'=>'Real 5-star reviews from Florida buyers who closed with Keith Meredith at Black Rock Mortgage. See why neighbors across Florida trust a local broker.','created'=>current_time('mysql',true),'updated'=>current_time('mysql',true)));
clean_post_cache($pid);
echo "reviews page PUBLISHED (id $pid) at /reviews/\n";
