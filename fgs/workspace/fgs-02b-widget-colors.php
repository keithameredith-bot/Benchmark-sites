<?php
$opt = get_option("widget_block");
$apply = (bool) getenv("FGS_APPLY");
$map = ["#c8102e"=>"#c63a3a","#1a1a1a"=>"#2d2d2d","#f5f5f5"=>"#f3f3f3","#e8e8e3"=>"#f0e5e5"];
$changed = 0;
foreach ($opt as $k => $v) {
  if (is_array($v) && isset($v["content"])) {
    $new = str_ireplace(array_keys($map), array_values($map), $v["content"]);
    if ($new !== $v["content"]) {
      $n = 0; foreach ($map as $f=>$t) $n += substr_count(strtolower($v["content"]), $f);
      echo "widget_block[$k]: $n replacements\n";
      $opt[$k]["content"] = $new;
      $changed += $n;
    }
  }
}
if ($changed && $apply) { update_option("widget_block", $opt); echo "WRITTEN\n"; }
echo ($apply ? "applied" : "dry run") . ": $changed total\n";
