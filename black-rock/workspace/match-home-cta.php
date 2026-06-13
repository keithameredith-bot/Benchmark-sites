<?php
// Make homepage final CTA buttons match the loan-program-page actions row (gold portal + outline Call Keith, side by side, 54px gap).
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
$orig = $c;

// 1. Replace the markup block (gold pill <p> + stacked call <div>) with a flex actions row.
$startMark = '<p class="brm-home-final-already">';
$s = strpos($c, $startMark);
if ($s === false) { echo "markup not found\n"; return; }
// end = closing </div> of brm-home-final-call
$callPos = strpos($c, 'brm-home-final-call', $s);
$end = strpos($c, '</div>', $callPos) + strlen('</div>');

$new = '<div class="brm-home-final-actions">' . "\n"
     . '        <a class="brm-home-final-portal" href="https://coast2coastmortgage.my1003app.com/303217/register">Apply Directly Through Our Secure Portal</a>' . "\n"
     . '        <a class="brm-home-final-callbtn" href="tel:3526194959">Call Keith: 352-619-4959</a>' . "\n"
     . '      </div>';
$c = substr($c, 0, $s) . $new . substr($c, $end);

// 2. Inject matching CSS (idempotent) right after the existing .brm-home-final-already rule block's closing — just append a style before </style> of homepage. Simplest: add a scoped <style> right before the actions markup is fine, but cleaner to append rules to first style block.
$cssRules = "\n.brm-home-final-actions{display:flex;flex-wrap:wrap;gap:14px;justify-content:center;align-items:center;margin:54px 0 0;}\n.brm-home-final-actions a{display:inline-flex;align-items:center;justify-content:center;font-family:\"Rubik\",sans-serif;font-weight:700;font-size:15px;letter-spacing:.01em;line-height:1.35;padding:15px 30px;border-radius:6px;text-decoration:none !important;transition:all 180ms ease;}\n.brm-home-final-portal{background:var(--gold) !important;color:#1a1a1a !important;border:2px solid var(--gold);}\n.brm-home-final-portal:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}\n.brm-home-final-callbtn{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,.55);}\n.brm-home-final-callbtn:hover{border-color:#fff;background:rgba(255,255,255,.08) !important;color:#fff !important;transform:translateY(-1px);}\n@media (max-width:720px){.brm-home-final-actions{flex-direction:column;margin-top:42px;}.brm-home-final-actions a{width:100%;max-width:360px;}}\n";
if (strpos($c, '.brm-home-final-actions{') === false) {
    // insert before the first </style> that appears after the .brm-home-final-already rule
    $anchor = strpos($c, '.brm-home-final-already');
    $styleClose = strpos($c, '</style>', $anchor);
    if ($styleClose !== false) {
        $c = substr($c, 0, $styleClose) . $cssRules . substr($c, $styleClose);
    }
}

if ($c === $orig) { echo "no change\n"; return; }
if (!get_post_meta(38, '_brm_home_cta_backup', true)) add_post_meta(38, '_brm_home_cta_backup', wp_slash($orig), true);
$wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => 38));
clean_post_cache(38);
echo "homepage final CTA -> side-by-side actions row (gold portal + outline Call Keith, 54px)\n";
