<?php
// Remove literal \$ leaks from all published content (PHP single-quote/nowdoc escape bug),
// then apply the $200 -> $150 recruiter change.
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%\\\\\\\\$%'");
foreach ($rows as $r) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $r->ID));
    $count = substr_count($c, '\\$');
    if (!$count) continue;
    $c = str_replace('\\$', '$', $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$r->ID));
    clean_post_cache($r->ID);
    echo "[{$r->ID}] /{$r->post_name}/ — fixed $count literal \\\$\n";
}

// recruiter $200 -> $150
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=18179");
$old = 'earn <strong>$200 per file your recruits close &mdash; for as long as they&rsquo;re with the company</strong>. One great recruit closing four loans a month is $800/month';
$new = 'earn <strong>$150 per file your recruits close &mdash; for as long as they&rsquo;re with the company</strong>. One great recruit closing four loans a month is $600/month';
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>18179));
    clean_post_cache(18179);
    echo "recruiter override now \$150 (example \$600/mo)\n";
} else echo "recruiter pattern not found AFTER backslash fix - check\n";
wp_cache_flush();
echo "done\n";
