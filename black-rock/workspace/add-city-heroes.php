<?php
// Add a proper hero (eyebrow + H1 + subhead + CTA) to the top of each city page.
// Fixes the missing-H1 problem and the abrupt menu->text jump. Idempotent.
global $wpdb;

$HERO_CSS = <<<'CSS'
<style>
.brm-hero{position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);color:#fff;border-radius:16px;padding:54px 38px;margin:0 0 10px;font-family:"Karla",-apple-system,sans-serif;box-sizing:border-box;}
.brm-hero *{box-sizing:border-box;}
.brm-hero .eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;margin:0 0 12px;}
.brm-hero h1{font-family:"Rubik",sans-serif;font-weight:800;color:#fff !important;font-size:clamp(30px,4.4vw,46px);line-height:1.12;letter-spacing:-.01em;margin:0 0 14px;}
.brm-hero .sub{color:#cfe0de !important;font-size:18.5px;line-height:1.55;max-width:680px;margin:0 0 26px;}
.brm-hero .btns{display:flex;gap:13px;flex-wrap:wrap;}
.brm-hero a{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;letter-spacing:.02em;padding:14px 28px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.brm-hero .go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.brm-hero .go:hover{background:#ffb944 !important;border-color:#ffb944;color:#1a1a1a !important;transform:translateY(-1px);}
.brm-hero .call{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,.55);}
.brm-hero .call:hover{border-color:#fff;background:rgba(255,255,255,.08) !important;color:#fff !important;}
@media(max-width:720px){.brm-hero{padding:40px 22px;border-radius:12px;}.brm-hero .btns{flex-direction:column}.brm-hero a{width:100%;max-width:340px}}
</style>
CSS;

$heroes = array(
    'the-villages-mortgage-broker' => array(
        'The Villages &bull; Sumter, Lake &amp; Marion Counties &bull; NMLS #303217',
        'The Villages Mortgage Broker',
        "VA loans, reverse-for-purchase, and retirement-smart lending &mdash; from a broker who actually understands bond assessments, fixed-income qualifying, and how The Villages really works.",
    ),
    'gainesville-mortgage-broker' => array(
        'Gainesville &bull; Alachua County &bull; NMLS #303217',
        'Gainesville Mortgage Broker',
        "First-time buyer programs for UF and UF Health families, \$0-down options just outside town, and investor loans built for Gator-country rentals.",
    ),
    'belleview-mortgage-broker' => array(
        'Belleview &bull; South Marion County &bull; NMLS #303217',
        'Belleview Mortgage Broker',
        "\$0-down USDA, manufactured homes on land, and real first-time buyer help &mdash; from a broker who lives and lends right here in south Marion County.",
    ),
);

foreach ($heroes as $slug => $h) {
    $pid = (int) $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_type='page'", $slug));
    if (!$pid) { echo "MISS $slug\n"; continue; }
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    if (strpos($c, 'brm-hero') !== false) { echo "$slug already has hero\n"; continue; }

    $hero = "<!-- wp:html -->\n" . $HERO_CSS . "\n<div class=\"brm-hero\">\n"
          . "  <p class=\"eyebrow\">{$h[0]}</p>\n"
          . "  <h1>{$h[1]}</h1>\n"
          . "  <p class=\"sub\">{$h[2]}</p>\n"
          . "  <div class=\"btns\"><a class=\"go\" href=\"/get-pre-approved/\">Get Pre-Approved</a><a class=\"call\" href=\"tel:3526194959\">Call Keith: 352-619-4959</a></div>\n"
          . "</div>\n<!-- /wp:html -->\n\n";

    // insert right after the opening <div class="brm-article">
    $anchor = '<div class="brm-article">';
    $pos = strpos($c, $anchor);
    if ($pos === false) { echo "$slug: no brm-article wrapper\n"; continue; }
    $insertAt = $pos + strlen($anchor);
    $new = substr($c, 0, $insertAt) . "\n" . $hero . substr($c, $insertAt);
    $wpdb->update($wpdb->posts, array('post_content' => $new), array('ID' => $pid));
    clean_post_cache($pid);
    echo "$slug: hero + H1 added\n";
}
