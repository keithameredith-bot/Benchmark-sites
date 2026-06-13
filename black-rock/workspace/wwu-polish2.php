<?php
// WWU round 2: FAQ glyph fix, onerror removal, SVG icons, stack rebuild, C2C prominence,
// weekly-pay band, new support cards, cost-sheet adds. All via $wpdb->update (no slash-stripping).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// ---- 1. FAQ glyph: restore stripped backslash on the minus sign
if (strpos($c, 'summary::after{content:"2212";}') !== false || preg_match('/details\[open\] summary::after\{content:"2212"/', $c)) {
    $c = str_replace('details[open] summary::after{content:"2212";}', 'details[open] summary::after{content:"\\2212";}', $c);
    $n++;
}
// generic repair for any other stripped 4-hex glyphs in this page's CSS
$c2 = preg_replace('/content:(\s*)"([0-9a-fA-F]{4})"/', 'content:$1"\\\\$2"', $c);
if ($c2 !== $c) { $c = $c2; $n++; }

// ---- 2. kill the broken onerror attribute on the BRM wall card
$c2 = preg_replace('/ onerror="[^"]*"/', '', $c);
if ($c2 !== $c) { $c = $c2; $n++; }

// ---- 3. SVG icons replace emoji on cards
$svg = array(
  // money: dollar circle
  '<div class="ic">&#128176;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg></div>',
  // win on price: price tag
  '<div class="ic">&#127981;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><circle cx="7" cy="7" r="1.5"/></svg></div>',
  // own your business: briefcase
  '<div class="ic">&#128188;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>',
  // UW experts: shield-check
  '<div class="ic">&#129520;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></div>',
  // tech support: zap (first occurrence card) — handled by branding zap too; do branding first
  // branding: own DBA crown
  '<div class="ic">&#128081;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#F5A524" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.735H5.81a1 1 0 0 1-.957-.735L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/></svg></div>',
  // join black rock: mountain
  '<div class="ic">&#9968;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#F5A524" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg></div>',
  // ownership phone
  '<div class="ic">&#128222;</div>' => '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>',
);
foreach ($svg as $from => $to) { if (strpos($c, $from) !== false) { $c = str_replace($from, $to, $c); $n++; } }
// zap icons (two occurrences: powered-by card + tech support card) — replace all
$zap = '<div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg></div>';
if (strpos($c, '<div class="ic">&#9889;</div>') !== false) { $c = str_replace('<div class="ic">&#9889;</div>', $zap, $c); $n++; }

// ---- 4. rebuild the platform strip (class-based, horizontal, expanded)
$stripStart = strpos($c, '<div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:34px;margin:30px auto 0;max-width:860px;padding:20px;background:#fff;border:1px solid #e3edea;border-radius:12px;">');
if ($stripStart !== false) {
    $stripEnd = strpos($c, '</div>', strpos($c, 'The platform stack behind you')) + 6;
    $newStrip = '<div class="wwu-stack" style="max-width:980px;margin:34px auto 0;">
    <p class="kick">The Stack Behind You</p>
    <style>.wwu-stack-row{display:flex !important;flex-flow:row wrap !important;align-items:center;justify-content:center;gap:18px 44px;background:#fff;border:1px solid #e3edea;border-radius:12px;padding:24px 28px;}.wwu-stack-row img{height:38px !important;width:auto !important;max-width:170px !important;object-fit:contain;display:inline-block !important;}</style>
    <div class="wwu-stack-row">
      <img src="/wp-content/uploads/wwu/logo-c2c.webp" alt="Coast 2 Coast Mortgage" loading="lazy">
      <img src="/wp-content/uploads/wwu/logo-arive.webp" alt="ARIVE LOS" loading="lazy">
      <img src="/wp-content/uploads/wwu/logo-leaf360.webp" alt="Leaf 360 mortgage CRM" loading="lazy">
      <img src="/wp-content/uploads/wwu/logo-osi.webp" alt="OSI Express flyers" loading="lazy">
      <img src="/wp-content/uploads/wwu/logo-morethanink.webp" alt="More Than Ink business cards" loading="lazy">
    </div>
    <p style="text-align:center;font-size:15px;color:#465552;max-width:760px;margin:14px auto 0;line-height:1.6;">Still suffering through Encompass or Calyx? <strong>ARIVE is a first-class, intuitive LOS</strong> &mdash; it feels like skipping a decade. <strong>Leaf 360</strong> runs your pipeline, <strong>OSI Express</strong> turns out your listing and open-house flyers, and <strong>More Than Ink</strong> handles your cards and print. The tools are picked; you just originate.</p>
  </div>';
    $c = substr($c, 0, $stripStart) . $newStrip . substr($c, $stripEnd);
    $n++;
}

// ---- 5. C2C prominence: name it in hero sub + platform band under hero
$old = 'on a platform closing over <strong style="color:#7be3c4;">$1 billion a year</strong> with 343 originators.';
$new = 'at <strong style="color:#7be3c4;">Coast 2 Coast Mortgage</strong> &mdash; closing over <strong style="color:#7be3c4;">$1 billion a year</strong> with 343 originators.';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }
if (strpos($c, 'wwu-c2c-band') === false) {
    $band = '<div class="wwu-c2c-band" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:16px 30px;background:#fff;border:1px solid #e3edea;border-radius:12px;max-width:1140px;margin:14px auto 0;padding:18px 28px;">
  <img src="/wp-content/uploads/wwu/logo-c2c-wide.webp" alt="Coast 2 Coast Mortgage Lending" style="height:52px !important;width:auto !important;object-fit:contain;" loading="lazy">
  <p style="margin:0;font-size:15px;color:#465552;line-height:1.55;font-family:Karla,sans-serif;max-width:620px;"><strong style="font-family:Rubik,sans-serif;color:#1c2b29;">You&rsquo;d be sponsored by Coast 2 Coast Mortgage Lending</strong> &mdash; NMLS #376205 &middot; 343 originators &middot; \$1B+ closed annually &middot; Voted Best of Florida 2025. Black Rock is one of its divisions; yours could be next.</p>
</div>';
    $anchor = '<!-- STATS -->';
    $c = str_replace($anchor, $band . "\n\n" . $anchor, $c);
    $n++;
}

