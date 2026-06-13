<?php
/**
 * FGS-style flare for the 3 blog posts: TLDR answer box up top, scannable table,
 * mid-post CTA band, FAQ section. Styles live in the mu-plugin. Idempotent
 * (skips any post already containing te-blog-tldr). Run: wp eval-file enrich-te-posts.php
 */

$CTA = '<div class="te-blog-cta"><h3>%s</h3><p>%s</p><a class="te-blog-cta-btn" href="tel:3524215650">CALL (352) 421-5650</a><span class="te-blog-cta-or">or just drive in — 1708 E Silver Springs Blvd, Mon&ndash;Fri 8&ndash;5 · <a href="https://maps.app.goo.gl/hyXfv8joJf53wEgaA" target="_blank" rel="noopener">Get Directions</a></span></div>';

$posts = array(

	// ---- Florida heat / 7 warning signs ----
	227830 => array(
		'tldr' => '<div class="te-blog-tldr"><span class="te-blog-label">THE QUICK ANSWER</span><p>Ocala pavement runs <strong>140&deg;F+ all summer</strong>, and Florida heat ages tires <strong>30&ndash;40% faster</strong> than up north. Check seven things before the heat peaks: sidewall cracks, bulges, tread under 4/32", uneven wear, highway vibration, a TPMS light that keeps returning, and any tire older than six years. Not sure what you\'re looking at? Our <strong>free tire inspection</strong> covers all seven in 20&ndash;30 minutes while you wait.</p></div>
<table class="te-blog-table"><thead><tr><th>Warning sign</th><th>What it means</th><th>What to do</th></tr></thead><tbody>
<tr><td>Sidewall cracks (dry rot)</td><td>UV + heat broke down the rubber</td><td>Replace — dry rot can\'t be repaired</td></tr>
<tr><td>Bulge or bubble</td><td>Internal cords separated</td><td>Stop driving on it — replace now</td></tr>
<tr><td>Tread under 4/32"</td><td>Hydroplane risk in FL downpours</td><td>Replace before storm season</td></tr>
<tr><td>Uneven / cupped wear</td><td>Alignment, balance, or suspension</td><td>Alignment check + rotation</td></tr>
<tr><td>Vibration at 50&ndash;70 mph</td><td>Balance, belt separation, or bent wheel</td><td>Get it inspected</td></tr>
<tr><td>TPMS light keeps returning</td><td>Slow leak, valve stem, or porous wheel</td><td>Tire repair — don\'t keep topping off</td></tr>
<tr><td>DOT date over 6 years old</td><td>Rubber compounds aged out</td><td>Replace regardless of tread</td></tr>
</tbody></table>',
		'cta_before' => '<h2>What an Ocala Summer Tire Check Should Include</h2>',
		'cta_head'   => 'See any of these signs on your tires?',
		'cta_text'   => 'Drive in for a free inspection — we\'ll measure the tread, read the date codes, and tell you honestly whether they\'ve got another season.',
		'faq_before' => '<h2>Need Tires or a Free Inspection in Ocala?</h2>',
		'faq' => '<h2>Frequently Asked Questions</h2>
<h3>Can dry-rotted tires be repaired?</h3>
<p>No. Once the rubber starts cracking, the damage runs deeper than the surface and only gets worse in the heat. Repairs are for punctures in the tread area of a healthy tire — dry rot means replacement. If new tires aren\'t in the budget right now, ask about our <a href="/used-tires-ocala/">inspected used tires</a> with out-the-door pricing.</p>
<h3>How do I read the DOT date code?</h3>
<p>Find "DOT" on the sidewall and look at the last four digits of the code that follows. The first two are the week, the last two the year — "3522" means the 35th week of 2022. In Florida, six years is the practical limit no matter how the tread looks.</p>
<h3>Is the penny test good enough in Florida?</h3>
<p>It tells you when a tire is legally worn out at 2/32" — but Florida\'s daily summer thunderstorms make anything under 4/32" a hydroplaning risk. Use a quarter instead: if the tread doesn\'t reach Washington\'s head, start shopping.</p>
<h3>Are used tires safe in Florida heat?</h3>
<p>They can be — if somebody actually checked them. Every used tire we sell gets a tread, age, and repair-history inspection before it goes on the rack, and the price you see is <a href="/used-tires-ocala/">out the door</a>.</p>',
	),

	// ---- Car A/C not blowing cold ----
	227099 => array(
		'tldr' => '<div class="te-blog-tldr"><span class="te-blog-label">THE QUICK ANSWER</span><p>The most common reason a car A/C stops blowing cold is <strong>low refrigerant</strong> — and an <a href="/car-air-conditioning-recharge/">A/C recharge</a> often fixes it the same day. If it keeps losing its cool after a recharge, you\'ve got a leak. Beyond that, the usual suspects are a failing compressor, a clogged cabin air filter, a blocked condenser, or an electrical fault. Here\'s how to tell which one you\'re dealing with.</p></div>
<table class="te-blog-table"><thead><tr><th>Symptom</th><th>Most likely cause</th><th>Typical fix</th></tr></thead><tbody>
<tr><td>Blows warm, everything else works</td><td>Low refrigerant</td><td>Recharge</td></tr>
<tr><td>Was cold, slowly got worse — recharge didn\'t hold</td><td>Refrigerant leak</td><td>Leak test, then repair + recharge</td></tr>
<tr><td>Air is cold but airflow is weak</td><td>Clogged cabin air filter</td><td>Filter swap — cheap and fast</td></tr>
<tr><td>Clicking / rattling when A/C kicks on</td><td>Compressor or clutch</td><td>Diagnosis before anything else</td></tr>
<tr><td>Nothing happens at all</td><td>Fuse, relay, or wiring</td><td>Electrical diagnosis</td></tr>
</tbody></table>',
		'cta_before' => '<h2>Why Florida Is Especially Hard on Car AC Systems</h2>',
		'cta_head'   => 'Sweating it out at every red light?',
		'cta_text'   => 'Most A/C jobs are diagnosed and fixed the same day — no appointment needed.',
		'faq_before' => '<h2>Get Your AC Fixed in Ocala Today</h2>',
		'faq' => '<h2>Frequently Asked Questions</h2>
<h3>How long does an A/C recharge take?</h3>
<p>Usually under an hour — most folks are in and out the same visit. We check the system pressure first so you\'re only paying for what it actually needs.</p>
<h3>Why is my A/C cold in the morning but warm by afternoon?</h3>
<p>That\'s the classic sign of a marginally low system. When it\'s cooler out, the refrigerant you have left can keep up; under full Florida afternoon load, it can\'t. It will only get worse — and it usually means a slow leak.</p>
<h3>Can I just use a DIY recharge can?</h3>
<p>You can, but it\'s a gamble. Without gauges you don\'t know if you\'re undercharging or overcharging — and overcharging can damage the compressor, turning a cheap fix into an expensive one. Many DIY cans also include stop-leak sealer that can clog the system.</p>
<h3>Does running the A/C hurt my gas mileage?</h3>
<p>A little — the compressor takes engine power to run. But a healthy system costs you far less than the drag of a failing one constantly cycling, and in Florida the comfort math settles itself.</p>',
	),

	// ---- Tire rotation ----
	227048 => array(
		'tldr' => '<div class="te-blog-tldr"><span class="te-blog-label">THE QUICK ANSWER</span><p>Rotate your tires about <strong>every 5,000&ndash;7,500 miles — basically every oil change</strong>. It\'s the cheapest way to make a set of tires last, because front and rear tires wear differently and rotation evens it out. At Tire Express every <a href="/tire-balancing-and-rotation/">rotation includes a balance check</a>, and you can be in and out — no appointment needed.</p></div>',
		'table_after' => '<h2>How Often Should I <a href="/tire-balancing-and-rotation/">Rotate My Tires in Ocala?</a></h2>',
		'table' => '<table class="te-blog-table"><thead><tr><th>Your drivetrain</th><th>Rotation pattern we typically use</th></tr></thead><tbody>
<tr><td>Front-wheel drive</td><td>Forward cross — rears cross to the front, fronts go straight back</td></tr>
<tr><td>Rear / four-wheel drive</td><td>Rearward cross — fronts cross to the rear, rears come straight forward</td></tr>
<tr><td>Directional or staggered tires</td><td>Front-to-back on the same side (direction arrows have to keep pointing forward)</td></tr>
</tbody></table>
<p>Don\'t worry about memorizing it — we check what your vehicle and tires call for and use the right pattern every time.</p>',
		'cta_before' => '<h2>Tire Rotation Made Easy in Ocala</h2>',
		'cta_head'   => 'Due for a rotation?',
		'cta_text'   => 'In and out, balance check included. Pair it with an oil change and knock out both at once.',
		'faq_append' => '<h2>Frequently Asked Questions</h2>
<h3>How long does a tire rotation take?</h3>
<p>About 15&ndash;20 minutes once your vehicle is on the lift. It\'s a wait-for-it service — bring a coffee.</p>
<h3>Do I need an appointment?</h3>
<p>No — just drive in. If you\'d rather lock in a time, give us a call and we\'ll have a bay ready.</p>
<h3>Why does the rotation include a balance check?</h3>
<p>Because the two problems show up together. Tires that have been on the same corner for thousands of miles often develop slight imbalance, and catching it during rotation is free insurance against highway vibration and cupped wear.</p>
<h3>What happens if I never rotate my tires?</h3>
<p>The drive tires wear out way ahead of the others — so instead of replacing four tires once, you\'re replacing two tires twice. Uneven wear also gets loud, hurts wet grip, and can mask alignment problems until they\'ve eaten real tread.</p>',
	),
);

