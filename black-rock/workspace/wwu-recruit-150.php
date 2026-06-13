<?php
// Recruiter override: $200 -> $150 per file (and fix the example math: 4 loans/mo = $600/mo).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$old = 'Recruit for the Coast 2 Coast team and earn <strong>$200 per file your recruits close &mdash; for as long as they&rsquo;re with the company</strong>. One great recruit closing four loans a month is $800/month of passive pipeline, forever. Build a downline, not just a book.';
$new = 'Recruit for the Coast 2 Coast team and earn <strong>$150 per file your recruits close &mdash; for as long as they&rsquo;re with the company</strong>. One great recruit closing four loans a month is $600/month of passive pipeline, forever. Build a downline, not just a book.';
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
    clean_post_cache($pid);
    wp_cache_flush();
    echo "updated to \$150 (+example math)\n";
} else echo "pattern not found\n";
