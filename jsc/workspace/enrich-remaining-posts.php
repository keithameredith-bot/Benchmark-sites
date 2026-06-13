<?php
/**
 * wp eval-file enrich-remaining-posts.php — same treatment as the dock cost post for the other 3
 * (+ Lake George): comparison tables from each post's OWN numbers, inline real photos, new barndo
 * featured image (102075). Idempotent (guards per edit).
 */
function jsc_patch( $id, $anchor, $insert, $label ) {
	$p = get_post( $id ); $c = $p->post_content;
	if ( false !== strpos( $c, $insert ) || false !== strpos( $c, substr( $insert, 0, 60 ) ) ) { echo "  skip $label (present)\n"; return; }
	if ( false === strpos( $c, $anchor ) ) { echo "  !! anchor missing for $label\n"; return; }
	$c = str_replace( $anchor, $insert . "\n" . $anchor, $c );
	wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $c ) ) );
	echo "  ok $label\n";
}
$tdh = 'style="padding:10px 12px;"';
$thr = 'style="background:#16191D;color:#fff;text-align:left;"';
$tbl = 'class="jsc-cost-table" style="width:100%;border-collapse:collapse;margin:8px 0 28px;font-size:15.5px;"';
$row = 'style="border-bottom:1px solid #e6e8ec;"';

