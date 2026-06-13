<?php
// Remove the old CTA section (last heading + buttons block) sitting immediately before the custom form.
// Safety: only excises if the segment contains a wp:buttons block (i.e., it IS a CTA, not content).
global $wpdb;

function brm_strip_preform_cta($slug) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    if (!$row) { echo "MISS $slug\n"; return; }
    $c = $row->post_content; $pid = (int)$row->ID;
    $form = strpos($c, 'brm-prog-cta');
    if ($form === false) { echo "$slug: no form\n"; return; }
    $formBlock = strrpos(substr($c, 0, $form), '<!-- wp:html -->');
    // find last heading block opener before the form
    $h2 = strrpos(substr($c, 0, $formBlock), '<h2');
    if ($h2 === false) { echo "$slug: no h2 before form\n"; return; }
    $secStart = strrpos(substr($c, 0, $h2), '<!-- wp:');
    $segment = substr($c, $secStart, $formBlock - $secStart);
    if (strpos($segment, 'wp:buttons') === false) { echo "$slug: pre-form section has no buttons (heading: " . (preg_match('/<h2[^>]*>(.*?)<\/h2>/s',$segment,$m)?trim(strip_tags($m[1])):'?') . ") - SKIP\n"; return; }
    preg_match('/<h2[^>]*>(.*?)<\/h2>/s', $segment, $m);
    $title = trim(strip_tags($m[1] ?? '?'));
    if (!get_post_meta($pid, '_brm_preformcta_backup', true)) add_post_meta($pid, '_brm_preformcta_backup', wp_slash($c), true);
    $c = substr($c, 0, $secStart) . substr($c, $formBlock);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    echo "$slug: removed old CTA \"$title\" (" . ($formBlock-$secStart) . " bytes)\n";
}

brm_strip_preform_cta('usda-mortgage-for-manufactured-homes');
brm_strip_preform_cta('va-new-construction-loan');
// sweep the other recent embeds for the same leftover, just in case
foreach (array('singlewide-manufactured-home-financing','manufactured-homes-that-have-been-moved','refinance-manufactured-home','florida-construction-loan') as $s) brm_strip_preform_cta($s);
echo "done\n";
