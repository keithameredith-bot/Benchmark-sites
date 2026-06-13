<?php
// Tone down the weekly-pay band: full gold slab -> refined cream card w/ gold accent.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");

$s = strpos($c, '<div class="wwu-weekly"');
if ($s === false) { echo "band not found\n"; return; }
$e = strpos($c, '<!-- HONEST COST SHEET -->', $s);

$new = '<div class="wwu-weekly" style="max-width:1140px;margin:30px auto;padding:0 20px;">
  <div style="background:#fff8ec;border:1px solid #f6e2bd;border-left:5px solid #F5A524;border-radius:14px;padding:32px 34px;color:#353535;">
    <p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:11.5px;margin:0 0 8px;color:#b9791a;">Cash Flow Is King</p>
    <p style="font-family:Rubik,sans-serif;font-weight:800;font-size:clamp(22px,2.8vw,30px);line-height:1.15;margin:0 0 12px;color:#1c2b29;">You get paid every week.</p>
    <p style="font-size:16px;line-height:1.65;margin:0 0 16px;max-width:780px;">No waiting on month-end commission runs &mdash; loans fund, you get paid, weekly. And on the W-2 track, <strong>business expenses are reimbursed pre-tax</strong>: client meals, out-of-pocket credit report costs, business travel, your cell phone bill. Money you&rsquo;re currently paying taxes on, back in your pocket.</p>
    <div style="display:flex;flex-wrap:wrap;gap:8px;">
      <span style="background:#fdeed0;color:#7a5410;border-radius:999px;padding:7px 14px;font-family:Rubik,sans-serif;font-weight:700;font-size:12.5px;">Weekly payroll</span>
      <span style="background:#fdeed0;color:#7a5410;border-radius:999px;padding:7px 14px;font-family:Rubik,sans-serif;font-weight:700;font-size:12.5px;">Pre-tax expense reimbursement (W-2)</span>
      <span style="background:#fdeed0;color:#7a5410;border-radius:999px;padding:7px 14px;font-family:Rubik,sans-serif;font-weight:700;font-size:12.5px;">Medical &middot; Dental &middot; Vision &middot; 401(k)</span>
    </div>
  </div>
</div>

';
$c = substr($c, 0, $s) . $new . substr($c, $e);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "weekly band toned down\n";
