<?php
// disable comments sitewide: defaults off, close on all existing content, drop the junk
update_option("default_comment_status", "closed");
update_option("default_ping_status", "closed");
update_option("comments_notify", 0);
global $wpdb;
$n = $wpdb->query("UPDATE {$wpdb->posts} SET comment_status=\x27closed\x27, ping_status=\x27closed\x27 WHERE comment_status=\x27open\x27 OR ping_status=\x27open\x27");
echo "closed comments/pings on {$n} posts\n";
$spam = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->comments}");
echo "existing comments in DB: {$spam}\n";
if ($spam > 0) {
  $c = $wpdb->get_results("SELECT comment_ID, comment_author, LEFT(comment_content, 60) t FROM {$wpdb->comments} LIMIT 5");
  foreach ($c as $r) echo "  #{$r->comment_ID} {$r->comment_author}: {$r->t}\n";
}
