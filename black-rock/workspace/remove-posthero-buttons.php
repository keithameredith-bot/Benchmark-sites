<?php
// Remove the redundant post-hero CTA button bar (hero already has identical buttons).
// Only removes a wp:buttons block between hero-end and first <h2> that contains
// get-pre-approved / tel: links. Intro paragraphs, spacers, stats rows untouched.
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_type='page' AND post_content LIKE '%class=\"brm-hero\"%'");
$fixed = 0;
foreach ($rows as $r) {
    $c = $r->post_content;
    $heroPos = strpos($c, 'class="brm-hero"');
    $heroEnd = strpos($c, '<!-- /wp:html -->', $heroPos) + strlen('<!-- /wp:html -->');
    $h2 = strpos($c, '<h2', $heroEnd);
    if ($h2 === false) continue;

    $btnStart = strpos($c, '<!-- wp:buttons', $heroEnd);
    if ($btnStart === false || $btnStart > $h2) continue;
    $btnEnd = strpos($c, '<!-- /wp:buttons -->', $btnStart);
    if ($btnEnd === false) continue;
    $btnEnd += strlen('<!-- /wp:buttons -->');

    $block = substr($c, $btnStart, $btnEnd - $btnStart);
    if (!preg_match('/get-pre-approved|tel:3526194959/', $block)) continue;

    if (!get_post_meta($r->ID, '_brm_postherocta_backup', true)) add_post_meta($r->ID, '_brm_postherocta_backup', wp_slash($c), true);
    $c = substr($c, 0, $btnStart) . substr($c, $btnEnd);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$r->ID));
    clean_post_cache($r->ID);
    $fixed++;
    echo "fixed /{$r->post_name}/\n";
}
wp_cache_flush();
echo "done — $fixed pages\n";
