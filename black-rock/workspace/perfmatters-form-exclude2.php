<?php
// Correct key: lazyload.lazy_loading_exclusions is an ARRAY in perfmatters_options.
$o = get_option('perfmatters_options');
$ex = $o['lazyload']['lazy_loading_exclusions'] ?? array();
if (!is_array($ex)) $ex = array_filter(array_map('trim', explode("\n", (string)$ex)));
$add = array('uploads/forms/', 'brmPreapproval', 'brmRecruit', 'brmContact');
$changed = false;
foreach ($add as $a) { if (!in_array($a, $ex, true)) { $ex[] = $a; $changed = true; } }
// remove my bad key from round 1
if (isset($o['lazyload']['lazyload_exclusions'])) { unset($o['lazyload']['lazyload_exclusions']); $changed = true; }
if ($changed) {
    $o['lazyload']['lazy_loading_exclusions'] = array_values($ex);
    update_option('perfmatters_options', $o);
    echo "exclusions fixed: " . json_encode($o['lazyload']['lazy_loading_exclusions']) . "\n";
} else echo "no change needed\n";
wp_cache_flush();
