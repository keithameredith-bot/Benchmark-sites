<?php
// Convert Divi-block posts to clean classic HTML so Kadence renders them.
// - Extracts innerContent HTML from every divi block's JSON attrs (document order).
// - Backs up original post_content to postmeta _divi_original_content (once).
// - Idempotent: skips posts without wp:divi markers.
// - Pass post IDs as args; no args = dry-run listing module types only.
global $wpdb;

function brm_collect_inner($node, &$out) {
    if (is_array($node) || is_object($node)) {
        foreach ($node as $k => $v) {
            if ($k === 'innerContent' && (is_array($v) || is_object($v))) {
                $v = (array) $v;
                if (isset($v['desktop'])) {
                    $d = (array) $v['desktop'];
                    if (isset($d['value']) && is_string($d['value'])) {
                        $out[] = $d['value'];
                        continue;
                    }
                }
            }
            brm_collect_inner($v, $out);
        }
    }
}

$ids = array_map('intval', $args);
$apply = count($ids) > 0;
if (!$apply) {
    $rows = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post') AND post_content LIKE '%wp:divi/%'");
    $ids = array_map('intval', $rows);
}

foreach ($ids as $pid) {
    $content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    if (strpos($content, 'wp:divi/') === false) { echo "[$pid] no divi markers, skip\n"; continue; }

    preg_match_all('/<!--\s*wp:divi\/([a-z0-9-]+)\s*(\{.*?\})?\s*\/?-->/s', $content, $m, PREG_SET_ORDER);
    $types = array();
    $chunks = array();
    foreach ($m as $b) {
        $types[$b[1]] = true;
        if (empty($b[2])) continue;
        $j = json_decode($b[2]);
        if (!$j) continue;
        brm_collect_inner($j, $chunks);
    }
    $html = trim(implode("\n\n", $chunks));
    // strip editor artifacts
    $html = str_replace(' data-wp-editing="1"', '', $html);
    $wordcount = str_word_count(strip_tags($html));
    echo "[$pid] modules: " . implode(',', array_keys($types)) . " | extracted ~$wordcount words\n";

    if (!$apply) continue;
    if ($wordcount < 30) { echo "[$pid] too little content extracted, NOT applying\n"; continue; }

    if (!get_post_meta($pid, '_divi_original_content', true)) {
        add_post_meta($pid, '_divi_original_content', wp_slash($content), true);
    }
    $wpdb->update($wpdb->posts, array('post_content' => $html), array('ID' => $pid));
    clean_post_cache($pid);
    echo "[$pid] converted + backup saved\n";
}
if (!$apply) echo "\nDRY RUN ONLY — rerun with post IDs to apply.\n";
