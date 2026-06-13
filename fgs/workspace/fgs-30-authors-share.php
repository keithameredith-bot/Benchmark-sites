<?php
/**
 * fgs-30-authors-share.php — Keith 2026-06-12:
 * 1. Author users: Dave Cappa, P.E. (engineering-advice posts) + Ryan Townsend
 *    (practical/cost posts). 587 sinkhole -> Dave; 586 cost guide -> Ryan.
 * 2. Share CSS for the .fgs-share bar (bar itself is appended by mu-plugin fgs-share.php
 *    on single posts only — blog-only by design; service pages don't get shared).
 * Idempotent. Usage: wp eval-file fgs-30-authors-share.php
 */

// ---------- 1. authors ----------
$authors = array(
	'ryan-townsend' => array(
		'display' => 'Ryan Townsend',
		'email'   => 'rtownsend@fgsfl.net',
		'bio'     => 'Founder and head of operations at Florida Geotechnical Services. Ryan writes the practical posts — costs, scheduling, and what to expect when you hire a geotech firm in Florida.',
		'posts'   => array( 586 ),
	),
	'dave-cappa'    => array(
		'display' => 'Dave Cappa, P.E.',
		'email'   => 'rtownsend+dcappa@fgsfl.net',
		'bio'     => 'Senior project engineer at Florida Geotechnical Services. Dave writes the engineering posts — sinkholes, soils, foundations, and what the data actually says.',
		'posts'   => array( 587 ),
	),
);

foreach ( $authors as $login => $a ) {
	$user = get_user_by( 'login', $login );
	if ( ! $user ) {
		$uid = wp_insert_user( array(
			'user_login'   => $login,
			'user_pass'    => wp_generate_password( 24 ),
			'user_email'   => $a['email'],
			'display_name' => $a['display'],
			'first_name'   => explode( ' ', $a['display'] )[0],
			'role'         => 'author',
			'description'  => $a['bio'],
		) );
		if ( is_wp_error( $uid ) ) {
			WP_CLI::error( "{$login}: " . $uid->get_error_message() );
		}
		WP_CLI::log( "user {$login} created (ID {$uid})." );
	} else {
		$uid = $user->ID;
		wp_update_user( array( 'ID' => $uid, 'display_name' => $a['display'], 'description' => $a['bio'] ) );
		WP_CLI::log( "user {$login} exists (ID {$uid}) — refreshed." );
	}
	foreach ( $a['posts'] as $pid ) {
		wp_update_post( array( 'ID' => $pid, 'post_author' => $uid ) );
		WP_CLI::log( "  post {$pid} -> {$a['display']}" );
	}
}

// ---------- 2. share bar CSS ----------
$ms  = '/* fgs-share:start */';
$me  = '/* fgs-share:end */';
$new = <<<'CSS'
/* — Share bar (single posts, appended by mu-plugin) — */
.fgs-share{display:flex;align-items:center;gap:10px;flex-wrap:wrap;max-width:780px;margin:44px auto 8px;padding-top:22px;border-top:1px solid #e8e1d6}
.fgs-share__label{font-size:12px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase;color:#2d2d2d;margin-right:6px}
.fgs-share a,.fgs-share button{display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:10px;background:#2d2d2d;color:#ffffff;border:0;cursor:pointer;text-decoration:none;transition:background .18s ease,color .18s ease}
.fgs-share a svg,.fgs-share button svg{width:18px;height:18px;fill:currentColor}
.fgs-share a:hover,.fgs-share button:hover{background:#a91513;color:#ffffff;animation:fgsJiggle .45s ease both}
.fgs-share__copy{width:auto !important;padding:0 16px;font-weight:700;font-size:13px;letter-spacing:.4px;gap:7px}
@keyframes fgsJiggle{0%{transform:translateX(0) rotate(0)}30%{transform:translateX(4px) rotate(.8deg)}55%{transform:translateX(2px) rotate(-.7deg)}80%{transform:translateX(3px) rotate(.4deg)}100%{transform:translateX(3px) rotate(0)}}
/* author byline polish */
.single-post .entry-meta{max-width:780px;margin-left:auto;margin-right:auto}
CSS;
$css = (string) wp_get_custom_css();
$css = preg_replace( '#' . preg_quote( $ms, '#' ) . '.*?' . preg_quote( $me, '#' ) . '#s', '', $css );
wp_update_custom_css_post( rtrim( $css ) . "\n\n" . $ms . "\n" . $new . "\n" . $me . "\n" );
WP_CLI::log( 'share CSS written.' );

WP_CLI::success( 'Authors + share styling done.' );
