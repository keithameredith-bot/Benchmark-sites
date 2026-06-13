<?php
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->prefix}aioseo_cache");
wp_cache_flush();
if (function_exists('aioseo') && isset(aioseo()->core->cache)) {
    aioseo()->core->cache->clear();
    echo "aioseo cache cleared\n";
}
echo "done\n";
