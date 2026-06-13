<?php
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/image.php';
$up = wp_upload_dir();
$map = array(
  'client-reviews-black-rock-mortgage.webp' => array('reviews', 'Client reviews - 5-star Florida mortgage broker Black Rock Mortgage'),
  'florida-physician-loans-black-rock-mortgage.webp' => array('florida-physician-loan', 'Florida physician loans - 100% financing no PMI - Black Rock Mortgage'),
);
foreach ($map as $file => $cfg) {
    list($slug, $alt) = $cfg;
    $src = 'C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file;
    if (!file_exists($src)) { echo "$file MISSING\n"; continue; }
    $page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish' AND post_type='page'", $slug));
    if (!$page) { echo "page $slug missing\n"; continue; }
    if (get_post_thumbnail_id($page)) { echo "$slug already has thumb\n"; continue; }
    $dest = $up['path'] . '/' . $file;
    copy($src, $dest);
    $att = wp_insert_attachment(array('post_mime_type'=>'image/webp','post_title'=>$alt,'post_status'=>'inherit'), $dest, $page);
    wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $dest));
    update_post_meta($att, '_wp_attachment_image_alt', $alt);
    set_post_thumbnail($page, $att);
    echo "$slug: featured set (att $att)\n";
}