echo "BARNDO 101875\n";
set_post_thumbnail( 101875, 102075 );
echo "  featured -> 102075 (Alachua build)\n";
jsc_patch( 101875, '<h2>The Florida-Specific Costs Nobody Warns You About</h2>',
'<table ' . $tbl . '><thead><tr ' . $thr . '><th ' . $tdh . '>Build Level</th><th ' . $tdh . '>Per Sq Ft</th><th ' . $tdh . '>2,000 Sq Ft Example</th></tr></thead><tbody>
<tr ' . $row . '><td ' . $tdh . '><strong>Basic</strong></td><td ' . $tdh . '>$115&ndash;$150</td><td ' . $tdh . '>$230,000&ndash;$300,000</td></tr>
<tr ' . $row . '><td ' . $tdh . '><strong>Mid-Range</strong></td><td ' . $tdh . '>$150&ndash;$195</td><td ' . $tdh . '>$300,000&ndash;$390,000</td></tr>
<tr><td ' . $tdh . '><strong>Premium</strong></td><td ' . $tdh . '>$195&ndash;$250+</td><td ' . $tdh . '>$390,000&ndash;$500,000+</td></tr>
</tbody></table>', 'build-level table' );

echo "FENCE 101890\n";
jsc_patch( 101890, '<h3>Wood &mdash; Pressure-Treated Pine</h3>',
'<table ' . $tbl . '><thead><tr ' . $thr . '><th ' . $tdh . '>Material</th><th ' . $tdh . '>Installed (per linear ft)</th><th ' . $tdh . '>Maintenance</th><th ' . $tdh . '>Best For</th></tr></thead><tbody>
<tr ' . $row . '><td ' . $tdh . '><strong>Pressure-Treated Pine</strong></td><td ' . $tdh . '>$18&ndash;$38</td><td ' . $tdh . '>Seal/stain every 2&ndash;3 yrs</td><td ' . $tdh . '>Privacy on a budget</td></tr>
<tr ' . $row . '><td ' . $tdh . '><strong>Vinyl / PVC</strong></td><td ' . $tdh . '>$20&ndash;$40 ($30&ndash;$55 equestrian)</td><td ' . $tdh . '>Hose it off</td><td ' . $tdh . '>Horse farms, low-maintenance privacy</td></tr>
<tr ' . $row . '><td ' . $tdh . '><strong>Chain Link</strong></td><td ' . $tdh . '>$7&ndash;$20</td><td ' . $tdh . '>Nearly none</td><td ' . $tdh . '>Boundaries, dog runs, ag enclosures</td></tr>
<tr><td ' . $tdh . '><strong>Aluminum</strong></td><td ' . $tdh . '>$25&ndash;$45</td><td ' . $tdh . '>None</td><td ' . $tdh . '>Pool barriers, decorative lines</td></tr>
</tbody></table>', 'materials table' );
jsc_patch( 101890, '<h2>How We Handle Fence Projects</h2>',
'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/02/four-board-fencing-with-lake-small.webp" alt="Four-board horse fencing with lake view installed by JSC in Central Florida" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">Four-board equestrian fencing on a Central Florida horse property — a real JSC job.</figcaption></figure>', 'horse fence photo' );

echo "SEAWALL 101827\n";
jsc_patch( 101827, '<h2>DIY Inspection vs. Calling a Pro</h2>',
'<h2>The 7 Signs at a Glance</h2>
<table ' . $tbl . '><thead><tr ' . $thr . '><th ' . $tdh . '>Warning Sign</th><th ' . $tdh . '>What It\'s Telling You</th><th ' . $tdh . '>Urgency</th></tr></thead><tbody>
<tr ' . $row . '><td ' . $tdh . '>Cracks wider than &frac14;"</td><td ' . $tdh . '>The wall is moving under stress</td><td ' . $tdh . '>Inspect soon</td></tr>
<tr ' . $row . '><td ' . $tdh . '>Soil washout / sinkholes behind the cap</td><td ' . $tdh . '>Water is actively pulling soil through the wall</td><td ' . $tdh . '><strong>Urgent</strong></td></tr>
<tr ' . $row . '><td ' . $tdh . '>Cap leaning toward the water</td><td ' . $tdh . '>The wall is failing</td><td ' . $tdh . '><strong>Urgent</strong></td></tr>
<tr ' . $row . '><td ' . $tdh . '>Blocked or missing weep holes</td><td ' . $tdh . '>Pressure is building behind the wall</td><td ' . $tdh . '>Maintenance now</td></tr>
<tr ' . $row . '><td ' . $tdh . '>Exposed or rusted rebar</td><td ' . $tdh . '>Corrosion is eating the structure</td><td ' . $tdh . '>Inspect soon</td></tr>
<tr ' . $row . '><td ' . $tdh . '>Separated panels / joint gaps</td><td ' . $tdh . '>The joints have let go</td><td ' . $tdh . '>Soon&ndash;urgent</td></tr>
<tr><td ' . $tdh . '>Damage to the dock or boathouse tied in</td><td ' . $tdh . '>Wall movement is transferring load</td><td ' . $tdh . '>Get it assessed</td></tr>
</tbody></table>', 'signs recap table' );

echo "LAKE GEORGE 102014\n";
jsc_patch( 102014, '<h2>How We Engineer Docks for High-Fetch Lakes</h2>',
'<table ' . $tbl . '><thead><tr ' . $thr . '><th ' . $tdh . ' colspan="2">Lake George at a Glance</th></tr></thead><tbody>
<tr ' . $row . '><td ' . $tdh . '>Size</td><td ' . $tdh . '>Florida\'s second-largest lake</td></tr>
<tr ' . $row . '><td ' . $tdh . '>Average dock length</td><td ' . $tdh . '>~800 feet (shallow water &mdash; you build to your boat\'s depth)</td></tr>
<tr ' . $row . '><td ' . $tdh . '>Typical project</td><td ' . $tdh . '>$150,000&ndash;$175,000 &mdash; see the <a href="/blog/dock-cost-central-florida-2026/">2026 dock cost guide</a></td></tr>
<tr><td ' . $tdh . '>Bottom</td><td ' . $tdh . '>Sand &mdash; friendly to pilings, unfriendly to short walkways</td></tr>
</tbody></table>', 'at-a-glance table' );
jsc_patch( 102014, '<h2>Boathouses on Lake George &mdash; Extra Engineering, Extra Protection</h2>',
'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/06/two-story-dock-with-viewing-deck.webp" alt="Two-story dock with viewing deck built by JSC" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">Built for open water — every photo on this page is a real JSC build.</figcaption></figure>', 'two-story photo' );
jsc_patch( 102014, '<h2>What Maintenance Looks Like on a Lake George Dock</h2>',
'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/01/dock-with-lights.webp" alt="Dock with lights built by JSC in Central Florida" loading="lazy" style="width:100%;border-radius:10px;"></figure>', 'lights photo' );
echo "DONE\n";
