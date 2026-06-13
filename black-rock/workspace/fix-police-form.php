<?php
// home-loans-for-police-officers (15780) is classic HTML (Divi-converted) — insert form before last <h2>.
global $wpdb;
$pid = 15780;
$c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
if (strpos($c, 'brm-prog-cta') !== false) { echo "already has form\n"; return; }

$form = file_get_contents(__DIR__ . '/police-form-block.html');
$lastH2 = strrpos($c, '<h2');
if ($lastH2 === false) { echo "no h2\n"; return; }
$newC = substr($c, 0, $lastH2) . $form . "\n\n" . substr($c, $lastH2);
if (!get_post_meta($pid, '_brm_formcta_backup_20260611', true)) {
    add_post_meta($pid, '_brm_formcta_backup_20260611', wp_slash($c), true);
}
$wpdb->update($wpdb->posts, array('post_content' => $newC), array('ID' => $pid));
clean_post_cache($pid);
echo "police-officers form inserted before last h2 (post $pid)\n";
