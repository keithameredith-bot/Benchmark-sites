<?php
/**
 * Rebuild about-us (91280), our-team (100816), core-values (101185) in Kadence.
 * Copy preserved from live; cleanups logged in PROJECT-STATUS. Run: wp eval-file build-info-pages.php
 */

function jsc_apply_page( $id, $content ) {
	$r = wp_update_post( array( 'ID' => $id, 'post_content' => $content ), true );
	if ( is_wp_error( $r ) ) { echo "ERR $id: " . $r->get_error_message() . "\n"; return; }
	update_post_meta( $id, '_kad_post_title', 'hide' );
	update_post_meta( $id, '_kad_post_layout', 'fullwidth' );
	update_post_meta( $id, '_kad_post_content_style', 'unboxed' );
	update_post_meta( $id, '_kad_post_vertical_padding', 'hide' );
	echo "OK $id (" . get_post_field( 'post_name', $id ) . ")\n";
}

function jsc_hero( $bg, $eyebrow, $h1, $sub ) {
	return '<!-- wp:html -->
<div class="jsc-hero jsc-hero-warm">
<div class="jsc-hero-bg" style="background-image:url(\'' . $bg . '\')"></div>
<div class="jsc-wrap">
<span class="jsc-eyebrow">' . $eyebrow . '</span>
<h1>' . $h1 . '</h1>
<p class="jsc-sub">' . $sub . '</p>
<div class="jsc-cta-row">
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
<a class="jsc-btn jsc-btn-ghost" href="tel:3526872030">CALL 352.687.2030</a>
</div>
</div>
</div>
<!-- /wp:html -->';
}

function jsc_cta_band( $noun = 'project' ) {
	return '<!-- wp:html -->
<div class="jsc-cta-band" id="appt">
<h2>Get Your Free Quote Today!</h2>
<p>Call <a class="jsc-tel" href="tel:3526872030">352.687.2030</a> or send us your project details online — we\'ll review your ' . $noun . ' and get you a free price quote.</p>
<a class="jsc-btn jsc-btn-gold" href="/get-a-free-quote/">GET A FREE QUOTE</a>
</div>
<!-- /wp:html -->';
}

// "Why Choose Us" features — titles from live, blurbs from live ("We knows" → "We know" fixed).
function jsc_features_section() {
	$features = array(
		array( '100% Satisfaction', 'Our goal is always 100% customer satisfaction. We want to exceed your expectations, not just meet them.' ),
		array( 'Upfront Pricing', 'We know clients don\'t like surprises when it comes to the cost of a job. Our quotes are clear, transparent, and we hold to them.' ),
		array( 'Dedication', 'Our company culture breeds an environment of excellence. You can expect dedication to your job from start to finish.' ),
		array( 'Turn Times', 'When we give an estimate for the completion of your project, we do everything we can to stick to that goal.' ),
		array( 'Quality Workmanship', 'Our project managers and skilled laborers are relentlessly dedicated to getting the job done right no matter the project.' ),
		array( 'Safety Commitment', 'We aim to always make sure our job site is secure, clean, and safe.' ),
	);
	$cards = '';
	foreach ( $features as $f ) {
		$cards .= '<div class="jsc-feature"><h3>' . $f[0] . '</h3><p>' . $f[1] . '</p></div>' . "\n";
	}
	return '<!-- wp:group {"tagName":"section","className":"jsc-section jsc-warm"} -->
<section class="wp-block-group jsc-section jsc-warm"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<p class="jsc-kicker">You Dream It, We Build It</p>
<h2>Why Choose Us</h2>
<div class="jsc-features">
' . $cards . '</div>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->';
}

/* ============================== ABOUT US ============================== */
$about = jsc_hero( '/wp-content/uploads/2026/06/jsc-home-hero-montage.webp', 'Our Story', 'About us',
	'From a one-man marine construction operation to a 50-person team building across Florida.' );

