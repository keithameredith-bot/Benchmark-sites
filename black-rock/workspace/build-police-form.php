<?php
// Extract the reworked form block from USDA (42) and write police-form-v2.html with Hometown Heroes copy.
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=42");
$marker = strpos($c, 'brm-prog-cta');           // locate the form, then back up to its wp:html opener
$s = strrpos(substr($c, 0, $marker), '<!-- wp:html -->');
$e = strpos($c, '<!-- /wp:html -->', $marker) + strlen('<!-- /wp:html -->');
$block = substr($c, $s, $e - $s);
$block = str_replace('Get Your USDA Pre-Approval in 24 Hours', 'Get Your Hometown Heroes Pre-Approval', $block);
$block = preg_replace('/<p class="brm-prog-cta-lead">.*?<\/p>/s', '<p class="brm-prog-cta-lead">Up to $35,000 toward your purchase for Florida\'s frontline heroes. Get pre-approved in 24 hours.</p>', $block);
file_put_contents(__DIR__ . '/police-form-v2.html', $block);
echo "wrote " . strlen($block) . " bytes; heroes=" . (strpos($block,'Hometown Heroes Pre-Approval')!==false?'y':'n') . " phone=" . (strpos($block,'brm-prog-cta-call')!==false?'y':'n') . "\n";
