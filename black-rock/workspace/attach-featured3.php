<?php
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/image.php';
$up = wp_upload_dir();

// 1. swap reviews thumbnail (old fake-testimonial att 987515474 -> delete)
$page = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='reviews' AND post_status='publish' AND post_type='page'");
$old = get_post_thumbnail_id($page);
$file = 'client-reviews-real-black-rock-mortgage.webp';
$alt = 'Real client reviews - 5-star Florida mortgage broker Black Rock Mortgage';
copy('C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file, $up['path'] . '/' . $file);
$att = wp_insert_attachment(array('post_mime_type'=>'image/webp','post_title'=>$alt,'post_status'=>'inherit'), $up['path'] . '/' . $file, $page);
wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $up['path'] . '/' . $file));
update_post_meta($att, '_wp_attachment_image_alt', $alt);
set_post_thumbnail($page, $att);
if ($old && $old != $att) { wp_delete_attachment($old, true); echo "old fake-testimonial image deleted (att $old)\n"; }
echo "reviews: REAL-testimonial image set (att $att)\n";

// 2. states page
$page = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='states-we-are-licensed' AND post_status='publish' AND post_type='page'");
if (!get_post_thumbnail_id($page)) {
    $file = 'states-we-are-licensed-black-rock-mortgage.webp';
    $alt = 'States Black Rock Mortgage is licensed in - 40+ states nationwide';
    copy('C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file, $up['path'] . '/' . $file);
    $att = wp_insert_attachment(array('post_mime_type'=>'image/webp','post_title'=>$alt,'post_status'=>'inherit'), $up['path'] . '/' . $file, $page);
    wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $up['path'] . '/' . $file));
    update_post_meta($att, '_wp_attachment_image_alt', $alt);
    set_post_thumbnail($page, $att);
    echo "states: featured set (att $att)\n";
} else echo "states: already has thumb\n";
