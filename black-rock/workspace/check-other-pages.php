<?php
// For program pages NOT matching the template, report hero anchor + their actual closing CTA.
global $wpdb;
$slugs = array('florida-dscr-loan','reverse-mortgages','conventional-mortgage-in-florida','self-employed-mortgage','florida-non-qm-loans','florida-cash-out-refinance','refinance-mortgage','home-equity-line-of-credit-in-florida');
foreach ($slugs as $slug) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$c) { echo "$slug MISSING\n"; continue; }
    $hero = strpos($c, 'href="#see-my-options"') !== false ? 'HERO#see-my-options' : 'no-hero-anchor';
    $form = strpos($c, 'brm-prog-cta') !== false ? 'HAS-FORM' : 'no-form';
    $iframe = strpos($c, 'brmPreapproval') !== false ? 'has-iframe' : '';
    // last heading text
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $c, $m);
    $lastH2 = !empty($m[1]) ? trim(strip_tags(end($m[1]))) : '(no h2)';
    echo str_pad($slug, 38) . " [$hero | $form $iframe] lastH2='" . substr($lastH2,0,45) . "'\n";
}
