<?php
$posts = get_posts(array('post_type'=>'post','post_status'=>array('publish','future'),'numberposts'=>-1,'orderby'=>'date','order'=>'DESC'));
echo count($posts) . " posts\n\n";
foreach ($posts as $p) {
    $cats = wp_get_post_categories($p->ID, array('fields'=>'names'));
    echo "[{$p->ID}] ({$p->post_status}) " . $p->post_name . "  => " . implode(', ', $cats) . "\n";
}
echo "\nexisting categories:\n";
foreach (get_categories(array('hide_empty'=>false)) as $c) echo "  {$c->term_id}: {$c->name} ({$c->count})\n";
