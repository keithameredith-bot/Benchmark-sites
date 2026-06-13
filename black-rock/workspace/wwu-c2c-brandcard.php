<?php
// Branding section: add 4th option — operate under established Coast 2 Coast branding (with logo).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

// heading: three -> four
$old = '<h2>Three ways to build your brand here</h2>';
$new = '<h2>Four ways to build your brand here</h2>';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

// make the branding grid 2x2 on desktop (4 cards breathe better than a squeezed row)
$old = '<h2>Four ways to build your brand here</h2>
  <div class="wwu-cards">';
$new = '<h2>Four ways to build your brand here</h2>
  <style>.wwu-brand-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-top:24px;}@media(max-width:880px){.wwu-brand-grid{grid-template-columns:1fr;}}</style>
  <div class="wwu-cards wwu-brand-grid">';
if (strpos($c, 'wwu-brand-grid') === false && strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

// insert C2C card before the Join Black Rock card
$anchor = '<div class="wwu-card gold"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#F5A524" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg></div><h3>Join Black Rock</h3>';
$card = '<div class="wwu-card gold"><img src="/wp-content/uploads/wwu/logo-c2c-wide.webp" alt="Coast 2 Coast Mortgage Lending" style="height:42px !important;width:auto !important;max-width:88%;object-fit:contain;margin-bottom:12px;display:block;" loading="lazy"><h3>Operate as Coast 2 Coast</h3><p>Plenty of originators skip the branding decision entirely and build under the established Coast 2 Coast Mortgage name &mdash; voted Best of Florida 2025, recognized by agents and lenders statewide. Zero setup, full credibility from day one.</p></div>
    ' . $anchor;
if (strpos($c, 'Operate as Coast 2 Coast') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $card, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "branding section: $n changes\n";
