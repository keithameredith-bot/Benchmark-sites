<?php
global $wpdb;
foreach (array('mortgage-glossary','mortgage-faq','get-pre-approved') as $slug) {
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    $pid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    $h1 = preg_match_all('/<h1/', $c);
    $firstChars = substr(trim($c), 0, 120);
    echo str_pad($slug,20)." (id $pid) h1count:$h1 | starts: ".preg_replace('/\s+/',' ',$firstChars)."\n";
}
// author bio block image
$b = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=987514146");
echo "\n=== author bio (987514146) image markup ===\n";
if (preg_match('/<img[^>]*>/i', $b, $m)) echo $m[0]."\n";
if (preg_match('/<figure[^>]*>/i', $b, $m)) echo "figure: ".$m[0]."\n";
// is there a kadence image block with borderRadius?
if (preg_match('/wp:kadence\/image[^>]*-->/', $b, $m)) echo "kadence image block: ".substr($m[0],0,200)."\n";
if (preg_match('/wp:image[^>]*-->/', $b, $m)) echo "core image block: ".substr($m[0],0,200)."\n";
