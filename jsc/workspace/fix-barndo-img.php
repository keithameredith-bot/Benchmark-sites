<?php
// Swap the AI steel-frame image for a REAL build photo (Keith: "ax this pic, it's AI crap").
$c = get_post( 101875 )->post_content;
if ( false === strpos( $c, 'barndominium-steel-frame' ) ) { echo "already gone\n"; return; }
// replace the whole figure: img src + alt; keep figcaption replaced with a real-jobs caption
$c = preg_replace(
	'/<figure style="text-align: center;">\s*<img\s+src="\/wp-content\/uploads\/2026\/04\/barndominium-steel-frame\.webp"[\s\S]*?<\/figure>/',
	'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/06/barndominium-backyard-garage-guest-suite.webp" alt="Backyard barndominium with garage and guest suite built by JSC" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">A real JSC barndominium build &mdash; garage and guest suite combo. No stock photos, no AI renders.</figcaption></figure>',
	$c, 1, $n
);
if ( ! $n ) { echo "regex did not match — inspect\n"; return; }
wp_update_post( array( 'ID' => 101875, 'post_content' => wp_slash( $c ) ) );
echo "swapped ($n)\n";
