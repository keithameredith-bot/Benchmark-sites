<?php
// Map the order of blocks at the end of the mfg hub (607).
global $wpdb;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=607");
$markers = array(
  'old No-Hassle CTA' => 'Get a No-Hassle Manufactured Home Pre-Approval',
  'old No Hassle alt' => 'Get a No Hassle Manufactured Home Pre-Approval',
  'Related Reading' => 'brm-related-florida-mobile-home-financing',
  'Dunnellon story' => 'brm-story-dunnellon',
  'Neighborhoods box' => 'brm-mfg-hoods',
  'Engineer box' => 'brm-mfg-engineer',
  'Custom form CTA' => 'brm-prog-cta',
  'Apply Now button' => '>Apply Now<',
  'Call Keith button' => 'Call Keith: 352-619-4959',
);
$pos = array();
foreach ($markers as $name => $m) { $p = strpos($c, $m); if ($p !== false) $pos[$name] = $p; }
asort($pos);
echo "block order by position (content len " . strlen($c) . "):\n";
foreach ($pos as $n => $p) echo sprintf("  %8d  %s\n", $p, $n);
