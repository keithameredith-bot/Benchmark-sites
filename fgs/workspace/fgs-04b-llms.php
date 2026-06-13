<?php
$o = json_decode(get_option("aioseo_options"), true);
if (!$o["sitemap"]["llms"]["enable"]) {
  $o["sitemap"]["llms"]["enable"] = true;
  update_option("aioseo_options", wp_json_encode($o));
  echo "llms.txt enabled\n";
} else echo "already enabled\n";
flush_rewrite_rules();
