<?php
// Dump published content inventory with AIOSEO title/description as JSON.
// Run with: wp eval-file site-inventory.php
global $wpdb;
$rows = $wpdb->get_results("
    SELECT p.ID, p.post_type, p.post_name, p.post_title, p.post_parent,
           LENGTH(p.post_content) AS content_len,
           a.title AS seo_title, a.description AS seo_desc
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->prefix}aioseo_posts a ON a.post_id = p.ID
    WHERE p.post_status = 'publish' AND p.post_type IN ('page','post')
    ORDER BY p.post_type, p.post_parent, p.post_name
");
$out = array();
foreach ($rows as $r) {
    $out[] = array(
        'id'        => (int) $r->ID,
        'type'      => $r->post_type,
        'url'       => str_replace(home_url(), '', get_permalink($r->ID)),
        'title'     => $r->post_title,
        'seo_title' => $r->seo_title,
        'seo_desc'  => $r->seo_desc ? mb_substr($r->seo_desc, 0, 120) : null,
        'words'     => (int) round($r->content_len / 6), // rough proxy
    );
}
echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
