<?php
global $wpdb;

// ---- 1. grants article: remove MCC-as-available claims (publishes Jun 18!)
$pid = 987515421;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;
$old = ', a forgivable 3&ndash;5% HFA PLUS grant, and a recurring federal tax credit through the MCC &mdash;';
$new = ' and a forgivable 3&ndash;5% HFA PLUS grant &mdash;';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $n++; }
// find remaining MCC mentions and show context
$off = 0;
while (($i = stripos($c, 'MCC', $off)) !== false) {
    $ctx = preg_replace('/\s+/', ' ', strip_tags(substr($c, max(0,$i-150), 360)));
    echo "remaining MCC @ $i: ...$ctx...\n";
    $off = $i + 3;
}
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
echo "grants article: $n fix(es)\n";

// ---- 2. WWU: remove UWM from stack strip (keep in Platinum section)
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=18179");
$old = '
      <img src="/wp-content/uploads/wwu/logo-uwm.webp" alt="UWM - United Wholesale Mortgage" loading="lazy">';
if (strpos($c, $old) !== false) {
    $c = str_replace($old, '', $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>18179));
    clean_post_cache(18179);
    echo "UWM removed from stack strip\n";
} else echo "UWM strip img not found\n";
wp_cache_flush();
