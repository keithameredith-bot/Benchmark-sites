<?php
// Merge duplicate aioseo_posts rows: AIOSEO reads the first row per post_id; my inserted titles
// landed in a second row. Copy title/desc into the kept row, delete the dupe.
global $wpdb;
$t = $wpdb->prefix . 'aioseo_posts';
$dups = $wpdb->get_results("SELECT post_id, COUNT(*) n, MIN(id) keep_id, MAX(id) dupe_id FROM $t GROUP BY post_id HAVING n > 1");
echo count($dups) . " posts with duplicate rows\n";
foreach ($dups as $d) {
    $keep = $wpdb->get_row($wpdb->prepare("SELECT id, title, description FROM $t WHERE id=%d", $d->keep_id));
    $dupe = $wpdb->get_row($wpdb->prepare("SELECT id, title, description, robots_default, robots_noindex FROM $t WHERE id=%d", $d->dupe_id));
    // copy whichever row has content into the kept row
    $title = $keep->title ?: $dupe->title;
    $desc  = $keep->description ?: $dupe->description;
    $upd = array('title' => $title, 'description' => $desc, 'updated' => current_time('mysql', true));
    if ($dupe->robots_noindex) { $upd['robots_default'] = 0; $upd['robots_noindex'] = 1; }
    $wpdb->update($t, $upd, array('id' => $d->keep_id));
    $wpdb->delete($t, array('id' => $d->dupe_id));
    $slug = $wpdb->get_var($wpdb->prepare("SELECT post_name FROM {$wpdb->posts} WHERE ID=%d", $d->post_id));
    echo "merged $slug (kept {$d->keep_id}, removed {$d->dupe_id}): " . substr($title,0,50) . "\n";
}
wp_cache_flush();
echo "done\n";
