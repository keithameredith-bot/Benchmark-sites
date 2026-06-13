<?php
global $wpdb;
foreach (array(987515480, 987515481) as $pid) {
    $p = get_post($pid);
    $c = $p->post_content;
    $checks = array(
        'status=future' => $p->post_status === 'future',
        'quick-answer' => strpos($c, 'Quick answer') !== false,
        'stats row' => strpos($c, 'brm-stat') !== false,
        'table' => strpos($c, 'brm-table') !== false,
        'keith take' => strpos($c, 'brm-keith') !== false,
        'faq accordion' => substr_count($c, '<details') >= 5,
        'midcta' => strpos($c, 'brm-midcta') !== false,
        'dateline' => strpos($c, 'Written by Keith Meredith') !== false,
        'glyphs-ok' => !preg_match('/content:\s*"[0-9a-fA-F]{4}"/', $c),
    );
    // schema parses
    preg_match('/<script type="application\/ld\+json">\s*(\{.*?FAQPage.*?\})\s*<\/script>/s', $c, $m);
    $schema = isset($m[1]) ? json_decode($m[1]) : null;
    $checks['faq-schema-valid'] = $schema && count($schema->mainEntity) >= 5;
    $aio = $wpdb->get_var($wpdb->prepare("SELECT title FROM {$wpdb->prefix}aioseo_posts WHERE post_id=%d", $pid));
    $checks['aioseo-title'] = strlen((string)$aio) > 20;
    $fails = array_keys(array_filter($checks, fn($v) => !$v));
    echo "[$pid] {$p->post_name} ({$p->post_date}): " . (empty($fails) ? "ALL CHECKS PASS" : "FAIL: " . implode(',', $fails)) . " | words: " . str_word_count(strip_tags($c)) . "\n";
}
