<?php
// Menu: move Investor & Commercial directly under Agency & Government; add hotels + apartment buildings as their own lines.
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");

$invOld = '<div class="grp"><h3>Investor &amp; Commercial</h3><ul>
      <li>DSCR &mdash; incl. short-term rental</li><li>SBA loans (7a &amp; 504)</li><li>Multifamily, mixed-use &amp; hotels</li>
    </ul></div>';
$invNew = '<div class="grp"><h3>Investor &amp; Commercial</h3><ul>
      <li>DSCR &mdash; incl. short-term rental</li><li>SBA loans (7a &amp; 504)</li><li>Apartment buildings &amp; multifamily</li><li>Hotels &amp; hospitality</li><li>Mixed-use &amp; commercial property</li>
    </ul></div>';
if (strpos($c, $invOld) === false) { echo "investor group not found as expected\n"; return; }

// remove from current position
$c = str_replace($invOld, '', $c);
// insert right after the Agency & Government group
$agencyEnd = '<li>Down payment assistance &amp; Hometown Heroes</li>
    </ul></div>';
$c = str_replace($agencyEnd, $agencyEnd . "\n    " . $invNew, $c);

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "investor/commercial moved under agency+gov, hotels + apartments added\n";
