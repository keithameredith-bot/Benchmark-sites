<?php
$css = wp_get_custom_css();
echo "custom css len: " . strlen($css) . "\n";
// find brm-mcta + any border-radius:0 or square-ish buttons
foreach (array('brm-mcta','radius','button','btn') as $needle) {
    $off = 0; $n = 0;
    while (($p = stripos($css, $needle, $off)) !== false && $n < 8) {
        // print the enclosing rule
        $rs = strrpos(substr($css,0,$p), '}');
        $re = strpos($css, '}', $p);
        echo "--- [$needle] " . preg_replace('/\s+/',' ', substr($css, $rs+1, $re-$rs)) . "\n";
        $off = $re; $n++;
    }
}
