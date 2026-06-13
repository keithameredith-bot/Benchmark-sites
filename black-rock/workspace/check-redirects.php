<?php
// List AIOSEO redirects relevant to top-ranking legacy URLs.
global $wpdb;
$rows = $wpdb->get_results("SELECT source_url, target_url, type, enabled FROM {$wpdb->prefix}aioseo_redirects ORDER BY source_url");
echo "total redirects: " . count($rows) . "\n";
$watch = array('0-down-usda', 'dscr-loans-florida', 'reverse-mortgage-in-florida', 'usda-turn', 'mobile-home');
foreach ($rows as $r) {
    foreach ($watch as $w) {
        if (stripos($r->source_url, $w) !== false) {
            echo sprintf("%s => %s [%d, %s]\n", $r->source_url, $r->target_url, $r->type, $r->enabled ? 'on' : 'OFF');
            continue 2;
        }
    }
}
