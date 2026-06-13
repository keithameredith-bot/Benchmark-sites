<?php
// pre-export cleanup: trash (recoverable) the leftover junk
$junk = [192 => "home ex", 246 => "Contact Example", 112 => "Privacy dup", 2 => "Hello world", 34 => "blog spam", 36 => "blog spam", 37 => "blog spam", 39 => "blog spam", 41 => "blog spam", 42 => "blog spam"];
foreach ($junk as $id => $what) {
  $p = get_post($id);
  if ($p && $p->post_status !== "trash") { wp_trash_post($id); echo "trashed {$id} ({$what})\n"; }
}
// staging must not be indexed; flip blog_public=1 ONLY at production launch
update_option("blog_public", 0);
echo "search engines discouraged (staging-safe; FLIP ON AT PRODUCTION LAUNCH)\n";
