<?php
// Grants article: MCC section -> "what happened to the MCC" correction; fix Keith's take + FAQ.
global $wpdb;
$pid = 987515421;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

$old = '<h2>The Tax Credit Almost Nobody Uses: the MCC</h2>
<p>The <a href="/first-time-home-buyer-program-florida-mortgage-credit-certificate-program-mcc/">Mortgage Credit Certificate</a> turns part of your annual mortgage interest into a dollar-for-dollar federal tax credit &mdash; every year you live in the home. It\'s not cash at closing; it\'s money back each tax season, and it can even help you qualify by lowering your effective housing cost. It quietly outvalues a one-time grant for buyers who stay put.</p>';
$new = '<h2>Still Seeing the "MCC Tax Credit" Advertised? It\'s Gone.</h2>
<p>Plenty of mortgage sites still pitch Florida\'s <a href="/first-time-home-buyer-program-florida-mortgage-credit-certificate-program-mcc/">Mortgage Credit Certificate</a> &mdash; a recurring federal tax credit on your mortgage interest. Here\'s the truth they haven\'t updated: <strong>Florida discontinued the MCC program.</strong> If a lender dangles it, they\'re working from an old playbook. The help that exists today &mdash; Hometown Heroes, Florida Assist, HFA grants, and county SHIP funds &mdash; is what this guide covers, and frankly the upfront-money programs do more for most buyers anyway.</p>';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$old = 'Here\'s the stack I reach for most: an FHA first mortgage + Hometown Heroes covering the down payment and most closing costs + an MCC for the recurring tax credit. Done right, a qualified Florida buyer gets in for very little out of pocket and keeps a tax benefit for as long as they own. No single website shows you that combination &mdash; that\'s the actual reason to use a broker for your first purchase.';
$new = 'Here\'s the stack I reach for most: an FHA first mortgage + Hometown Heroes covering the down payment and most closing costs + seller concessions picking up the rest. Done right, a qualified Florida buyer gets in for very little out of pocket. No single website shows you that combination &mdash; that\'s the actual reason to use a broker for your first purchase.';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$old = 'Often, yes &mdash; and that\'s where the real savings are. A common stack is FHA + Hometown Heroes + an MCC. The rules on what combines change with funding cycles, so it\'s worth a quick call to confirm what\'s available for you right now.';
$new = 'Often, yes &mdash; and that\'s where the real savings are. A common stack is FHA + Hometown Heroes + seller-paid closing costs. The rules on what combines change with funding cycles, so it\'s worth a quick call to confirm what\'s available for you right now.';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "grants article MCC rewrite: $n/3\n";
// confirm no availability-claiming MCC mentions remain
$off=0; $left=0;
while (($i = stripos($c, 'MCC', $off)) !== false) { $left++; $off = $i+3; }
echo "MCC string occurrences remaining (incl. the correction section + URL): $left\n";
