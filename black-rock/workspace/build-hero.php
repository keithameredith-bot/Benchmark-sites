<?php
// Reusable hero builder: replaces a page's first Kadence rowlayout hero with a clean teal rounded brm-hero.
// Optionally folds in the Author Byline (loan-program pages). Backs up original. Idempotent (skips if brm-hero present).
// Config-driven: edit $HEROES then run. H1 is auto-extracted from the existing hero unless overridden.
global $wpdb;

function brm_hero_html($eyebrow, $h1, $sub, $ctaLabel, $ctaHref, $withByline) {
    $byline_css = <<<'CSS'
.brm-hero .brm-byline{display:inline-block;font-family:"Karla",-apple-system,sans-serif;font-size:14px;line-height:1.5;color:#fff;margin:6px 0 0;padding:9px 16px 10px;background:rgba(0,0,0,0.34);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);border-radius:6px;box-sizing:border-box;border-bottom:1px solid rgba(255,255,255,0.28);}
.brm-hero .brm-byline a{color:#ffd97d;text-decoration:none;font-weight:600;}
.brm-hero .brm-byline a:hover{text-decoration:underline;color:#ffe9a8;}
.brm-hero .brm-byline-sep{color:rgba(255,255,255,0.6);margin:0 6px;display:inline-block;}
.brm-hero .brm-byline-credential{color:#fff;font-weight:700;}
CSS;
    $byline = $withByline ? '
  <div class="brm-byline">Written by <a href="/keith-meredith/">Keith Meredith</a><span class="brm-byline-sep">&middot;</span><span class="brm-byline-credential">NMLS 303217</span><span class="brm-byline-sep">&middot;</span>Division President, Black Rock Mortgage</div>' : '';

    return '<!-- wp:html -->
<style>
.brm-hero{position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);color:#fff;border-radius:16px;padding:54px 40px;margin:0 0 4px;font-family:"Karla",-apple-system,sans-serif;box-sizing:border-box;}
.brm-hero *{box-sizing:border-box;}
.brm-hero .eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;margin:0 0 12px;}
.brm-hero h1{font-family:"Rubik",sans-serif;font-weight:800;color:#fff !important;font-size:clamp(30px,4.4vw,46px);line-height:1.12;letter-spacing:-.01em;margin:0 0 14px;}
.brm-hero .sub{color:#cfe0de !important;font-size:18.5px;line-height:1.55;max-width:700px;margin:0 0 26px;}
.brm-hero .btns{display:flex;gap:13px;flex-wrap:wrap;align-items:center;}
.brm-hero a.go,.brm-hero a.call{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;letter-spacing:.02em;padding:14px 28px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.brm-hero a.go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.brm-hero a.go:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}
.brm-hero a.call{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,.55);}
.brm-hero a.call:hover{border-color:#fff;background:rgba(255,255,255,.08) !important;color:#fff !important;}
' . $byline_css . '
@media(max-width:720px){.brm-hero{padding:40px 22px;border-radius:12px;}.brm-hero .btns{flex-direction:column;align-items:stretch;}.brm-hero a.go,.brm-hero a.call{width:100%;}}
</style>
<div class="brm-hero">
  <p class="eyebrow">' . $eyebrow . '</p>
  <h1>' . $h1 . '</h1>
  <p class="sub">' . $sub . '</p>
  <div class="btns"><a class="go" href="' . $ctaHref . '">' . $ctaLabel . '</a><a class="call" href="tel:3526194959">Call Keith: 352-619-4959</a></div>' . $byline . '
</div>
<!-- /wp:html -->';
}

function brm_replace_hero($pid, $eyebrow, $sub, $ctaLabel, $ctaHref, $withByline, $h1override = null) {
    global $wpdb;
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    if ($c === null) { echo "  [$pid] not found\n"; return; }
    if (strpos($c, 'class="brm-hero"') !== false) { echo "  [$pid] already has brm-hero\n"; return; }
    $open = '<!-- wp:kadence/rowlayout'; $close = '<!-- /wp:kadence/rowlayout -->';
    $start = strpos($c, $open);
    if ($start === false) { echo "  [$pid] no rowlayout hero found\n"; return; }
    // balance scan
    $i = $start; $depth = 0; $end = null;
    while ($i < strlen($c)) {
        $no = strpos($c, $open, $i); $nc = strpos($c, $close, $i);
        if ($nc === false) break;
        if ($no !== false && $no < $nc) { $depth++; $i = $no + strlen($open); }
        else { $depth--; $i = $nc + strlen($close); if ($depth === 0) { $end = $i; break; } }
    }
    if ($end === null) { echo "  [$pid] could not balance hero\n"; return; }
    $hero = substr($c, $start, $end - $start);
    $h1 = $h1override;
    if (!$h1) { if (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $hero, $m)) $h1 = trim($m[1]); else $h1 = 'Black Rock Mortgage'; }
    $new = brm_hero_html($eyebrow, $h1, $sub, $ctaLabel, $ctaHref, $withByline);
    if (!get_post_meta($pid, '_brm_hero_backup', true)) add_post_meta($pid, '_brm_hero_backup', wp_slash($c), true);
    $out = substr($c, 0, $start) . $new . substr($c, $end);
    $wpdb->update($wpdb->posts, array('post_content' => $out), array('ID' => $pid));
    clean_post_cache($pid);
    echo "  [$pid] hero replaced (H1: \"$h1\", byline: " . ($withByline?'yes':'no') . ")\n";
}

// === VA proof ===
brm_replace_hero(88,
  'Veterans &amp; Active Military &bull; NMLS #303217',
  '$0 down with your VA entitlement, no monthly mortgage insurance, credit scores down to 500, and no county loan limit on full entitlement &mdash; the strongest financing in Florida for the people who earned it.',
  'See My Options', '#see-my-options', true);
echo "done\n";
