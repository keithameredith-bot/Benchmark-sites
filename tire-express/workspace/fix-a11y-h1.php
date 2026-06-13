<?php
// Set the accessibility page content (the create-script ordering bug left it empty). Idempotent.
$p = get_page_by_path( 'accessibility' );
if ( ! $p ) { echo "ABORT: page missing\n"; exit; }
$content = '<!-- wp:html -->
<h1>Accessibility Statement</h1>
<h2>Our Commitment to Accessibility</h2>
<p>Tire Express and Complete Auto Service is committed to making our website usable by everyone, including people with disabilities. We aim to follow the Web Content Accessibility Guidelines (WCAG) 2.1, Level AA, and we review the site regularly to improve accessibility.</p>
<h2>Measures We Take</h2>
<ul>
<li>Descriptive alternative text on images</li>
<li>Sufficient color contrast and readable font sizes</li>
<li>Keyboard-navigable menus and content</li>
<li>Clear headings and page structure</li>
</ul>
<h2>Need Help or Found a Problem?</h2>
<p>If you have difficulty using any part of this website, or you spot an accessibility issue, please tell us — we will do our best to fix it promptly and to provide the information you need by phone or email in the meantime.</p>
<p><strong>Phone:</strong> <a href="tel:3524215650">(352) 421-5650</a><br><strong>Visit:</strong> 1708 E Silver Springs Blvd, Ocala, FL 34470</p>
<!-- /wp:html -->';
if ( strlen( $p->post_content ) > 200 ) { echo "content already present\n"; exit; }
wp_update_post( array( 'ID' => $p->ID, 'post_content' => wp_slash( $content ) ) );
echo "accessibility content set (" . strlen( $content ) . "B)\n";
