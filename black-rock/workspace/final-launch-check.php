<?php
// Pre-push verification sweep. Read-only — reports state, changes nothing.
global $wpdb;
echo "===== BRM PRE-PUSH VERIFICATION =====\n\n";

// 1. scheduled (future) posts
echo "[1] SCHEDULED POSTS (should auto-publish on live):\n";
$fut = $wpdb->get_results("SELECT post_title, post_date, post_name FROM {$wpdb->posts} WHERE post_status='future' AND post_type='post' ORDER BY post_date");
foreach ($fut as $p) echo "    " . substr($p->post_date,0,10) . "  /{$p->post_name}/\n";
echo "    => " . count($fut) . " scheduled\n\n";

// 2. draft pages/posts (will NOT go live as published — confirm intentional)
echo "[2] DRAFTS (stay hidden on live — confirm none should be published):\n";
$dr = $wpdb->get_results("SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE post_status='draft' AND post_type IN ('page','post') AND post_title != '' ORDER BY post_type");
foreach ($dr as $p) echo "    [{$p->ID}] {$p->post_type}: {$p->post_title}\n";
echo "    => " . count($dr) . " drafts\n\n";

// 3. literal backslash-dollar leak check (sitewide)
echo "[3] BACKSLASH-DOLLAR LEAKS (should be 0):\n";
$bd = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%\\\\\\\\$%'");
echo "    => $bd pages with literal \\\$\n\n";

// 4. absolute .local iframe srcs (should be 0 — phone/push hazard)
echo "[4] ABSOLUTE .local IFRAME SRCS (should be 0):\n";
$ab = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status IN ('publish','future') AND post_content LIKE '%black-rock-mortgage.local/wp-content/uploads/forms%'");
echo "    => $ab pages with absolute form src\n\n";

// 5. published page count + key pages present
echo "[5] KEY PAGES LIVE-READY:\n";
foreach (array('work-with-us','spec-construction-loans','florida-physician-loan','reviews','states-we-are-licensed','get-pre-approved','contact','about-us','keith-meredith') as $slug) {
    $st = $wpdb->get_var($wpdb->prepare("SELECT post_status FROM {$wpdb->posts} WHERE post_name=%s AND post_type='page'", $slug));
    echo "    /$slug/ : " . ($st ?: 'MISSING') . "\n";
}
echo "\n";

// 6. plugin states (the gotcha)
echo "[6] PLUGIN STATES (pixelyoursite + wp-mail-smtp should be OFF on staging, REACTIVATE on live):\n";
$active = (array) get_option('active_plugins');
foreach (array('pixelyoursite','wp-mail-smtp') as $needle) {
    $on = false; foreach ($active as $a) if (stripos($a, $needle) !== false) $on = true;
    echo "    $needle : " . ($on ? 'ACTIVE' : 'inactive (reactivate after push)') . "\n";
}
echo "\n";

// 7. perfmatters form exclusions present
echo "[7] PERFMATTERS FORM LAZYLOAD EXCLUSIONS (must include uploads/forms/):\n";
$o = get_option('perfmatters_options');
$ex = $o['lazyload']['lazy_loading_exclusions'] ?? array();
$has = is_array($ex) && in_array('uploads/forms/', $ex, true);
echo "    => " . ($has ? 'PRESENT (forms safe on mobile)' : 'MISSING — re-run exclusion fix') . "\n\n";

// 8. n8n webhook references in forms (sanity — should be benchmarkwebd)
echo "[8] FORM WEBHOOKS (all should point to benchmarkwebd.app.n8n.cloud):\n";
$dir = WP_CONTENT_DIR . '/uploads/forms';
foreach (glob($dir . '/*.html') as $f) {
    $c = file_get_contents($f);
    if (preg_match('/WEBHOOK_URL\s*=\s*"([^"]+)"/', $c, $m)) echo "    " . basename($f) . " -> " . $m[1] . "\n";
}
echo "\n===== END =====\n";