$about .= '

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:columns {"className":"jsc-two-col"} -->
<div class="wp-block-columns jsc-two-col"><!-- wp:column {"width":"60%","className":"jsc-copy-col"} -->
<div class="wp-block-column jsc-copy-col" style="flex-basis:60%"><!-- wp:html -->
<p class="jsc-kicker">Welcome</p>
<h2>How It All Started</h2>
<p><strong>JSC Contracting was founded by Alex Scanlan</strong> in July of 2018 after he successfully acquired Labagh Marine, a company started in 1984. <strong>He quickly accelerated the growth of JSC</strong> covering more territory, and broadening the services of the company.</p>
<p>Expanding the <a href="/our-team/">JSC team</a> with experienced project managers and sales staff allowed for the expansion of the services provided. Not only is JSC the <strong>premier <a href="/central-florida-dock-builder/">marine construction</a> company in central Florida.</strong> They now consistently construct <a href="/barndominium-builders-in-florida/">barndominiums</a>, <a href="/pole-barn-builder/">pole barns</a>, new construction custom homes, and more for our central Florida neighbors. Outdoor kitchens, <a href="/boathouse-builder/">boat houses</a>, <a href="/home-remodeling-central-florida/">remodels</a>, <a href="/seawall-construction-and-repair/">seawalls</a>, <a href="/central-florida-fence-builder/">new fencing</a>, are all a part of their portfolio of work.</p>
<h3>Quality Workmanship</h3>
<p>JSC wouldn\'t have come as far as they have if they sacrificed quality workmanship for growth. They pride themselves on making sure the job is done right, and aim to exceed client expectations.</p>
<p><strong>Combining quality work with a commitment to transparent pricing has made many of their past clients loyal repeat clients.</strong></p>
<p>They have created a company atmosphere of excellence and a "can do" attitude. This inspires everyone on the job site from management on down to operate with excellence on your project.</p>
<h3>Results Driven</h3>
<p>The job isn\'t done until the client is satisfied. <strong>JSC operates not only on a time driven scale, but a client satisfaction scale.</strong> It\'s not just about getting done, it\'s about getting the job done right. It\'s part of our <a href="/core-values/">core values</a>. We walk through every project with our clients making sure every detail meets or exceeds their expectations.</p>
<p>They are ready to help you get your dreams accomplished. <strong>Reach out today to take the first steps.</strong></p>
<h3>A Note From the Founder of JSC Contracting Inc</h3>
<p>"When I started JSC contracting we quickly grew because we always aimed to exceed client expectations. That same philosophy hasn\'t changed. <strong>It\'s the heartbeat of our company.</strong></p>
<p>We would be honored if you trusted us with your next project."</p>
<p><strong>Alex Scanlan — Owner</strong></p>
<img class="jsc-sig" src="/wp-content/uploads/2026/02/alex-sig-small-2-final.png" alt="Alex Scanlan signature" loading="lazy">
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%","className":"jsc-side-col"} -->
<div class="wp-block-column is-vertically-aligned-center jsc-side-col" style="flex-basis:40%"><!-- wp:html -->
<div class="jsc-founder-img"><img src="/wp-content/uploads/2026/02/alex-left-transparent.png" alt="Alex Scanlan, owner of JSC Contracting Inc" loading="lazy"></div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

' . jsc_features_section() . '

' . jsc_cta_band();

jsc_apply_page( 91280, $about );

// about-us was missing a meta description (baseline issue #5)
global $wpdb;
$wpdb->update( $wpdb->prefix . 'aioseo_posts',
	array( 'description' => 'JSC Contracting was founded in 2018 on marine construction roots going back to 1984. Meet the central Florida builder behind docks, barndominiums, homes and more.' ),
	array( 'post_id' => 91280 ) );
echo "about-us meta description set\n";

