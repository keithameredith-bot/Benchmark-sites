<?php
// Noindex thin/dated pages via AIOSEO robots settings.
global $wpdb;
$slugs = array('4743-se-35th-st-ocala-fl-34480', 'covid-19-update-in-the-mortgage-banking-industry');
$pt = $wpdb->prefix . 'aioseo_posts';
foreach ($slugs as $slug) {
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name = %s", $slug));
    if (!$pid) { echo "MISS $slug\n"; continue; }
    $row = $wpdb->get_var($wpdb->prepare("SELECT id FROM $pt WHERE post_id = %d", $pid));
    $data = array('robots_default' => 0, 'robots_noindex' => 1, 'updated' => current_time('mysql', true));
    if ($row) { $wpdb->update($pt, $data, array('post_id' => $pid)); }
    else { $data['post_id'] = $pid; $data['created'] = current_time('mysql', true); $wpdb->insert($pt, $data); }
    echo "noindexed: $slug (post $pid)\n";
}
