<?php
// Import the 9 webp images into the media library and set as featured images with alt text.
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$srcDir = 'C:/Users/keith/Desktop/black-rock-workspace/featured-ready/';
$map = array(
  'down-payment-assistance-in-florida-black-rock-mortgage.webp' => array('down-payment-assistance-in-florida', 'Down payment assistance in Florida - Black Rock Mortgage'),
  'florida-first-time-home-buyer-grants-black-rock-mortgage.webp' => array('florida-first-time-home-buyer-grants', 'Florida first-time home buyer grants - Black Rock Mortgage'),
  'cheapest-places-to-buy-a-house-in-florida-black-rock-mortgage.webp' => array('cheapest-places-to-buy-a-house-in-florida', 'Cheapest places to buy a house in Florida - Black Rock Mortgage'),
  'rent-to-own-homes-in-florida-black-rock-mortgage.webp' => array('rent-to-own-homes-in-florida', 'Rent-to-own homes in Florida - Black Rock Mortgage'),
  'florida-property-tax-exemptions-black-rock-mortgage.webp' => array('florida-property-tax-exemptions', 'Florida property tax exemptions - Black Rock Mortgage'),
  'the-villages-mortgage-broker-black-rock-mortgage.webp' => array('the-villages-mortgage-broker', 'The Villages FL mortgage broker - Black Rock Mortgage'),
  'gainesville-mortgage-broker-black-rock-mortgage.webp' => array('gainesville-mortgage-broker', 'Gainesville FL mortgage broker - Black Rock Mortgage'),
  'belleview-mortgage-broker-black-rock-mortgage.webp' => array('belleview-mortgage-broker', 'Belleview FL mortgage broker - Black Rock Mortgage'),
  'requirements-to-buy-a-house-in-florida-black-rock-mortgage.webp' => array('requirements-to-buy-a-house-in-florida', 'Requirements to buy a house in Florida - Black Rock Mortgage'),
);

$up = wp_upload_dir();
foreach ($map as $file => $cfg) {
    list($slug, $alt) = $cfg;
    $page = $wpdb->get_row($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status IN ('publish','future') AND post_type IN ('page','post')", $slug));
    if (!$page) { echo "MISS page $slug\n"; continue; }
    if (get_post_thumbnail_id($page->ID)) { echo "$slug: already has thumbnail\n"; continue; }
    $dest = $up['path'] . '/' . $file;
    if (!copy($srcDir . $file, $dest)) { echo "$slug: copy failed\n"; continue; }
    $att = wp_insert_attachment(array(
        'post_mime_type' => 'image/webp',
        'post_title' => $alt,
        'post_status' => 'inherit',
    ), $dest, $page->ID);
    if (is_wp_error($att) || !$att) { echo "$slug: attach failed\n"; continue; }
    wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $dest));
    update_post_meta($att, '_wp_attachment_image_alt', $alt);
    set_post_thumbnail($page->ID, $att);
    echo "$slug: featured image set (att $att)\n";
}
echo "done\n";
