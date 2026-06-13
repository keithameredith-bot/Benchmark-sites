<?php
global $wpdb;
function rrepl($slug, $pattern, $replacement, $label) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    $c = preg_replace($pattern, $replacement, $row->post_content, 1, $n);
    if ($n) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$row->ID)); clean_post_cache($row->ID); }
    echo "$label: " . ($n ? "OK" : "NO MATCH") . "\n";
}

rrepl('the-villages-mortgage-broker',
  '/(The bond question, answered<\/span><p>).*?(<\/p>)/s',
  '$1Should you pay off the bond at closing or carry it? It depends on the balance, its rate, and how long you plan to stay &mdash; a question worth taking to your financial planner. What I make sure of on the mortgage side: the bond and assessments are entered correctly in qualifying, whichever way you go. Estimate your full payment, bond and assessments included, with our <a href="/mortgage-tools/mortgage-calculator/">Florida mortgage calculator</a>.$2',
  'villages-callout');

rrepl('the-villages-mortgage-broker',
  '/<p>Sometimes yes, sometimes no.*?<\/p>/s',
  '<p>It depends on the balance, its rate, and how long you&rsquo;ll own the home &mdash; a question worth discussing with your financial planner. On the mortgage side, what matters is that the bond payment is counted correctly in your qualifying numbers, and we make sure it is.</p>',
  'villages-faq');

rrepl('requirements-to-buy-a-house-in-florida',
  '/<p>Minimums by loan type.*?<\/p>/s',
  '<p>Minimums by loan type. One big 2026 change: for years, mortgages ran only on old FICO models &mdash; never the score your banking app shows. As of April 2026, <strong>VantageScore 4.0 is accepted</strong> on conventional loans (we run it on VA too), which often scores higher for thin-credit files (<a href="/do-mortgage-lenders-use-fico-or-vantagescore/">full breakdown here</a>):</p>',
  'requirements-credit-intro');

rrepl('rent-to-own-homes-in-florida',
  '/<p>Maybe\. But don.*?<\/p>/s',
  '<p>Maybe. But don&rsquo;t guess &mdash; and here&rsquo;s good news: as of April 2026, <a href="/do-mortgage-lenders-use-fico-or-vantagescore/">VantageScore 4.0 is accepted on conventional loans</a>, so the score your app shows is closer to mortgage reality than it&rsquo;s ever been. Plenty of renters are closer to qualifying than they think. And if you genuinely aren&rsquo;t ready, a 15-minute call gets you a concrete plan &mdash; what to pay down, what to dispute, how long it&rsquo;ll take &mdash; which beats paying an option fee to wait.</p>',
  'rent-to-own-credit');
echo "done\n";
