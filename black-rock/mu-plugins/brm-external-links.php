<?php
/**
 * Plugin Name: BRM External Links — Open Portal in New Tab
 * Description: The my1003app application portal is a separate site; open any content link to it in a new tab (target=_blank, rel=noopener). Covers every CTA site-wide + future ones automatically.
 * Author: Benchmark Web Design
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

add_filter('the_content', function ($c) {
    if (strpos($c, 'my1003app.com') === false) return $c;
    return preg_replace_callback('/<a\s+([^>]*?href="[^"]*my1003app\.com[^"]*"[^>]*?)>/i', function ($m) {
        $attrs = $m[1];
        if (stripos($attrs, 'target=') !== false) return $m[0]; // already opens somewhere — leave it
        return '<a ' . $attrs . ' target="_blank" rel="noopener">';
    }, $c);
}, 60);
