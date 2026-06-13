<?php
// Footer round 2: fix 5 broken links, round green CTA, EHL badge spacing, map hover + legend.
global $wpdb;

// ---- 1. footer widget links + green button ----
$blocks = get_option('widget_block');
$linkFixes = array(
    'href="/licensing/"' => 'href="/states-we-are-licensed/"',
    'href="/refinance/"' => 'href="/refinance-mortgage/"',
    'href="/mortgage-glossary/"' => 'href="/mortgage-tools/mortgage-glossary/"',
    'href="/documents-needed/"' => 'href="/documents-needed-for-a-mortgage/"',
    'href="/florida-home-buyers-survival-guide/"' => 'href="/home-buyers-survival-guide/"',
);
$changed = false;
foreach ($blocks as $k => $b) {
    if (!is_array($b) || empty($b['content'])) continue;
    $c = $b['content']; $orig = $c;
    foreach ($linkFixes as $f => $t) $c = str_replace($f, $t, $c);
    if ($c !== $orig) { $blocks[$k]['content'] = $c; $changed = true; echo "widget_block[$k]: links fixed\n"; }
}
if ($changed) update_option('widget_block', $blocks);

// ---- 2. round the green Get Pre-Approved button (find its CSS in block 14) ----
$b14 = $blocks[14]['content'] ?? '';
if ($b14 && preg_match('/\.brm-foot-(cta|btn|getpre)[^{]*\{[^}]*\}/', $b14)) { /* will handle via customizer fallback below anyway */ }
// robust: add a customizer rule that rounds any footer anchor-button in the brand col
$css = wp_get_custom_css();
if (strpos($css, '/* BRM footer round2 */') === false) {
    $add = '

/* BRM footer round2 */
/* round the brand-column Get Pre-Approved button + any footer anchor styled as a button */
#colophon a[class*="btn"], #colophon a[class*="cta"], #colophon .brm-foot-brand a[href*="get-pre-approved"]:not([class*="mcta"]) { border-radius: 6px !important; }
';
    wp_update_custom_css_post($css . $add);
    echo "customizer: footer button rounding appended\n";
} else echo "customizer round2: already\n";

// ---- 3. EHL badge breathing room ----
$mods = get_option('theme_mods_kadence');
$f = $mods['footer_html_content'] ?? '';
$from = 'border: 1px solid rgba(245,165,36,0.45);padding: 7px 14px;border-radius: 8px;color: #fff;background: rgba(245,165,36,0.08)';
$to   = 'display: inline-block;margin: 14px 0 10px;border: 1px solid rgba(245,165,36,0.45);padding: 9px 18px;border-radius: 8px;color: #fff;background: rgba(245,165,36,0.08);line-height: 1.4';
if (strpos($f, $from) !== false) {
    $mods['footer_html_content'] = str_replace($from, $to, $f);
    update_option('theme_mods_kadence', $mods);
    echo "EHL badge: spacing added\n";
} elseif (strpos($f, $to) !== false) echo "EHL badge: already spaced\n";
else echo "EHL badge: pattern not found\n";

// ---- 4. map hover punch + bigger legend ----
$pid = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='states-we-are-licensed' AND post_type='page'");
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$o = $c;
$c = str_replace('.brm-usmap-svg path:hover{opacity:.78;}',
  '.brm-usmap-svg path:hover{filter:brightness(1.25) saturate(1.15);stroke:#0f2e2d;stroke-width:1.8;}', $c);
$c = str_replace('.brm-usmap-note{font-size:13px;color:#5b6b6b;text-align:center;margin:10px 0 0;}',
  '.brm-usmap-note{font-size:16px;font-weight:600;color:#1c2b29;text-align:center;margin:16px 0 0;display:flex;gap:18px;justify-content:center;flex-wrap:wrap;align-items:center;font-family:"Rubik",sans-serif;}
.brm-usmap-note .k{display:inline-flex;align-items:center;gap:8px;}
.brm-usmap-note .sw{width:18px;height:18px;border-radius:5px;display:inline-block;}', $c);
$c = str_replace('<p class="brm-usmap-note">Hover any state &middot; Teal = we close your loan in-house &middot; Gold = we broker your loan &middot; Gray = not currently licensed. Also licensed in the U.S. Virgin Islands.</p>',
  '<p class="brm-usmap-note"><span class="k"><span class="sw" style="background:#049F82"></span>We close your loan</span><span class="k"><span class="sw" style="background:#F5A524"></span>We broker your loan</span><span class="k"><span class="sw" style="background:#dfe8e5"></span>Not licensed</span><span class="k" style="color:#5b6b6b;font-weight:400;">+ U.S. Virgin Islands &middot; hover any state</span></p>', $c);
if ($c !== $o) { $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid)); clean_post_cache($pid); echo "map: hover punch + legend upgraded\n"; }
else echo "map: patterns not found\n";
wp_cache_flush();
echo "done\n";
