<?php
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=56");
// find the accordion block opener
$a = strpos($c, 'wp:kadence/accordion');
echo "accordion attrs: " . substr($c, $a, 400) . "\n\n";
// find the LAST pane block (full)
$lastPaneStart = strrpos($c, '<!-- wp:kadence/pane');
$paneEnd = strpos($c, '<!-- /wp:kadence/pane -->', $lastPaneStart) + strlen('<!-- /wp:kadence/pane -->');
echo "=== last pane (" . ($paneEnd-$lastPaneStart) . " bytes) ===\n" . substr($c, $lastPaneStart, $paneEnd - $lastPaneStart) . "\n\n";
// what follows the last pane
echo "=== after last pane ===\n" . substr($c, $paneEnd, 200) . "\n";
