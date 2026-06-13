<?php
// Clear stale custom AIOSEO titles (old singular wording) so the default post_title pattern applies.
global $wpdb;
$n = $wpdb->query( "UPDATE {$wpdb->prefix}aioseo_posts SET title = NULL WHERE post_id IN (100513, 100421)" );
echo "cleared: $n\n";
