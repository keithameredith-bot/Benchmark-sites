<?php
// Clean the mfg hub tail: remove old No-Hassle CTA; move Related Reading to just before the form.
// Final order: content -> Dunnellon -> Neighborhoods -> Engineer -> Related Reading -> Form CTA.
global $wpdb;
$pid = 607;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (!get_post_meta($pid, '_brm_tailclean_backup', true)) add_post_meta($pid, '_brm_tailclean_backup', wp_slash($c), true);

// 1. excise old CTA: from its advancedheading opener to the related-reading marker
$h = strpos($c, 'Get a No-Hassle Manufactured Home Pre-Approval');
if ($h === false) { echo "old CTA not found (already clean?)\n"; }
else {
    $start = strrpos(substr($c, 0, $h), '<!-- wp:kadence/advancedheading');
    $marker = '<!-- brm-related-florida-mobile-home-financing -->';
    $end = strpos($c, $marker);
    if ($start === false || $end === false || $end < $start) { echo "bounds error\n"; return; }
    echo "removing old CTA: " . ($end - $start) . " bytes\n";
    $c = substr($c, 0, $start) . substr($c, $end);
}

// 2. extract Related Reading block (marker .. end of its wp:list)
$marker = '<!-- brm-related-florida-mobile-home-financing -->';
$rs = strpos($c, $marker);
$re = strpos($c, '<!-- /wp:list -->', $rs) + strlen('<!-- /wp:list -->');
$related = substr($c, $rs, $re - $rs);
$c = substr($c, 0, $rs) . substr($c, $re);

// 3. reinsert just before the form block (wp:html opener preceding brm-prog-cta)
$fp = strpos($c, 'brm-prog-cta');
$fs = strrpos(substr($c, 0, $fp), '<!-- wp:html -->');
$c = substr($c, 0, $fs) . $related . "\n\n" . substr($c, $fs);

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
echo "mfg tail cleaned (len " . strlen($c) . ")\n";
