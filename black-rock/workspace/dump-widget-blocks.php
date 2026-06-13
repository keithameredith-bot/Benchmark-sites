<?php
$blocks = get_option('widget_block');
foreach (array(11,12,13,14,16) as $k) {
    echo "===== widget_block[$k] =====\n" . ($blocks[$k]['content'] ?? '(none)') . "\n\n";
}