foreach ( $posts as $id => $cfg ) {
	$c = get_post_field( 'post_content', $id );
	if ( ! $c ) { echo "SKIP $id: no content\n"; continue; }
	if ( false !== strpos( $c, 'te-blog-tldr' ) ) { echo "SKIP $id: already enriched\n"; continue; }

	// TLDR (+ cheat-sheet table where bundled) goes right after the wp:html opener
	$c = preg_replace( '/<!-- wp:html -->\s*/', "<!-- wp:html -->\n" . $cfg['tldr'] . "\n", $c, 1 );

	// standalone table placement (rotation post)
	if ( isset( $cfg['table_after'] ) ) {
		$pos = strpos( $c, $cfg['table_after'] );
		if ( false !== $pos ) {
			$end = strpos( $c, '<h2>', $pos + strlen( $cfg['table_after'] ) );
			if ( false === $end ) { $end = strpos( $c, '<!-- /wp:html -->' ); }
			$c = substr_replace( $c, "\n" . $cfg['table'] . "\n", $end, 0 );
		} else { echo "WARN $id: table anchor not found\n"; }
	}

	// mid-post CTA band
	$cta = sprintf( $CTA, $cfg['cta_head'], $cfg['cta_text'] );
	$pos = strpos( $c, $cfg['cta_before'] );
	if ( false !== $pos ) {
		$c = substr_replace( $c, $cta . "\n", $pos, 0 );
	} else { echo "WARN $id: CTA anchor not found\n"; }

	// FAQ section
	if ( isset( $cfg['faq_before'] ) ) {
		$pos = strpos( $c, $cfg['faq_before'] );
		if ( false !== $pos ) {
			$c = substr_replace( $c, $cfg['faq'] . "\n", $pos, 0 );
		} else { echo "WARN $id: FAQ anchor not found\n"; }
	} elseif ( isset( $cfg['faq_append'] ) ) {
		$pos = strpos( $c, '<p><strong>Call us at' );
		if ( false === $pos ) { $pos = strpos( $c, '<!-- /wp:html -->' ); }
		$c = substr_replace( $c, $cfg['faq_append'] . "\n", $pos, 0 );
	}

	// rotation post: align the mileage claim with the rest of the site
	$c = str_replace( 'roughly every 3,000 to 8,000 miles, or every 6 months', 'roughly every 5,000 to 7,500 miles, or every six months', $c );

	$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $c ) ), true );
	echo is_wp_error( $r ) ? "ERR $id: " . $r->get_error_message() . "\n" : "enriched $id\n";
}
echo "done\n";
