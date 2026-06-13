<?php
// Audit loan program pages: which have the brm-prog-cta form, which have an old #see-my-options CTA.
global $wpdb;

// authoritative-ish candidate list of loan PROGRAM pages (purchase + refi)
$slugs = array(
    'fha-home-mortgage-loan', 'va-home-mortgage', 'florida-usda-mortgage',
    'florida-dscr-loan', 'reverse-mortgages', 'self-employed-mortgage',
    'conventional-mortgage-in-florida', 'florida-jumbo-loan', 'florida-non-qm-loans',
    'florida-cash-out-refinance', 'refinance-mortgage', 'home-equity-line-of-credit-in-florida',
    // excluded (manufactured + new construction) — listed to confirm status, NOT to edit:
    'florida-mobile-home-financing', 'florida-construction-loan',
);
foreach ($slugs as $slug) {
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    if (!$row) { echo str_pad($slug, 40) . " MISSING\n"; continue; }
    $c = $row->post_content;
    $hasForm = strpos($c, 'brm-prog-cta') !== false ? 'FORM' : '----';
    $hasIframe = strpos($c, 'brmPreapproval') !== false ? 'iframe' : '------';
    $hasAnchor = strpos($c, 'id="see-my-options"') !== false ? 'anchor' : '------';
    // detect old CTA heading "Get a No-Hassle ... Pre-Approval"
    $oldCta = preg_match('/Get a No-Hassle[^<]*Pre-Approval/i', $c, $m) ? "OLD-CTA('" . substr($m[0],0,40) . "')" : 'no-old-cta';
    echo str_pad($slug, 40) . " [$hasForm|$hasIframe|$hasAnchor] $oldCta\n";
}
