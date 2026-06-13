<?php
// 1. More space above the "Ready for a Full Application?" label (52->80px) on all CTAs.
// 2. Homepage label color -> explicit #5dcaa5 (match program pages).
// 3. Cache-bust the form iframe so the fixed (un-smushed) form loads: preapproval-form.html -> ?v=2.
global $wpdb;
$rows = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_status='publish' AND (post_content LIKE '%brm-prog-cta-readylabel%' OR post_content LIKE '%brm-home-final-readylabel%' OR post_content LIKE '%preapproval-form.html%')");
$n = 0;
foreach ($rows as $r) {
    $c = $r->post_content; $orig = $c;
    // gap 52 -> 80
    $c = str_replace('.brm-prog-cta-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:52px 0 0;}',
                     '.brm-prog-cta-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:80px 0 0;}', $c);
    $c = str_replace('.brm-home-final-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:var(--accent);text-align:center;margin:52px 0 0;}',
                     '.brm-home-final-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:80px 0 0;}', $c);
    // cache-bust form (idempotent: only matches the bare filename + quote)
    $c = str_replace('preapproval-form.html"', 'preapproval-form.html?v=2"', $c);
    if ($c !== $orig) { $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $r->ID)); clean_post_cache($r->ID); $n++; }
}
echo "$n pages updated (label gap 80px, homepage color #5dcaa5, form cache-bust v2)\n";
