<?php
// P1: keyword-rich anchors + headings on homepage loan program cards (post 38).
// Idempotent: each replacement only fires if the old string is still present.
global $wpdb;
$pid = 38;
$c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
$orig = $c;

$swaps = array(
    '<h3>FHA</h3>' => '<h3>FHA Loans</h3>',
    '<h3>VA</h3>' => '<h3>VA Loans</h3>',
    '<h3>USDA</h3>' => '<h3>USDA Loans</h3>',
    '<h3>Manufactured</h3>' => '<h3>Manufactured Home Loans</h3>',
    '<a href="/fha-home-mortgage-loan/" class="brm-home-pcard-link">Details</a>'
        => '<a href="/fha-home-mortgage-loan/" class="brm-home-pcard-link">Florida FHA loan details</a>',
    '<a href="/va-home-mortgage/" class="brm-home-pcard-link">Details</a>'
        => '<a href="/va-home-mortgage/" class="brm-home-pcard-link">Florida VA loan details</a>',
    '<a href="/florida-usda-mortgage/" class="brm-home-pcard-link">Details</a>'
        => '<a href="/florida-usda-mortgage/" class="brm-home-pcard-link">Florida USDA loan details</a>',
    '<a href="/florida-mobile-home-financing/" class="brm-home-pcard-link">Details</a>'
        => '<a href="/florida-mobile-home-financing/" class="brm-home-pcard-link">Manufactured home financing details</a>',
);
$applied = 0;
foreach ($swaps as $old => $new) {
    if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $applied++; }
    elseif (strpos($c, $new) === false) { echo "WARN not found: " . substr($old, 0, 60) . "\n"; }
}
if ($c !== $orig) {
    if (!get_post_meta($pid, '_brm_home_backup_20260610', true)) {
        add_post_meta($pid, '_brm_home_backup_20260610', wp_slash($orig), true);
    }
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $pid));
    clean_post_cache($pid);
}
echo "homepage: $applied swaps applied\n";
