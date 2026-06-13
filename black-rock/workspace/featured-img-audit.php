<?php
// List the new/rebuilt pages+posts that have NO featured image.
global $wpdb;
$slugs = array(
  'cheapest-places-to-buy-a-house-in-florida','florida-first-time-home-buyer-grants','rent-to-own-homes-in-florida',
  'requirements-to-buy-a-house-in-florida','florida-property-tax-exemptions',
  'the-villages-mortgage-broker','gainesville-mortgage-broker','belleview-mortgage-broker',
  'florida-physician-loan','reviews','states-we-are-licensed','florida-usda-turn-times',
);
echo "PAGES/POSTS NEEDING A FEATURED IMAGE:\n\n";
$n = 0;
foreach ($slugs as $s) {
    $p = $wpdb->get_row($wpdb->prepare("SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $s));
    if (!$p) continue;
    $thumb = get_post_thumbnail_id($p->ID);
    if (!$thumb) { $n++; echo sprintf("%2d. %-42s  /%s/\n", $n, $p->post_title, $s); }
}
echo "\n$n need images. Recommended size: 1200x630 (also serves as the social/OG share image).\n";
