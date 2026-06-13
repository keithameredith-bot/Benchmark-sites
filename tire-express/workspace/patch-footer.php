<?php
/**
 * wp eval-file patch-footer.php — add Tire Repair / Battery Replacement / Fleet Accounts to the footer
 * services list (lives in the block-widgets option). Idempotent.
 */
$widgets = get_option( 'widget_block' );
if ( ! is_array( $widgets ) ) { echo "ABORT: widget_block not an array\n"; exit; }
$changed = false;
foreach ( $widgets as $k => $w ) {
	if ( ! is_array( $w ) || empty( $w['content'] ) || false === strpos( $w['content'], 'used-tires-ocala' ) ) { continue; }
	$c = $w['content'];
	echo "found footer services widget at index $k\n";
	// Tire Repair after Used Tires
	if ( false === strpos( $c, '/tire-repair-ocala/' ) ) {
		$c = str_replace(
			'<li><a href="/used-tires-ocala/">Used Tires</a></li>',
			'<li><a href="/used-tires-ocala/">Used Tires</a></li><li><a href="/tire-repair-ocala/">Tire Repair</a></li>',
			$c, $n1
		);
		echo "tire repair inserted: $n1\n"; $changed = $changed || $n1;
	}
	// Get Directions link after the email link (site-wide footer)
	if ( false === strpos( $c, 'maps.google.com/?cid=14203459939532349517' ) && false !== strpos( $c, 'mailto:tireexpressocala@gmail.com' ) ) {
		$c = preg_replace(
			'/(<a href="mailto:tireexpressocala@gmail\.com"[^>]*>[^<]*<\/a>)/',
			'$1<br><a href="https://maps.google.com/?cid=14203459939532349517" target="_blank" rel="noopener">Get Directions &rarr;</a>',
			$c, 1, $n3
		);
		echo "footer directions inserted: $n3\n"; $changed = $changed || $n3;
	}
	// Battery + Fleet after A/C Recharge
	if ( false === strpos( $c, '/battery-replacement-in-ocala/' ) ) {
		$c = str_replace(
			'<li><a href="/car-air-conditioning-recharge/">A/C Recharge</a></li>',
			'<li><a href="/car-air-conditioning-recharge/">A/C Recharge</a></li><li><a href="/battery-replacement-in-ocala/">Battery Replacement</a></li><li><a href="/fleet-maintenance-in-ocala/">Fleet Accounts</a></li>',
			$c, $n2
		);
		echo "battery+fleet inserted: $n2\n"; $changed = $changed || $n2;
	}
	$widgets[ $k ]['content'] = $c;
}
if ( $changed ) {
	update_option( 'widget_block', $widgets );
	echo "footer updated\n";
} else {
	echo "no changes (already present or markup mismatch — inspect manually)\n";
}
