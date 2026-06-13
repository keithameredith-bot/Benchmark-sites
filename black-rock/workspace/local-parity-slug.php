<?php
// Local parity: replace /work-with-us/ -> /become-a-mortgage-broker/ in content + widget option.
global $wpdb;
// states page + any content
foreach ($wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%/work-with-us/%'") as $p) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $p->ID));
    $c = str_replace('/work-with-us/', '/become-a-mortgage-broker/', $c);
    $wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$p->ID));
    clean_post_cache($p->ID);
    echo "content fixed: page {$p->ID}\n";
}
// widget_block option
$wb = get_option('widget_block');
if (is_array($wb)) {
    $changed = false;
    foreach ($wb as $k=>$v) { if (is_array($v) && isset($v['content']) && strpos($v['content'],'/work-with-us/')!==false) { $wb[$k]['content']=str_replace('/work-with-us/','/become-a-mortgage-broker/',$v['content']); $changed=true; } }
    if ($changed) { update_option('widget_block',$wb); echo "widget_block option fixed\n"; } else echo "widget_block: link is by-reference (no hardcoded URL) — self-heals\n";
}
wp_cache_flush();
echo "local parity done\n";
