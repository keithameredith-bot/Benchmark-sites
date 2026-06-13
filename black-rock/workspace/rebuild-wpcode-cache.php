<?php
global $wpdb;
// force WPCode to rebuild its snippet cache from the posts table
delete_option('wpcode_snippets');
wp_cache_flush();
echo "wpcode_snippets cache deleted\n";
// trigger a rebuild if API available
if (function_exists('wpcode') && isset(wpcode()->cache) && method_exists(wpcode()->cache, 'cache_all_loaded_snippets')) {
    wpcode()->cache->cache_all_loaded_snippets();
    echo "cache_all_loaded_snippets() called\n";
}
$len = $wpdb->get_var("SELECT LENGTH(option_value) FROM {$wpdb->options} WHERE option_name='wpcode_snippets'");
echo "wpcode_snippets now: " . ($len ?: '(absent - will rebuild on next request)') . "\n";
