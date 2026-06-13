<?php
// Fix stale '/excelsior/wp-content/' path prefix -> '/wp-content/'.
// posts: direct REPLACE (block markup is HTML/JSON, not PHP-serialized -> length-safe).
// options: via get/update_option to stay serialization-safe.
global $wpdb;
$from = '/excelsior/wp-content/';
$to   = '/wp-content/';

$n = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s) WHERE post_content LIKE %s",
    $from, $to, '%' . $wpdb->esc_like($from) . '%'
));
echo "posts updated: $n\n";

// options containing it
$opt_rows = $wpdb->get_col($wpdb->prepare("SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE %s", '%' . $wpdb->esc_like($from) . '%'));
foreach ($opt_rows as $name) {
    $val = get_option($name);
    $fixed = brm_deep_replace($val, $from, $to);
    update_option($name, $fixed);
    echo "option fixed: $name\n";
}
function brm_deep_replace($v, $from, $to) {
    if (is_string($v)) return str_replace($from, $to, $v);
    if (is_array($v)) { foreach ($v as $k => $x) $v[$k] = brm_deep_replace($x, $from, $to); return $v; }
    if (is_object($v)) { foreach ($v as $k => $x) $v->$k = brm_deep_replace($x, $from, $to); return $v; }
    return $v;
}

// verify none remain
$left = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_content LIKE '%excelsior%'")
      + $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_value LIKE '%excelsior%'");
echo "remaining 'excelsior' rows: $left\n";
wp_cache_flush();
