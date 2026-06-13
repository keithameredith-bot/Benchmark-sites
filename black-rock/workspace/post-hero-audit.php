<?php
// Inspect what sits between the new hero and the first H2 on every brm-hero page.
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_type='page' AND post_content LIKE '%class=\"brm-hero\"%'");
foreach ($rows as $r) {
    $c = $r->post_content;
    $heroPos = strpos($c, 'class="brm-hero"');
    $heroEnd = strpos($c, '<!-- /wp:html -->', $heroPos) + strlen('<!-- /wp:html -->');
    $h2 = strpos($c, '<h2', $heroEnd);
    $between = $h2 !== false ? substr($c, $heroEnd, $h2 - $heroEnd) : '';
    $hasButtons = strpos($between, 'wp:buttons') !== false || strpos($between, 'kadence/advancedbtn') !== false;
    $hasCTAlink = preg_match('/get-pre-approved|tel:3526194959/', $between);
    if ($hasButtons || $hasCTAlink) {
        echo "[{$r->ID}] /{$r->post_name}/ — POST-HERO CTA (" . strlen($between) . " bytes between hero and first h2)\n";
        // show the block types in between
        preg_match_all('/<!-- wp:([a-z\/]+)/', $between, $m);
        echo "    blocks: " . implode(', ', $m[1]) . "\n";
    }
}
echo "scan done\n";