// ---- 6. WEEKLY PAY standout band (after calculator, before cost sheet)
if (strpos($c, 'wwu-weekly') === false) {
    $weekly = '<!-- WEEKLY PAY -->
<div class="wwu-weekly" style="max-width:1140px;margin:30px auto;padding:0 20px;">
  <div style="background:linear-gradient(120deg,#F5A524,#ffb944);border-radius:16px;padding:44px 38px;color:#1a1a1a;">
    <p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;margin:0 0 10px;color:#5e3c00;">Cash Flow Is King</p>
    <p style="font-family:Rubik,sans-serif;font-weight:800;font-size:clamp(28px,4vw,44px);line-height:1.1;margin:0 0 14px;">You get paid <u>every week</u>.</p>
    <p style="font-size:17px;line-height:1.65;margin:0 0 18px;max-width:780px;">No waiting on month-end commission runs. Loans fund, you get paid &mdash; weekly payroll, every week. And on the W-2 track, <strong>business expenses are reimbursed pre-tax</strong>: client meals and drinks, out-of-pocket credit report costs, business travel, your cell phone bill. Money you&rsquo;re currently paying taxes on, back in your pocket.</p>
    <div style="display:flex;flex-wrap:wrap;gap:10px;">
      <span style="background:rgba(0,0,0,.12);border-radius:999px;padding:8px 16px;font-family:Rubik,sans-serif;font-weight:700;font-size:13.5px;">Weekly payroll</span>
      <span style="background:rgba(0,0,0,.12);border-radius:999px;padding:8px 16px;font-family:Rubik,sans-serif;font-weight:700;font-size:13.5px;">Pre-tax expense reimbursement (W-2)</span>
      <span style="background:rgba(0,0,0,.12);border-radius:999px;padding:8px 16px;font-family:Rubik,sans-serif;font-weight:700;font-size:13.5px;">Medical &middot; Dental &middot; Vision &middot; 401(k)</span>
    </div>
  </div>
</div>

<!-- HONEST COST SHEET -->';
    $c = str_replace('<!-- HONEST COST SHEET -->', $weekly, $c);
    $n++;
}

// ---- 7. support: 3 new cards (onboarding, lender database, LOAs)
$anchor = '</div>
  <div class="wwu-keith">';
if (strpos($c, 'first-class onboarding') === false && strpos($c, $anchor) !== false) {
    $cards = '<div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div><h3>First-class onboarding</h3><p>Switching shops is the #1 pain point in this industry &mdash; so we made it ours to solve. Our first-class onboarding has you up, licensed-linked, and running in no time, timed around your active pipeline.</p></div>
    <div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg></div><h3>Searchable lender database</h3><p>Every one of our 200+ lenders in one searchable database &mdash; AE contact info and loan product offerings included. Find the right home for any scenario in minutes, not phone tag.</p></div>
    <div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><h3>Loan officer assistants</h3><p>Need leverage? LOAs are available on a simple per-file fee &mdash; scale your support up and down with your pipeline instead of carrying salary.</p></div>
  </div>
  <div class="wwu-keith">';
    $c = str_replace($anchor, $cards, $c);
    $n++;
}

// ---- 8. cost sheet: LOA row + W-2 reimbursements
$old = '<div class="row"><span class="k">Your tech stack</span>';
$new = '<div class="row"><span class="k">Loan officer assistants</span><span class="v">Optional, <b>per-file fee</b> &mdash; scale support with your pipeline, no salary overhead.</span></div>
    <div class="row"><span class="k">Your tech stack</span>';
if (strpos($c, 'Loan officer assistants</span><span class="v">Optional') === false && strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }
$old = 'in exchange for <b>real benefits</b>: medical, MetLife dental &amp; vision, and a 401(k) with Roth option.';
$new = 'in exchange for <b>real benefits</b>: medical, MetLife dental &amp; vision, a 401(k) with Roth option, weekly payroll, and <b>pre-tax expense reimbursement</b> (meals, credit reports, travel, cell phone).';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "polish round 2: $n changes applied\n";
