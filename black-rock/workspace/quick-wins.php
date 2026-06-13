<?php
// Quick wins, run via wp eval-file:
// 1. Add missing 301: /dscr-loans-florida-2/ -> /florida-dscr-loan/ (404s on live!)
// 2. Fill empty AIOSEO titles/descriptions on posts that already rank.
global $wpdb;
$rt = $wpdb->prefix . 'aioseo_redirects';
$exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $rt WHERE source_url = %s", '/dscr-loans-florida-2/'));
if (!$exists) {
    $wpdb->insert($rt, array(
        'source_url'       => '/dscr-loans-florida-2/',
        'source_url_hash'  => sha1('/dscr-loans-florida-2/'),
        'target_url'       => '/florida-dscr-loan/',
        'target_url_hash'  => sha1('/florida-dscr-loan/'),
        'type'             => 301,
        'query_param'      => 'exact',
        'enabled'          => 1,
        'regex'            => 0,
        'ignore_slash'     => 1,
        'ignore_case'      => 1,
        'created'          => current_time('mysql', true),
        'updated'          => current_time('mysql', true),
    ));
    echo "redirect added: /dscr-loans-florida-2/ -> /florida-dscr-loan/\n";
} else {
    echo "redirect already exists\n";
}

$fixes = array(
    'florida-usda-turn-times' => array(
        'title' => 'Florida USDA Turn Times — Current Processing Updates | Black Rock Mortgage',
        'desc'  => 'Current USDA Rural Development turn times for Florida. See how long USDA loan approval is taking right now and how to keep your closing on schedule.',
    ),
    'new-usda-income-limits' => array(
        'title' => 'New USDA Income Limits for Florida — Do You Qualify? | Black Rock Mortgage',
        'desc'  => 'USDA raised its income limits for Florida households. See the new limits by county and household size, and find out if you now qualify for $0-down USDA.',
    ),
    'do-mortgage-lenders-use-fico-or-vantagescore' => array(
        'title' => 'Do Mortgage Lenders Use FICO or VantageScore? | Black Rock Mortgage',
        'desc'  => 'Mortgage lenders pull specific FICO score versions — not the VantageScore you see in free apps. Learn which scores count and how to check yours.',
    ),
    'housing-prices-in-florida' => array(
        'title' => 'Housing Prices in Florida — Market Trends & What Buyers Should Know',
        'desc'  => 'Where Florida home prices stand now, how they got here, and what it means if you are buying or refinancing. Insights from a Florida mortgage broker.',
    ),
    'saving-deals-with-the-mcc-first-time-home-buyer-program' => array(
        'title' => 'How the MCC First-Time Home Buyer Program Saves Florida Deals',
        'desc'  => 'The Mortgage Credit Certificate (MCC) gives Florida first-time buyers a federal tax credit that can rescue qualification. See how it works.',
    ),
);
$pt = $wpdb->prefix . 'aioseo_posts';
foreach ($fixes as $slug => $f) {
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_status = 'publish'", $slug));
    if (!$pid) { echo "SKIP $slug (not found)\n"; continue; }
    $row = $wpdb->get_var($wpdb->prepare("SELECT id FROM $pt WHERE post_id = %d", $pid));
    if ($row) {
        $wpdb->update($pt, array('title' => $f['title'], 'description' => $f['desc'], 'updated' => current_time('mysql', true)), array('post_id' => $pid));
    } else {
        $wpdb->insert($pt, array('post_id' => $pid, 'title' => $f['title'], 'description' => $f['desc'], 'created' => current_time('mysql', true), 'updated' => current_time('mysql', true)));
    }
    echo "seo title set: $slug (post $pid)\n";
}
