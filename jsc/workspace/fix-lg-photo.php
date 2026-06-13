<?php
$c = get_post( 102014 )->post_content;
if ( false !== strpos( $c, 'dock-with-lights.webp" alt="Dock with lights' ) ) { echo "already in\n"; return; }
$anchor = '<h2>What Maintenance Looks Like on a Lake George Dock</h2>';
$c = str_replace( $anchor, '<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/01/dock-with-lights.webp" alt="Dock with lights built by JSC in Central Florida" loading="lazy" style="width:100%;border-radius:10px;"></figure>' . "\n" . $anchor, $c );
wp_update_post( array( 'ID' => 102014, 'post_content' => wp_slash( $c ) ) );
echo "lights photo added\n";
