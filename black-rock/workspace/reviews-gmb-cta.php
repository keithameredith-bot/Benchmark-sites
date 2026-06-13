<?php
// Reviews page: add "Leave us a Google review" CTA (after hero) with Keith's GMB review link.
global $wpdb;
$row = $wpdb->get_row("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name='reviews' AND post_type='page' AND post_status='publish'");
if (!$row) { echo "reviews page missing\n"; return; }
$pid = (int)$row->ID; $c = $row->post_content;
if (strpos($c, 'g.page/r/CeKWc2LdGGbuEBM') !== false) { echo "already added\n"; return; }

$block = '<!-- wp:html --><!-- brm-gmb-cta -->
<div style="max-width:860px;margin:34px auto;padding:0 16px;font-family:Karla,-apple-system,sans-serif;">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:22px;flex-wrap:wrap;background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:14px;padding:26px 30px;">
    <div style="flex:1;min-width:240px;">
      <p style="margin:0 0 4px;font-size:20px;letter-spacing:2px;color:#F5A524;">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
      <p style="font-family:Rubik,sans-serif;font-weight:800;font-size:20px;color:#1c2b29;margin:0 0 6px;">Did we earn your five stars?</p>
      <p style="margin:0;font-size:15.5px;color:#465552;line-height:1.6;">If Keith and the team helped you get home, a Google review takes 60 seconds &mdash; and it helps the next Florida family find honest help.</p>
    </div>
    <a href="https://g.page/r/CeKWc2LdGGbuEBM/review" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;background:#F5A524;color:#1a1a1a;font-family:Rubik,sans-serif;font-weight:700;font-size:15px;padding:14px 28px;border-radius:6px;text-decoration:none;white-space:nowrap;">Leave a Google Review &rarr;</a>
  </div>
</div>
<!-- /wp:html -->';

$heroPos = strpos($c, 'class="brm-hero"');
if ($heroPos !== false) {
    $heroEnd = strpos($c, '<!-- /wp:html -->', $heroPos) + strlen('<!-- /wp:html -->');
    $c = substr($c, 0, $heroEnd) . "\n\n" . $block . substr($c, $heroEnd);
} else $c .= "\n\n" . $block;

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "GMB review CTA added to reviews page ($pid)\n";
