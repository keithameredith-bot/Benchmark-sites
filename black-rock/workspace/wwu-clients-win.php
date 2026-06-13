<?php
// New section: "Your clients win too" — image + earn-more/clients-pay-less pitch.
// Placed between the weekly-pay band and the honest cost sheet.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'broker-savings-10662') !== false) { echo "already added\n"; return; }

$sec = '<!-- CLIENTS WIN -->
<div class="sec" style="padding-top:10px;">
  <p class="kick">The Part That Makes It Sustainable</p>
  <h2>You earn more. Your clients pay less.</h2>
  <div style="display:flex;align-items:center;gap:36px;max-width:1020px;margin:24px auto 0;flex-wrap:wrap;">
    <img src="/wp-content/uploads/wwu/broker-savings-10662.webp" alt="Mortgage brokers on average save their clients $10,662 over the life of the loan" style="width:340px;max-width:100%;border-radius:14px;flex:0 0 auto;box-shadow:0 14px 36px -16px rgba(15,46,45,.3);" loading="lazy">
    <div style="flex:1;min-width:280px;">
      <p style="font-size:17px;line-height:1.7;margin:0 0 14px;">Here&rsquo;s the question every honest banker asks: <em>&ldquo;If I make more per loan, doesn&rsquo;t my client pay for it?&rdquo;</em> No &mdash; and this is the whole reason the broker model wins. With 200+ wholesale lenders competing for every file, your clients get <strong>equal or better rates than retail</strong> &mdash; on average, brokers save their clients about <strong>\$10,662 over the life of the loan</strong>.</p>
      <p style="font-size:17px;line-height:1.7;margin:0 0 14px;">The money you both gain doesn&rsquo;t come from your client. It comes from the layer that disappears: the bank&rsquo;s branch overhead, the call center, the brand advertising &mdash; the margin retail builds into every rate sheet.</p>
      <p style="font-size:17px;line-height:1.7;margin:0;"><strong>And that&rsquo;s your flywheel:</strong> clients who got a genuinely better deal refer like crazy. Earning more while your clients win isn&rsquo;t a contradiction here &mdash; it&rsquo;s the business model.</p>
      <p style="font-size:12.5px;color:#8aa19c;margin:14px 0 0;">Savings figure per independent analysis of federal HMDA mortgage data.</p>
    </div>
  </div>
</div>

<!-- HONEST COST SHEET -->';
$c = str_replace('<!-- HONEST COST SHEET -->', $sec, $c);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "clients-win section added\n";
