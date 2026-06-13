<?php
global $wpdb;
$t = $wpdb->prefix . 'aioseo_posts';
foreach (array('florida-physician-loan','reviews','cheapest-places-to-buy-a-house-in-florida') as $s) {
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $s));
    $rows = $wpdb->get_results($wpdb->prepare("SELECT id, post_id, LEFT(title,60) t, LEFT(description,40) d FROM $t WHERE post_id=%d", $pid));
    echo "$s (post $pid): " . count($rows) . " aioseo row(s)\n";
    foreach ($rows as $r) echo "   row {$r->id}: title='{$r->t}' desc='{$r->d}'\n";
}
echo "\nlast wpdb error: " . $wpdb->last_error . "\n";
// try a fresh test insert to see the error
$ok = $wpdb->insert($t, array('post_id' => 999999999, 'title' => 'TEST', 'description' => 'TEST', 'created' => current_time('mysql', true), 'updated' => current_time('mysql', true)));
echo "test insert: " . var_export($ok, true) . " err: " . $wpdb->last_error . "\n";
if ($ok) $wpdb->delete($t, array('post_id' => 999999999));
