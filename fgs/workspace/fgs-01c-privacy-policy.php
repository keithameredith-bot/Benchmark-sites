<?php
/**
 * fgs-01c-privacy-policy.php — Replace WP boilerplate privacy policy with a real one
 * and publish it. Targets page 6 (owns the privacy-policy slug). Page 112 (duplicate
 * draft, no slug) is left for Keith to delete.
 *
 * Idempotent: detects the boilerplate "Suggested text:" marker; if absent and the page
 * is already published, does nothing.
 * Usage: wp eval-file fgs-01c-privacy-policy.php
 */

$page_id = 6;
$post    = get_post( $page_id );
if ( ! $post ) {
	WP_CLI::error( "Page {$page_id} not found." );
}

$is_boilerplate = ( false !== strpos( $post->post_content, 'privacy-policy-tutorial' ) );
if ( ! $is_boilerplate && 'publish' === $post->post_status ) {
	WP_CLI::success( 'Privacy policy already real and published — nothing to do.' );
	return;
}

$content = <<<'HTML'
<!-- wp:paragraph -->
<p><em>Last updated: June 2026</em></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Florida Geotechnical Services ("FGS," "we," "us") operates this website. This policy explains what information we collect when you use the site, how we use it, and the choices you have.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Information we collect</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Information you send us.</strong> When you submit our contact or quote-request form, call, or email us, we receive the information you provide — typically your name, email address, phone number, project address, and a description of the work you need. We use it to respond to your inquiry, prepare proposals, and perform the services you request.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Information collected automatically.</strong> Like most websites, our hosting infrastructure keeps standard server logs (IP address, browser type, pages requested, timestamps) for security and troubleshooting. The site may also use cookies and similar technologies for basic functionality and aggregate analytics that help us understand how visitors use the site.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">How we use information</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>To respond to inquiries and provide quotes for geotechnical, testing, and engineering services</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>To perform contracted work, including scheduling field visits and delivering reports</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>To operate, secure, and improve this website</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>To comply with legal and professional-licensure obligations</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">What we don't do</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We do not sell your personal information. We do not share it with third parties except service providers who help us run the business (for example, our website host and email provider), professionals involved in your project at your direction, or where required by law.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Data retention</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Project records, including correspondence, are retained as required by Florida engineering-practice rules and our professional-liability obligations. Routine website inquiry data that does not become a project is retained only as long as needed to handle the inquiry.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Your choices</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>You may contact us at any time to ask what information we hold about you, request a correction, or request deletion of information we are not legally required to keep. Most browsers also let you block or delete cookies.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Contact</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Florida Geotechnical Services<br>302 SW 33rd Ave, Ocala, FL 34474<br>(352) 619-9292 · RTownsend@FGSFL.net</p>
<!-- /wp:paragraph -->
HTML;

$result = wp_update_post(
	array(
		'ID'           => $page_id,
		'post_content' => wp_slash( $content ),
		'post_status'  => 'publish',
		'post_title'   => 'Privacy Policy',
	),
	true
);
if ( is_wp_error( $result ) ) {
	WP_CLI::error( 'wp_update_post failed: ' . $result->get_error_message() );
}
WP_CLI::success( "Privacy policy (page {$page_id}) replaced and published." );
