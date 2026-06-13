<?php
// Detect all pages using the loan-program template (closing "Get a No[- ]Hassle ... Pre-Approval" heading
// and/or a #see-my-options hero button). Report form status.
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_type='page'");
foreach ($rows as $r) {
    $c = $r->post_content;
    $hasClosing = preg_match('/Get a No[ -]?Hassle[^<]{0,45}Pre-?Approval/i', $c, $m);
    $heroAnchor = (strpos($c, 'href="#see-my-options"') !== false);
    $hasForm = strpos($c, 'brm-prog-cta') !== false;
    $hasOldIframe = (strpos($c, 'brmPreapproval') !== false && !$hasForm);
    if (!$hasClosing && !$heroAnchor) continue;
    $flags = array();
    if ($hasForm) $flags[] = 'HAS-FORM';
    if ($hasOldIframe) $flags[] = 'OLD-IFRAME';
    if ($heroAnchor) $flags[] = 'hero#see-my-options';
    $closing = $hasClosing ? "closing='" . trim($m[0]) . "'" : "NO-CLOSING-HEADING";
    echo str_pad($r->post_name, 42) . str_pad('('.$r->ID.')', 8) . implode(',', $flags) . " | $closing\n";
}
