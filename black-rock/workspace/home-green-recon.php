<?php
global $wpdb;
// 1. Force homepage readylabel green with !important
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=38");
$c2 = str_replace('.brm-home-final-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:80px 0 0;}',
                  '.brm-home-final-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5 !important;text-align:center;margin:80px 0 0;}', $c);
if ($c2 !== $c) { $wpdb->update($wpdb->posts, array('post_content'=>$c2), array('ID'=>38)); clean_post_cache(38); echo "homepage label -> #5dcaa5 !important\n"; }
else { echo "homepage label rule not matched (check)\n"; }

// 2. Recon: VA hero top
echo "\n=== VA (88) first 1600 chars ===\n";
$va = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=88");
echo substr($va, 0, 1600) . "\n";

echo "\n=== VA: wp:block refs in first 3000 chars (byline saved pattern?) ===\n";
preg_match_all('/<!-- wp:block \{"ref":(\d+)\} \/-->/', substr($va,0,3000), $m);
echo "refs: " . implode(',', $m[1]) . "\n";

// 3. Ocala hero top
echo "\n=== OCALA (67) first 1200 chars ===\n";
$oc = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=67");
echo substr($oc, 0, 1200) . "\n";
