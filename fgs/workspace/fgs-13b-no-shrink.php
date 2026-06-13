<?php
$changed = [];
foreach (["header_sticky_shrink", "mobile_header_sticky_shrink"] as $k) {
  if (true === get_theme_mod($k)) { set_theme_mod($k, false); $changed[] = $k; }
}
echo $changed ? "disabled: " . implode(", ", $changed) . "\n" : "already disabled\n";
