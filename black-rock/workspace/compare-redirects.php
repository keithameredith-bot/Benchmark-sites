<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}aioseo_redirects WHERE source_url IN ('/dscr-loans-florida-2/', '/0-down-usda-rural-development-mortgage/')", ARRAY_A);
foreach ($rows as $r) {
    echo "--- {$r['source_url']}\n";
    foreach ($r as $k => $v) {
        if ($v !== null && $v !== '') echo "  $k: " . substr($v, 0, 100) . "\n";
    }
}
