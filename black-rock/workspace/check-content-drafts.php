<?php
global $wpdb;
// The drafts with real-article titles — are they complete content or stubs?
$ids = array(18799, 798, 987513668, 987513677, 987513679, 987513680, 528);
foreach ($ids as $id) {
    $p = get_post($id);
    if (!$p) continue;
    $words = str_word_count(strip_tags($p->post_content));
    $hasDesign = strpos($p->post_content, 'brm-article') !== false;
    $modified = $p->post_modified;
    echo "[{$id}] {$words}w" . ($hasDesign ? " [brm-design]" : "") . " mod:{$modified}\n      {$p->post_title}\n";
}
