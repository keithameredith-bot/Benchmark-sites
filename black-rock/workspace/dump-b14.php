<?php
$b = get_option('widget_block');
$c = $b[14]['content'] ?? '';
// print lines containing button/cta/get-pre-approved
foreach (preg_split('/\n/', $c) as $line) {
    if (preg_match('/get-pre-approved|GET PRE|btn|cta|button/i', $line)) echo trim($line) . "\n";
}
