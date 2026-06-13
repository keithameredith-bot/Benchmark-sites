<?php
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/image.php';
$up = wp_upload_dir();
$file = 'down-payment-assistance-in-florida-black-rock-mortgage.webp';
$alt = 'Down payment assistance in Florida - Black Rock Mortgage';
$page = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name='down-payment-assistance-in-florida' AND post_status='publish'");
$old = get_post_thumbnail_id($page);
$dest = $up['path'] . '/' . $file;
copy('C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file, $dest);
$att = wp_insert_attachment(array('post_mime_type'=>'image/webp','post_title'=>$alt,'post_status'=>'inherit'), $dest, $page);
wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $dest));
update_post_meta($att, '_wp_attachment_image_alt', $alt);
set_post_thumbnail($page, $att);
echo "DPA thumbnail swapped (old att $old kept in library, new att $att)\n";
