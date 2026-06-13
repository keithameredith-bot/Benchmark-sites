<?php
// Fix UWM cards: 1% buydown is a SOMETIMES promotion, not an everyday perk.
// Merge cards 1+2 into one wide "promo calendar" card (examples framing); doc stamps keeps "everyday" contrast.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");

$old1 = '<div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Free 1% one-year buydowns</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Year-round incentives for your buyers &mdash; like a free 1% rate buydown for year one. A closing gift your retail competitor can&rsquo;t match.</p></div>
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;"><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">Appraisal credits &amp; refi incentives</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">Appraisal credits at closing and recurring refinance incentives &mdash; running every day, no promotion required.</p></div>';
$new1 = '<div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;grid-column:span 2;" class="wwu-uwm-wide"><style>@media(max-width:880px){.wwu-uwm-wide{grid-column:span 1 !important;}}</style><p style="font-family:Rubik,sans-serif;font-weight:700;font-size:15.5px;color:#7be3c4;margin:0 0 6px;">A promotions calendar worth real money</p><p style="font-size:14.5px;color:#cfe0de;line-height:1.55;margin:0;">UWM runs buyer incentives throughout the year &mdash; promotions like <strong>free 1% one-year rate buydowns</strong>, appraisal credits at closing, and refinance incentives. When they run, your clients get them &mdash; closing gifts your retail competitor simply can&rsquo;t hand out.</p></div>';
if (strpos($c, $old1) !== false) { $c = str_replace($old1, $new1, $c); echo "promo cards merged\n"; }
else echo "pattern not found\n";

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "done\n";
