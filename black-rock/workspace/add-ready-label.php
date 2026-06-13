<?php
// Add a "Ready for a Full Application?" label above the gold portal button on every form CTA + homepage.
// Idempotent. Adjusts spacing so the label carries the top gap.
global $wpdb;

// --- program/form pages (brm-prog-cta) ---
$pages = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%brm-prog-cta-actions%'");
foreach ($pages as $p) {
    $c = $p->post_content;
    if (strpos($c, 'brm-prog-cta-readylabel') !== false) { echo str_pad($p->post_name,38)." already has label\n"; continue; }
    // CSS: add readylabel rule + retune actions margin (54 -> label carries gap, actions 16)
    $css = ".brm-prog-cta-readylabel{font-family:\"Rubik\",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:52px 0 0;}\n.brm-prog-cta-actions{margin:16px 0 0 !important;}\n";
    $c = str_replace('.brm-prog-cta-actions { display: flex;', $css . '.brm-prog-cta-actions { display: flex;', $c);
    // markup: label before actions div
    $c = str_replace('<div class="brm-prog-cta-actions">', '<p class="brm-prog-cta-readylabel">Ready for a Full Application?</p>' . "\n      " . '<div class="brm-prog-cta-actions">', $c);
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $p->ID));
    clean_post_cache($p->ID);
    echo str_pad($p->post_name,38)." label added\n";
}

// --- homepage (brm-home-final-actions) ---
$h = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
if (strpos($h, 'brm-home-final-readylabel') === false) {
    $css = ".brm-home-final-readylabel{font-family:\"Rubik\",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:var(--accent);text-align:center;margin:52px 0 0;}\n.brm-home-final-actions{margin:16px 0 0 !important;}\n";
    $h = str_replace('.brm-home-final-actions{display:flex;', $css . '.brm-home-final-actions{display:flex;', $h);
    $h = str_replace('<div class="brm-home-final-actions">', '<p class="brm-home-final-readylabel">Ready for a Full Application?</p>' . "\n        " . '<div class="brm-home-final-actions">', $h);
    $wpdb->update($wpdb->posts, array('post_content' => $h), array('ID' => 38));
    clean_post_cache(38);
    echo "homepage label added\n";
} else { echo "homepage already has label\n"; }
