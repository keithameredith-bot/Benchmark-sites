<?php
$mods = get_option('theme_mods_kadence');
$html = $mods['footer_html_content'] ?? '';
echo "=== footer_html_content (".strlen($html)." bytes) ===\n";
echo $html . "\n\n";
echo "=== links in footer ===\n";
preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $html, $m, PREG_SET_ORDER);
foreach ($m as $a) echo "  '".trim(strip_tags($a[2]))."' -> ".$a[1]."\n";
echo "\n=== buttons/btn classes in footer ===\n";
if (preg_match_all('/class="([^"]*(?:btn|button)[^"]*)"/i', $html, $b)) foreach(array_unique($b[1]) as $cls) echo "  $cls\n";
