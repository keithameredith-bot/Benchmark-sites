<?php
// Add Hard Money Loans group below Equity & Reverse.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'Hard Money Loans') !== false) { echo "already added\n"; return; }

$anchor = '<div class="grp"><h3>Equity &amp; Reverse</h3><ul>
      <li>HELOCs, HELOANs &amp; piggyback seconds</li><li>Reverse mortgages &mdash; HECM &amp; jumbo reverse</li>
    </ul></div>';
$new = $anchor . '
    <div class="grp"><h3>Hard Money Loans</h3><ul>
      <li>Use our network of hard money lenders</li><li>Bring your own</li>
    </ul></div>';
if (strpos($c, $anchor) === false) { echo "equity group not found\n"; return; }
$c = str_replace($anchor, $new, $c);
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "hard money group added\n";