/* ============================== OUR TEAM ============================== */
$members = array(
	array( 'Alex Scanlan', 'Owner-President', '/wp-content/uploads/2026/02/alex-400.webp',
		'Alex started JSC Contracting Inc. as a one-person operation and has grown the company to a team of over 50 skilled professionals. He leads with a focus on quality, integrity, and long-term client relationships, setting the vision for the company and overseeing operations, financial performance, and project teams. By maintaining high industry and safety standards and ensuring every client receives exceptional service, he has built a strong company culture and a reputation for excellence that continues to drive growth and success.' ),
	array( 'Cory Calano', 'Office Manager', '/wp-content/uploads/2026/02/0CABB18F-6910-4451-BA72-B2C16E68072A-1.jpg',
		'Cory keeps projects organized and running smoothly by maintaining accurate records, preparing and processing contracts, and tracking key project documentation. She also coordinates communication between teams, assists with scheduling, supports billing and compliance tasks, and ensures all paperwork is complete and up to date. Her attention to detail helps keep operations efficient and projects moving forward without delays.' ),
	array( 'Felicia Craig', 'Assistant Office Manager', '/wp-content/uploads/2026/02/IMG_5814-2-2.jpeg',
		'Felicia is the permit specialist, responsible for coordinating and tracking permits, preparing and submitting applications, and ensuring all projects stay compliant with local regulations and timelines. She communicates with municipalities, inspectors, and project managers, maintains records, and helps keep schedules on track. In addition to supporting daily office operations, she manages the JSC social media presence along with other marketing initiatives.' ),
	array( 'Steve Brown', 'New Construction and Remodel Manager-VP', '/wp-content/uploads/2026/02/john-small.webp',
		'With over 10 years of experience running his own successful remodeling business, Steve brings deep industry knowledge, sales insight, and hands-on expertise to every project. As the head of our new construction and home remodel division, he oversees project planning, budgeting, scheduling, and quality control, and works closely with clients during the sales process — helping them shape their vision, understand options, and feel confident in their investment. His real-world experience ensures each project is managed efficiently, built to high standards, and delivered with the craftsmanship our customers expect.' ),
	array( 'John DeVries', 'Architectural Design and Planning', '/wp-content/uploads/2026/02/john-400.webp',
		'John is responsible for turning ideas into functional, buildable plans — developing layouts, preparing drawings and specifications, coordinating with engineers and project teams, and ensuring designs meet building codes, zoning requirements, and client goals. He balances creativity with practicality, helping guide projects from concept through planning so construction can move forward smoothly and efficiently.' ),
	array( 'Chris Lanc', 'Project Manager', '/wp-content/uploads/2026/02/chris.webp',
		'Chris oversees projects from start to finish, ensuring they stay on schedule, within budget, and meet quality standards. He coordinates crews and subcontractors, manages timelines and material orders, monitors safety and compliance, and serves as the main point of contact for clients. By keeping communication clear and operations organized, he helps ensure each project runs efficiently and is completed successfully.' ),
	array( 'Alex Rosa', 'Project Manager', '/wp-content/uploads/2026/02/rosa-400.webp',
		'Alex brings valuable insight from his previous experience as a home inspector, giving him a sharp eye for detail and quality. In his role, he oversees project timelines, coordinates crews and subcontractors, monitors workmanship, and ensures every phase meets code and company standards. His background helps him anticipate potential issues early, keeping projects running smoothly while delivering the level of craftsmanship our clients expect.' ),
);
$cards = '';
foreach ( $members as $m ) {
	$cards .= '<div class="jsc-team-card"><img src="' . $m[2] . '" alt="' . esc_attr( $m[0] . ', ' . $m[1] . ' at JSC Contracting' ) . '" loading="lazy"><div class="jsc-team-info"><h3>' . $m[0] . '</h3><span class="jsc-team-role">' . $m[1] . '</span><p>' . $m[3] . '</p></div></div>' . "\n";
}

$team = jsc_hero( '/wp-content/uploads/2026/06/jsc-home-hero-montage.webp', 'Meet The Team', 'JSC Contracting Management Team',
	'The people who make sure your project gets done right — from first call to final walkthrough.' );
