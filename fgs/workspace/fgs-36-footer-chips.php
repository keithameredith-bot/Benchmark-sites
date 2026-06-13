<?php
$opt = get_option("widget_block");
$c = $opt[20]["content"];
$c2 = str_replace(
  [
    ".fgs-footer-nap h4{color:#ee7c63;font-size:13px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin:0 0 12px 0}",
    ".fgs-footer-nap a:hover{color:#ee7c63}",
  ],
  [
    ".fgs-footer-nap h4{display:inline-block;background:#a91513;color:#ffffff;font-size:12px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase;margin:0 0 14px 0;padding:6px 14px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.25)}",
    ".fgs-footer-nap a:hover{color:#ffffff}",
  ],
  $c
);
if ($c2 !== $c) { $opt[20]["content"] = $c2; update_option("widget_block", $opt); echo "footer labels -> maroon chips, peach purged\n"; }
else echo "patterns not found — check\n";
