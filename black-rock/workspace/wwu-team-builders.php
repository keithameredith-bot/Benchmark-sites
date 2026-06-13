<?php
// WWU: branch-manager comp-plan section + recruiter override + honesty note upgrade + HELOC comp placeholder.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// 1. Team-builders section after the DBA wall (before MIDCTA2 / SUPPORT)
$anchor = '<!-- MIDCTA2 -->';
$sec = '<!-- TEAM BUILDERS -->
<div class="sec">
  <p class="kick">Grow Past Yourself</p>
  <h2>Built for empire-builders too</h2>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:1020px;margin:24px auto 0;" class="wwu-team-grid">
    <style>@media(max-width:880px){.wwu-team-grid{grid-template-columns:1fr !important;}}</style>
    <div class="wwu-card gold">
      <div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#F5A524" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <h3>Branch managers: design your own comp plan</h3>
      <p>Bring a team and the economics become <strong>yours to architect</strong>. Feeding your LOs leads or layering in processing support? Charge a higher per-file fee, set them on a 1.5% comp structure, or go 50/50 on the profit &mdash; your team, your model, your call. You build the machine; the platform stays out of your way.</p>
    </div>
    <div class="wwu-card gold">
      <div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#F5A524" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
      <h3>Originators: get paid to grow the family</h3>
      <p>Recruit for the Coast 2 Coast team and earn <strong>\$200 per file your recruits close &mdash; for as long as they&rsquo;re with the company</strong>. One great recruit closing four loans a month is \$800/month of passive pipeline, forever. Build a downline, not just a book.</p>
    </div>
  </div>
</div>

<!-- MIDCTA2 -->';
if (strpos($c, 'TEAM BUILDERS') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $sec, $c); $n++; }

// 2. honesty note upgrade (cost sheet closer, Keith's voice)
$old = '<p style="text-align:center;font-size:14px;color:#7b8f8b;margin-top:14px;">There are shops that are slightly cheaper. There are none that are cheaper <em>and</em> back you with this level of support.</p>';
$new = '<p style="text-align:center;font-size:15px;color:#465552;margin-top:14px;max-width:720px;margin-left:auto;margin-right:auto;line-height:1.6;"><strong>An honest note:</strong> there are a few shops out there cheaper than \$995. There are none with the level of support and dedication to your business that Coast 2 Coast provides. We&rsquo;ve been on both sides &mdash; <em>that&rsquo;s why we invested in our own company.</em></p>';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

// 3. HELOC comp placeholder row in cost sheet
$old = '<div class="row"><span class="k">Loan officer assistants</span>';
$new = '<div class="row"><span class="k">HELOC comp</span><span class="v">HELOCs run on their own comp schedule &mdash; we&rsquo;ll walk it in the conversation.</span></div>
    <div class="row"><span class="k">Loan officer assistants</span>';
if (strpos($c, 'HELOCs run on their own comp schedule') === false && strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "team builders + honesty note + HELOC row: $n changes\n";
