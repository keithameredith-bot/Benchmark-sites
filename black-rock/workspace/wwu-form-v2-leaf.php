<?php
// Bump recruiting form cache-bust + expand Leaf 360 copy in the stack section.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

$old = 'recruiting-form.html?v=1';
if (strpos($c, $old) !== false) { $c = str_replace($old, 'recruiting-form.html?v=2', $c); $n++; }

$old = '<strong>Leaf 360</strong> runs your pipeline,';
$new = '<strong>Leaf 360</strong> runs your pipeline on autopilot &mdash; automated SMS and email campaigns, lead nurture, and post-closing follow-up that keeps past clients referring,';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "applied: $n changes\n";
