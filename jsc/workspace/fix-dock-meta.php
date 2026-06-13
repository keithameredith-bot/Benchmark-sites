<?php
// Dock page title + description per DataForSEO findings (2026-06-10). Idempotent.
global $wpdb;
$title = 'Central Florida Dock Builders — Custom Docks & Dock Repair';
$desc  = 'Custom dock building and dock repair across Central Florida. Wood or composite, lakes to coastline — JSC designs, permits and builds it right. Free quotes!';
echo 'title=' . mb_strlen( $title ) . ' desc=' . mb_strlen( $desc ) . "\n";
$wpdb->update( $wpdb->prefix . 'aioseo_posts', array( 'title' => $title, 'description' => $desc ), array( 'post_id' => 100394 ) );
echo "OK dock page meta updated\n";