$team .= '

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<div class="jsc-team-grid">
' . $cards . '</div>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

' . jsc_features_section() . '

' . jsc_cta_band();

jsc_apply_page( 100816, $team );

/* ============================== CORE VALUES ============================== */
$values = array(
	array( 'C', 'Consistency', 'Our skilled tradespeople let the work speak for itself. We don\'t rush. Every cut, every connection, every finish gets the attention to detail it deserves — because your project does too.', array( 'Skilled Labor', 'Work Speaks for Itself', 'Attention to Detail' ) ),
	array( 'O', 'Organization', 'A well-run job site starts with preparation. Our crews arrive with the right tools, the right materials, and a clear plan. Communication keeps everything moving from day one to final walkthrough.', array( 'Prepared Crews', 'Clear Communication', 'Staying on Task' ) ),
	array( 'N', 'Neat', 'Professionalism is visible. Our trucks are clean, our crews wear matching uniforms, and our job sites stay orderly. When JSC shows up, you know you hired the right team.', array( 'Clean Job Sites', 'Professional Appearance', 'Presentable Crews' ) ),
	array( 'Q', 'Quality', 'We use the best tools and the best materials — and we take zero shortcuts. A clean, well-managed job site is a reflection of the quality you\'ll see in the finished product.', array( 'Premium Materials', 'Zero Shortcuts', 'Clean Job Site' ) ),
	array( 'U', 'Unity', 'All for one and one for all. Our teams come together, support each other, and do whatever it takes to deliver for you. We build each other up — and that\'s how we build your project right.', array( 'Teamwork', 'Whatever It Takes', 'Build Each Other Up' ) ),
	array( 'E', 'Environment', 'We cultivate a family-oriented culture that\'s headstrong, positive, and productive. No negativity, no excuses — just a team that shows up with the right mindset every day.', array( 'Family Culture', 'Headstrong', 'Zero Negativity' ) ),
	array( 'R', 'Reliability', 'We show up on time. We finish what we start. We follow through on every commitment. When JSC says we\'ll do something, consider it done.', array( 'On Time', 'Follow Through', 'Do What We Say' ) ),
);
$vcards = '';
foreach ( $values as $v ) {
	$pills = '';
	foreach ( $v[3] as $p ) { $pills .= '<span>' . $p . '</span>'; }
	$vcards .= '<div class="jsc-value-card"><div class="jsc-value-top"><h3>' . $v[1] . '</h3><div class="jsc-value-letter">' . $v[0] . '</div></div><p>' . $v[2] . '</p><div class="jsc-value-pills">' . $pills . '</div></div>' . "\n";
}

$cv = jsc_hero( '/wp-content/uploads/2026/06/jsc-home-hero-montage.webp', 'What Drives Us', 'Our Core Values',
	'C.O.N.Q.U.E.R. — the standard every JSC team member operates by, on every job site, every single day.' );
$cv .= '

<!-- wp:group {"tagName":"section","className":"jsc-section"} -->
<section class="wp-block-group jsc-section"><!-- wp:group {"className":"jsc-wrap"} -->
<div class="wp-block-group jsc-wrap"><!-- wp:html -->
<div class="jsc-conquer-head">
<h2 class="jsc-conquer-title">CONQUER</h2>
<div class="jsc-acronym-line"><strong>C</strong>onsistency · <strong>O</strong>rganization · <strong>N</strong>eat · <strong>Q</strong>uality · <strong>U</strong>nity · <strong>E</strong>nvironment · <strong>R</strong>eliability</div>
<p class="jsc-conquer-intro">Our core values aren\'t words on a wall — they\'re the standard every JSC team member operates by, on every job site, every single day. It\'s why you get the same level of quality whether it\'s your dock, your barn, or your dream home.</p>
</div>
<div class="jsc-value-cards">
' . $vcards . '</div>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

' . jsc_cta_band();

jsc_apply_page( 101185, $cv );

echo "DONE\n";
