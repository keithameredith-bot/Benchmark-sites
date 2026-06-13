<?php
// Exclude ALL our form iframes (uploads/forms/) from Perfmatters lazyload. Never lazy-load the money form.
$o = get_option('perfmatters_options');
if (!is_array($o)) { echo "perfmatters_options not found\n"; return; }
echo "lazyload settings now: " . json_encode($o['lazyload'] ?? array()) . "\n";
if (!isset($o['lazyload'])) $o['lazyload'] = array();
$ex = $o['lazyload']['lazyload_exclusions'] ?? '';
// perfmatters stores exclusions as newline-separated string
if (strpos($ex, 'uploads/forms/') === false) {
    $o['lazyload']['lazyload_exclusions'] = trim($ex . "\nuploads/forms/\nbrmPreapproval\nbrmRecruit\nbrmContact");
    update_option('perfmatters_options', $o);
    echo "exclusions added\n";
} else echo "already excluded\n";
wp_cache_flush();
