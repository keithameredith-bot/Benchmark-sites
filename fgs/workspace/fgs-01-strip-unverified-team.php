<?php
/**
 * fgs-01-strip-unverified-team.php — Phase 0 truth audit, About page (ID 92).
 *
 * 1. Removes the starter-template "Meet the Team" Kadence section (uniqueID 92_669bda-8e):
 *    stock Pexels photos posing as headshots + a literal "New Person / Position" card.
 * 2. Removes the three unverified team cards (Mike Henderson, Sarah Chen, James Carter)
 *    from the custom "Meet the FGS Team" HTML grid. Ryan Townsend + Dave Cappa remain.
 * 3. Rewrites the "Same five faces" intro line to match a two-principal team.
 *
 * Idempotent: each step is skipped with a notice if its target is already gone.
 * Usage: wp eval-file fgs-01-strip-unverified-team.php
 */

$page_id = 92;
$post    = get_post( $page_id );
if ( ! $post ) {
	WP_CLI::error( "Page {$page_id} not found." );
}
$content  = $post->post_content;
$original = $content;

// ---- 1. Remove the entire template-leftover team rowlayout (depth-aware cut). ----
$open_marker = '<!-- wp:kadence/rowlayout {"uniqueID":"92_669bda-8e"';
$start       = strpos( $content, $open_marker );
if ( false === $start ) {
	WP_CLI::log( 'Step 1: template team section already removed — skipping.' );
} else {
	$open_tok  = '<!-- wp:kadence/rowlayout';
	$close_tok = '<!-- /wp:kadence/rowlayout -->';
	$depth     = 0;
	$pos       = $start;
	$end       = false;
	while ( true ) {
		$next_open  = strpos( $content, $open_tok, $pos );
		$next_close = strpos( $content, $close_tok, $pos );
		if ( false === $next_close ) {
			break;
		}
		if ( false !== $next_open && $next_open < $next_close ) {
			$depth++;
			$pos = $next_open + strlen( $open_tok );
		} else {
			$depth--;
			$pos = $next_close + strlen( $close_tok );
			if ( 0 === $depth ) {
				$end = $pos;
				break;
			}
		}
	}
	if ( false === $end ) {
		WP_CLI::error( 'Step 1: could not find matching rowlayout closer — aborting, nothing written.' );
	}
	$content = substr( $content, 0, $start ) . ltrim( substr( $content, $end ), "\n" );
	WP_CLI::log( 'Step 1: removed template "Meet the Team" section (92_669bda-8e), ' . ( $end - $start ) . ' chars.' );
}

// ---- 2. Remove unverified team cards (MH, SC, JC) from the HTML grid. ----
foreach ( array( 'MH' => 'Mike Henderson', 'SC' => 'Sarah Chen', 'JC' => 'James Carter' ) as $initials => $name ) {
	$pattern = '#\s*<div class="fgs-team-card">\s*<img src="https://placehold\.co/500x500/[^"]*text=' . $initials . '"[^>]*>.*?</div>#s';
	$new     = preg_replace( $pattern, '', $content, 1, $count );
	if ( null === $new ) {
		WP_CLI::error( "Step 2 ({$name}): regex error — aborting, nothing written." );
	}
	if ( 0 === $count ) {
		WP_CLI::log( "Step 2: {$name} card not found — skipping." );
	} else {
		$content = $new;
		WP_CLI::log( "Step 2: removed {$name} card." );
	}
}

// ---- 3. Fix the "five faces" intro line. ----
$old_line = 'The principals do the engineering. The field crew runs the rigs. The lab does the testing. Same five faces on every project, every report, every phone call.';
$new_line = 'The principals do the engineering. The field crew runs the rigs. The lab does the testing. And the engineer you talk to on the phone is the engineer who signs the report.';
if ( false !== strpos( $content, $old_line ) ) {
	$content = str_replace( $old_line, $new_line, $content );
	WP_CLI::log( 'Step 3: rewrote "five faces" intro line.' );
} elseif ( false !== strpos( $content, $new_line ) ) {
	WP_CLI::log( 'Step 3: intro line already rewritten — skipping.' );
} else {
	WP_CLI::warning( 'Step 3: intro line not found in either form — check manually.' );
}

// ---- Write. ----
if ( $content === $original ) {
	WP_CLI::success( 'No changes needed — page already clean.' );
	return;
}
$result = wp_update_post(
	array(
		'ID'           => $page_id,
		'post_content' => wp_slash( $content ),
	),
	true
);
if ( is_wp_error( $result ) ) {
	WP_CLI::error( 'wp_update_post failed: ' . $result->get_error_message() );
}
WP_CLI::success( "Page {$page_id} updated. " . strlen( $original ) . ' -> ' . strlen( $content ) . ' chars.' );
