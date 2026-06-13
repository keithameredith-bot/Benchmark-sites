<?php
// Optimize FHA page (56) for the "fha loan requirements florida" cluster:
// 1. Insert a requirements-checklist section before the "FHA Credit Score Minimum" heading.
// 2. Update AIOSEO title/description to requirements intent.
// Idempotent: skips if checklist heading already present.
global $wpdb;
$pid = 56;
$c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));

if (strpos($c, 'Florida FHA Loan Requirements at a Glance') !== false) {
    echo "checklist already present, skipping insert\n";
} else {
    // find the kadence advancedheading block that contains "FHA Credit Score Minimum"
    $hpos = strpos($c, '>FHA Credit Score Minimum<');
    if ($hpos === false) { echo "ERROR: anchor heading not found\n"; exit; }
    $blockStart = strrpos(substr($c, 0, $hpos), '<!-- wp:kadence/advancedheading');
    if ($blockStart === false) { echo "ERROR: block opener not found\n"; exit; }

    $section = <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Florida FHA Loan Requirements at a Glance</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Here's the full checklist of FHA loan requirements for Florida buyers in 2026 — each one is covered in detail further down the page:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li><strong>Credit score:</strong> 580+ for the minimum 3.5% down payment; 500&ndash;579 possible with 10% down.</li><li><strong>Down payment:</strong> 3.5% &mdash; and it can be 100% gift funds from a family member.</li><li><strong>Debt-to-income ratio:</strong> typically up to ~50%, and higher with strong compensating factors and automated approval.</li><li><strong>Employment:</strong> two-year work history (job changes are fine; gaps can be explained).</li><li><strong>Property:</strong> must be your primary residence and meet FHA minimum property standards &mdash; single family, townhome, approved condo, or <a href="/florida-mobile-home-financing/">manufactured home</a>.</li><li><strong>Loan amount:</strong> within your county's FHA limit &mdash; see <a href="/loan-limits/">Florida FHA loan limits by county</a>.</li><li><strong>Mortgage insurance:</strong> upfront premium of 1.75% (financed into the loan) plus a monthly premium.</li><li><strong>Waiting periods:</strong> generally 2 years after Chapter 7 bankruptcy and 3 years after foreclosure &mdash; shorter with extenuating circumstances.</li></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Not sure you check every box? That's literally our job &mdash; <a href="/get-pre-approved/">get pre-approved</a> and we'll tell you exactly where you stand.</p>
<!-- /wp:paragraph -->


HTML;
    $c = substr($c, 0, $blockStart) . $section . substr($c, $blockStart);
    if (!get_post_meta($pid, '_brm_fha_backup_20260611', true)) {
        add_post_meta($pid, '_brm_fha_backup_20260611', wp_slash($wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid))), true);
    }
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $pid));
    clean_post_cache($pid);
    echo "checklist section inserted\n";
}

$pt = $wpdb->prefix . 'aioseo_posts';
$wpdb->update($pt, array(
    'title' => 'Florida FHA Loan Requirements (2026) — 3.5% Down, 580+ FICO',
    'description' => 'Every FHA loan requirement for Florida buyers in 2026: credit score, down payment, DTI, property rules, and county loan limits — explained by a Florida FHA broker.',
    'updated' => current_time('mysql', true),
), array('post_id' => $pid));
echo "AIOSEO title/description updated\n";
