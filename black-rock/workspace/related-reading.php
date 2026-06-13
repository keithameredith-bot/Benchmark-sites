<?php
// Append a "Related reading"/"Also serving" block to key pages, linking INTO new content.
// Idempotent via marker comment per page.
global $wpdb;

function brm_append_block($slug, $heading, $links) {
    global $wpdb;
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_status='publish'", $slug));
    if (!$pid) { echo "MISS $slug\n"; return; }
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    $marker = "<!-- brm-related-$slug -->";
    if (strpos($c, $marker) !== false) { echo "skip $slug (already added)\n"; return; }
    $lis = '';
    foreach ($links as $href => $text) $lis .= "<li><a href=\"$href\">$text</a></li>";
    $block = "\n\n$marker\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">$heading</h2>\n<!-- /wp:heading -->\n<!-- wp:list -->\n<ul class=\"wp-block-list\">$lis</ul>\n<!-- /wp:list -->\n";
    $wpdb->update($wpdb->posts, array('post_content' => $c . $block), array('ID' => $pid));
    clean_post_cache($pid);
    echo "added -> $slug (post $pid)\n";
}

brm_append_block('hometown-heroes-mortgage-program', 'Related Reading', array(
    '/florida-first-time-home-buyer-grants/' => 'Every Florida first-time home buyer grant &amp; program (2026)',
    '/requirements-to-buy-a-house-in-florida/' => 'Requirements to buy a house in Florida: the complete checklist',
));
brm_append_block('florida-mobile-home-financing', 'Related Reading', array(
    '/cheapest-places-to-buy-a-house-in-florida/' => 'The cheapest places to buy a house in Florida',
    '/belleview-mortgage-broker/' => 'Manufactured home financing in Belleview &amp; south Marion County',
    '/manufactured-home-financing-in-2026-everything-you-need-to-know/' => 'Manufactured home financing in 2026: programs, myths &amp; qualifying',
));
brm_append_block('down-payment-assistance-in-florida', 'Related Reading', array(
    '/florida-first-time-home-buyer-grants/' => 'Florida first-time home buyer grants: the complete 2026 list',
    '/hometown-heroes-mortgage-program/' => 'Florida Hometown Heroes: up to $35,000 toward your purchase',
));
brm_append_block('documents-needed-for-a-mortgage', 'Related Reading', array(
    '/requirements-to-buy-a-house-in-florida/' => 'Requirements to buy a house in Florida (2026 checklist)',
    '/get-pre-approved/' => 'Get pre-approved in about 24 hours',
));
brm_append_block('ocala-mortgage-broker', 'Also Serving Your Area', array(
    '/the-villages-mortgage-broker/' => 'The Villages mortgage broker — VA, HECM &amp; 55+ lending',
    '/gainesville-mortgage-broker/' => 'Gainesville mortgage broker — first-time buyers &amp; investors',
    '/belleview-mortgage-broker/' => 'Belleview mortgage broker — USDA &amp; manufactured homes',
    '/new-houses-in-ocala-florida/' => 'New construction homes in Ocala with $0-down options',
));
brm_append_block('reverse-mortgages', 'Related Reading', array(
    '/the-villages-mortgage-broker/' => 'Buying in The Villages with a HECM — local guide',
    '/florida-property-tax-exemptions/' => 'Florida property tax exemptions for seniors',
));
