<?php
// Wild-stuff chips: real horse + every chip gets a leading emoji (all-or-none, Keith picked all).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;
$swaps = array(
  '>Hobby &amp; horse farm loans &#127906;<' => '>&#128014; Hobby &amp; horse farm loans<',
  '>Church loans to \$35M &mdash; no personal guarantee<' => '>&#9962; Church loans to \$35M &mdash; no personal guarantee<',
  '>Owner-occupied with NO income or employment docs (CDFI)<' => '>&#129323; Owner-occupied with NO income or employment docs (CDFI)<',
  '>Cannabis-income qualification<' => '>&#127807; Cannabis-income qualification<',
  '>Crypto-backed loans (BTC/ETH)<' => '>&#129689; Crypto-backed loans (BTC/ETH)<',
  '>\$30M super jumbo w/ pledged stock portfolios<' => '>&#128142; \$30M super jumbo w/ pledged stock portfolios<',
  '>Mortgage-as-checking-account sweep loans<' => '>&#128260; Mortgage-as-checking-account sweep loans<',
  '>Container &amp; tiny homes<' => '>&#128230; Container &amp; tiny homes<',
  '>Rent-to-own conversion &mdash; no FICO, no SSN<' => '>&#128273; Rent-to-own conversion &mdash; no FICO, no SSN<',
  '>Daycares, funeral homes &amp; motels (small-balance commercial)<' => '>&#127980; Daycares, funeral homes &amp; motels (small-balance commercial)<',
  '>Foreclosure bailout &amp; in-bankruptcy (DIP) lending<' => '>&#129695; Foreclosure bailout &amp; in-bankruptcy (DIP) lending<',
  '>Faith-based (Sharia-compliant &amp; Heter Iska) financing<' => '>&#128330; Faith-based (Sharia-compliant &amp; Heter Iska) financing<',
  '>Puerto Rico lending<' => '>&#127477;&#127479; Puerto Rico lending<',
);
foreach ($swaps as $o => $nn) { if (strpos($c, $o) !== false) { $c = str_replace($o, $nn, $c); $n++; } }
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "chip emojis: $n/13\n";
