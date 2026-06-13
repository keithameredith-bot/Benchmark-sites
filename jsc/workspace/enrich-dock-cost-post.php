<?php
/**
 * wp eval-file enrich-dock-cost-post.php — enrichment pass on the dock cost post (102199):
 * comparison table, 3 inline photos, materials/permits/repair sections, +1 FAQ. Also adds a
 * link from the Lake George post (102014). Idempotent-ish (guards).
 */
$id = 102199;
$c  = get_post( $id )->post_content;
if ( false !== strpos( $c, 'jsc-cost-table' ) ) { echo "already enriched\n"; } else {

// 1. inline photo after the $/sqft section
$c = str_replace(
	'<h2>Real Project Averages, Waterway by Waterway</h2>',
	'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/06/dock-with-railings.webp" alt="Dock with railings built by JSC in Central Florida" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">Every photo in this post is a real JSC build — no stock photos.</figcaption></figure>
<h2>Real Project Averages, Waterway by Waterway</h2>',
	$c
);

// 2. comparison table after the waterway bullets
$c = str_replace(
	'<h2>What\'s Actually Moving the Number</h2>',
	'<table class="jsc-cost-table" style="width:100%;border-collapse:collapse;margin:8px 0 28px;font-size:15.5px;">
<thead><tr style="background:#16191D;color:#fff;text-align:left;"><th style="padding:10px 12px;">Waterway</th><th style="padding:10px 12px;">Typical Length</th><th style="padding:10px 12px;">Bottom</th><th style="padding:10px 12px;">Average Project</th></tr></thead>
<tbody>
<tr style="border-bottom:1px solid #e6e8ec;"><td style="padding:10px 12px;"><strong>Rainbow River</strong></td><td style="padding:10px 12px;">Short walkways</td><td style="padding:10px 12px;">Deep near shore</td><td style="padding:10px 12px;">$35,000–$45,000</td></tr>
<tr style="border-bottom:1px solid #e6e8ec;"><td style="padding:10px 12px;"><strong>Lake Weir</strong></td><td style="padding:10px 12px;">~200 ft</td><td style="padding:10px 12px;">Sand (fast pilings)</td><td style="padding:10px 12px;">$75,000–$85,000 w/ boathouse</td></tr>
<tr style="border-bottom:1px solid #e6e8ec;"><td style="padding:10px 12px;"><strong>Lake George</strong></td><td style="padding:10px 12px;">~800 ft</td><td style="padding:10px 12px;">Sand, very shallow</td><td style="padding:10px 12px;">$150,000–$175,000</td></tr>
<tr><td style="padding:10px 12px;"><strong>Crystal River</strong></td><td style="padding:10px 12px;">Varies</td><td style="padding:10px 12px;">Rock &amp; clay (slow pilings)</td><td style="padding:10px 12px;">~$200,000</td></tr>
</tbody></table>
<h2>What\'s Actually Moving the Number</h2>',
	$c
);

// 3. boathouse/lift photo in the structure section
$c = str_replace(
	'<h2>How Paying for It Works</h2>',
	'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/06/boathouse-and-boat-lift.webp" alt="Boathouse with boat lift built by JSC Contracting" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">A boathouse and properly sized lift are the two biggest add-ons — and the two most worth doing right.</figcaption></figure>

<h2>Wood or Composite Decking?</h2>
<p>The classic budget fork. <strong>Pressure-treated wood</strong> costs less up front, feels cooler underfoot, and takes stain — but it wants sealing over time and can warp or splinter. <strong>Composite</strong> costs more up front and pays you back in near-zero maintenance, no splinters, and color that stays put. There\'s no wrong answer — it\'s a money-now versus money-later decision, and <a href="/central-florida-dock-builder/">we price your dock both ways</a> so you can choose with real numbers side by side.</p>

<h2>Permits and Timeline</h2>
<p>Dock work in Florida usually means construction and environmental permitting — and that\'s <strong>our job, not yours</strong>. We handle the paperwork and keep the build compliant from day one. Timeline depends on your location and what the pilings hit: sandy lakes like Weir, Kerr, and George move quickly, while the rock-and-clay rivers and coastal areas take more patience per piling. We\'ll give you a straight expectation before we start, not a guess.</p>

<h2>Repairing vs. Replacing an Existing Dock</h2>
<p>Not every tired dock needs to be torn out. Decking replacement, piling repairs, and storm damage are all <a href="/central-florida-dock-builder/">work we do regularly</a> — and with no minimum job size, "just fix the bad section" is a real option, not a brush-off. We\'ll walk your dock and tell you honestly which side of the repair-or-replace line it\'s on, and what each path costs.</p>

<h2>How Paying for It Works</h2>',
	$c
);

// 4. third photo near the close
$c = str_replace(
	'<h2>Get a Real Number for Your Shoreline</h2>',
	'<figure style="margin:28px 0;"><img src="/wp-content/uploads/2026/06/simple-dock-on-a-small-lake.webp" alt="Simple dock on a small Central Florida lake built by JSC" loading="lazy" style="width:100%;border-radius:10px;"><figcaption style="font-size:14px;color:#666;margin-top:6px;">Not every dock is an 800-foot Lake George run — simple builds are welcome too. No minimum job.</figcaption></figure>
<h2>Get a Real Number for Your Shoreline</h2>',
	$c
);

// 5. +1 visible FAQ (materials) + matching JSON-LD entry
$c = str_replace(
	'<h3>Do you handle the permits?</h3>',
	'<h3>Does composite decking cost more than wood?</h3>
<p>Up front, yes — composite carries a higher initial price, while pressure-treated wood is the budget-friendly start. Over the years the gap narrows: wood wants sealing and eventual board replacement, composite mostly wants nothing. We quote both so you can decide.</p>
<h3>Do you handle the permits?</h3>',
	$c
);
$c = str_replace(
	'{"@type":"Question","name":"Do you handle the permits?"',
	'{"@type":"Question","name":"Does composite decking cost more than wood?","acceptedAnswer":{"@type":"Answer","text":"Up front, yes - composite carries a higher initial price, while pressure-treated wood is the budget-friendly start. Over the years the gap narrows: wood wants sealing and eventual board replacement, composite mostly wants nothing. We quote both so you can decide."}},{"@type":"Question","name":"Do you handle the permits?"',
	$c
);

wp_update_post( array( 'ID' => $id, 'post_content' => wp_slash( $c ) ) );
echo "post enriched: " . strlen( $c ) . "B\n";
}

// 6. Lake George post -> link the cost guide
$lg = get_post( 102014 );
if ( false === strpos( $lg->post_content, 'dock-cost-central-florida-2026' ) ) {
	$add = '<p><strong>Wondering what a build like this costs?</strong> We published our real numbers — by lake — in the <a href="/blog/dock-cost-central-florida-2026/">2026 Central Florida dock cost guide</a>. Lake George has its own line.</p>' . "\n";
	$new = str_replace( '<!-- /wp:html -->', $add . '<!-- /wp:html -->', $lg->post_content );
	wp_update_post( array( 'ID' => 102014, 'post_content' => wp_slash( $new ) ) );
	echo "lake george post links the guide\n";
} else { echo "lake george already links\n"; }
