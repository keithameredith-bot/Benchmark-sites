<?php
global $wpdb;
$t = $wpdb->prefix . 'aioseo_redirects';
// confirm hash algorithm using the known-good row
$ctrl = $wpdb->get_row("SELECT source_url_match, source_url_match_hash FROM $t WHERE source_url = '/0-down-usda-rural-development-mortgage/'");
echo "algo check: " . (sha1($ctrl->source_url_match) === $ctrl->source_url_match_hash ? "sha1 confirmed" : "NOT plain sha1!") . "\n";

$match = '/dscr-loans-florida-2';
$wpdb->update($t, array(
    'source_url_match'      => $match,
    'source_url_match_hash' => sha1($match),
), array('source_url' => '/dscr-loans-florida-2/'));
echo "row updated\n";
$wpdb->query("DELETE FROM {$wpdb->prefix}aioseo_cache");
wp_cache_flush();
echo "caches cleared\n";
