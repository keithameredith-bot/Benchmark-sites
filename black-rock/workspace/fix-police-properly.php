<?php
// Restore police-officers (15780) clean content (pre-form) and append the reworked form at the END.
global $wpdb;
$pid = 15780;
// _brm_formcta_backup_20260611 was saved by fix-police-form.php BEFORE any form insert = clean converted content.
$clean = get_post_meta($pid, '_brm_formcta_backup_20260611', true);
if (!$clean) { echo "ERROR: clean backup missing\n"; return; }
$clean = wp_unslash($clean);
if (strpos($clean, 'brm-prog-cta') !== false) { echo "ERROR: backup already has form, abort\n"; return; }
echo "clean content: " . str_word_count(strip_tags($clean)) . " words\n";

$form = file_get_contents(__DIR__ . '/police-form-v2.html');
$newC = rtrim($clean) . "\n\n" . $form . "\n";
$wpdb->update($wpdb->posts, array('post_content' => $newC), array('ID' => $pid));
clean_post_cache($pid);
echo "police restored + form appended at end (" . str_word_count(strip_tags($newC)) . " words total)\n";
