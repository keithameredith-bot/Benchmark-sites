<?php
// Add the "deals you didn't know had a lender" chip band after the program menu groups,
// + sharpen a few group lines with master-list ammo. Keep the 7 groups tight (no overload).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// 1. sharpen lines inside existing groups
$swaps = array(
  '<li>DSCR &mdash; incl. short-term rental</li>' => '<li>DSCR &mdash; incl. Airbnb income, no-ratio, even negative cash flow</li>',
  '<li>Fix-and-flip &amp; bridge</li>' => '<li>Fix-and-flip &mdash; up to 100% of purchase + rehab</li>',
  '<li>Manufactured homes &mdash; incl. singlewides</li>' => '<li>Manufactured homes &mdash; incl. singlewides &amp; chattel (home-only on leased land)</li>',
  '<li>Bank statement loans (12 &amp; 24 mo)</li>' => '<li>Bank statement loans &mdash; down to 1-month statements</li>',
  '<li>Recent credit event programs</li>' => '<li>Recent credit event &mdash; as soon as 1 day out of BK or foreclosure</li>',
);
foreach ($swaps as $o => $nn) { if (strpos($c, $o) !== false) { $c = str_replace($o, $nn, $c); $n++; } }

// 2. chip band after the menu's closing line
$anchor = '<p style="text-align:center;font-size:15px;color:#465552;margin-top:8px;">Stop referring deals out. Stop saying no. <strong>Every &ldquo;no&rdquo; your bank made you give is a commission you didn&rsquo;t earn.</strong></p>';
$band = $anchor . '
  <div style="max-width:1080px;margin:30px auto 0;background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.14),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);border-radius:16px;padding:34px 32px;">
    <p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;text-align:center;margin:0 0 8px;">And Then There&rsquo;s The Wild Stuff</p>
    <p style="font-family:Rubik,sans-serif;font-weight:800;font-size:clamp(20px,2.8vw,28px);color:#fff;text-align:center;margin:0 0 8px;">Deals you didn&rsquo;t know had a lender</p>
    <p style="font-size:15px;color:#cfe0de;text-align:center;max-width:680px;margin:0 auto 20px;line-height:1.6;">Real programs, real lenders, on our list right now:</p>
    <div style="display:flex;flex-wrap:wrap;gap:9px;justify-content:center;">
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Hobby &amp; horse farm loans &#127906;</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Church loans to \$35M &mdash; no personal guarantee</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Owner-occupied with NO income or employment docs (CDFI)</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Cannabis-income qualification</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Crypto-backed loans (BTC/ETH)</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">\$30M super jumbo w/ pledged stock portfolios</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Mortgage-as-checking-account sweep loans</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Container &amp; tiny homes</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Rent-to-own conversion &mdash; no FICO, no SSN</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Daycares, funeral homes &amp; motels (small-balance commercial)</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Foreclosure bailout &amp; in-bankruptcy (DIP) lending</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Faith-based (Sharia-compliant &amp; Heter Iska) financing</span>
      <span style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);color:#e8f5f1;border-radius:999px;padding:8px 16px;font-size:13.5px;font-family:Karla,sans-serif;">Puerto Rico lending</span>
    </div>
    <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:16px;color:#F5A524;text-align:center;margin:22px 0 0;">Our lender list runs 200+ deep. If it can be financed in America, somebody on it does it &mdash; and you can originate it.</p>
  </div>';
if (strpos($c, 'Deals you didn&rsquo;t know had a lender') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $band, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "wild-stuff band + line sharpening: $n changes\n";
