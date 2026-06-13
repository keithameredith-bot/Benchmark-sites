<?php
$p = get_post(90);
$c = $p->post_content;
$c = str_replace(".fgs-tm{padding:80px 24px;background:#f3f3f3}", ".fgs-tm{padding:80px 24px}", $c, $n1);
$c = str_replace(".fgs-tm__card{background:#ffffff;border-radius:16px;padding:36px 32px;position:relative}", ".fgs-tm__card{background:#f3f3f3;border:1px solid #e9e4e1;border-radius:16px;padding:36px 32px;position:relative}", $c, $n2);
if ($n1 || $n2) { wp_update_post(["ID"=>90, "post_content"=>wp_slash($c)], true); echo "swapped: section bg removed={$n1}, cards gray={$n2}\n"; }
else echo "already swapped\n";
