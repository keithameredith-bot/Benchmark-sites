<?php
global $wpdb;
$menu_id = 2;
$items = wp_get_nav_menu_items($menu_id);

// 1. Add "Client Reviews" under About
$aboutId = null; $hasReviews = false;
foreach ($items as $it) {
    if (rtrim($it->url,'/') === home_url('/about-us') || $it->title==='About') $aboutId = $it->ID;
    if (stripos($it->url,'/reviews')!==false) $hasReviews = true;
}
if ($aboutId && !$hasReviews) {
    $cid = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title'=>'Client Reviews','menu-item-url'=>home_url('/reviews/'),
        'menu-item-status'=>'publish','menu-item-type'=>'custom','menu-item-parent-id'=>$aboutId,
        'menu-item-description'=>'5-star reviews from Florida buyers',
    ));
    echo "added Client Reviews under About (item $cid)\n";
} else echo "reviews: ".($hasReviews?'already present':'About not found')."\n";

// 2. Add short descriptions to loan program items (for mega menu display)
$desc = array(
    '/fha-home-mortgage-loan/' => '3.5% down, credit from 580',
    '/va-home-mortgage/' => '$0 down for veterans',
    '/florida-usda-mortgage/' => '$0 down in rural Florida',
    '/conventional-mortgage-in-florida/' => 'As little as 3% down',
    '/florida-jumbo-loan/' => 'Financing up to $15M',
    '/florida-dscr-loan/' => 'Qualify on rental income',
    '/florida-non-qm-loans/' => 'Bank statement & asset-based',
    '/florida-physician-loan/' => '100% financing for doctors',
    '/condo-tel-financing-in-florida/' => 'Condotel & non-warrantable',
    '/florida-mobile-home-financing/' => 'Manufactured homes on land',
    '/florida-construction-loan/' => 'One-time-close construction',
    '/hometown-heroes-mortgage-program/' => 'Up to $35K in down payment help',
    '/down-payment-assistance-in-florida/' => 'Down payment assistance programs',
    '/self-employed-mortgage/' => '12 or 24-month bank statements',
    '/reverse-mortgages/' => 'HECM for homeowners 62+',
    '/home-equity-line-of-credit-in-florida/' => 'Tap equity, close in days',
);
$n=0;
foreach ($items as $it) {
    $path = str_replace(home_url(),'',$it->url);
    if (isset($desc[$path]) && trim((string)$it->description)==='') {
        wp_update_nav_menu_item($menu_id, $it->ID, array(
            'menu-item-title'=>$it->title,
            'menu-item-url'=>$it->url,
            'menu-item-status'=>'publish',
            'menu-item-parent-id'=>$it->menu_item_parent,
            'menu-item-position'=>$it->menu_order,
            'menu-item-description'=>$desc[$path],
            'menu-item-object'=>$it->object,
            'menu-item-object-id'=>$it->object_id,
            'menu-item-type'=>$it->type,
        ));
        $n++;
    }
}
echo "added descriptions to $n loan-program menu items\n";
wp_cache_flush();
