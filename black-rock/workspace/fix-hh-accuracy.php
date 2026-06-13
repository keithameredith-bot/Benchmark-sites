<?php
// Phase B: correct Hometown Heroes eligibility (occupation-restricted since July 2025) across new pages.
// Source of truth: post 15715. Idempotent string replacements; reports misses.
global $wpdb;

function brm_swap($slug, $swaps) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_name=%s AND post_status='publish'", $slug));
    if (!$row) { echo "MISS $slug\n"; return; }
    $c = $row->post_content; $applied = 0;
    foreach ($swaps as $from => $to) {
        if (strpos($c, $from) !== false) { $c = str_replace($from, $to, $c); $applied++; }
        elseif (strpos($c, $to) === false) { echo "  WARN [$slug] not found: " . substr($from, 0, 70) . "\n"; }
    }
    if ($applied) {
        $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $row->ID));
        clean_post_cache($row->ID);
    }
    echo "$slug: $applied swaps\n";
}

// 1. FTHB grants article
brm_swap('florida-first-time-home-buyer-grants', array(
  "If you work full-time for a Florida-based employer, start here. <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> provides up to 5% of your first mortgage (capped at \$35,000) toward down payment and closing costs, as a 0%-interest second mortgage you don't repay until you sell, refinance, or pay off the home. It used to be limited to certain professions &mdash; now it covers essentially any full-time Florida worker under the income cap. The catch: funds run out fast each cycle, and the people who get them are the ones already pre-approved when the money drops."
  =>
  "If you work in healthcare, a K-12 school, public safety, childcare, the courts, or the military &mdash; start here. <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> provides up to 5% of your first mortgage (capped at \$35,000) toward down payment and closing costs, as a 0%-interest second mortgage you don't repay until you sell, refinance, or pay off the home. As of July 2025 the program is occupation-based again: eligible roles include healthcare workers (50+ roles, from CNAs to physicians), K-12 school staff, first responders, public safety and court employees, childcare workers, and active military &mdash; and <strong>veterans qualify even if they aren't first-time buyers</strong>. Your employer must be Florida-based. The catch: funds are released in cycles and run out fast &mdash; they're exhausted right now, with the next release expected in July &mdash; and the people who get them are the ones already pre-approved when the money drops.",
));

// 2. Gainesville city page (body + FAQ + schema)
brm_swap('gainesville-mortgage-broker', array(
  "<strong>Hometown Heroes was made for this town.</strong> Nurses, techs, professors, staff, teachers, and first responders who work full-time for a Florida employer can get up to \$35,000 toward down payment and closing costs. UF and UF Health are among the biggest such employers in the state &mdash; a lot of people qualify and never apply."
  =>
  "<strong>Hometown Heroes was made for this town's medical community.</strong> Since July 2025 the program is occupation-based: healthcare workers (50+ roles &mdash; nurses, techs, therapists, physicians, pharmacists), K-12 teachers and school staff, first responders, childcare workers, and military qualify for up to \$35,000 toward down payment and closing costs. UF Health Shands is one of the biggest eligible employers in Florida &mdash; thousands of its clinical staff qualify and never apply. (Note: non-clinical university faculty and staff generally don't qualify under the current rules &mdash; but veterans do, even as repeat buyers.)",
  "<p>Yes &mdash; if you're a full-time employee of a Florida-based employer and you meet your county's income limit, that's exactly who the program is built for. UF and UF Health staff, teachers, nurses, and first responders are squarely eligible. It provides up to \$35,000 toward down payment and closing costs.</p>"
  =>
  "<p>For UF Health clinical staff &mdash; nurses, techs, therapists, physicians, pharmacists and 50+ other healthcare roles &mdash; yes, squarely. K-12 teachers and school staff also qualify. Since July 2025 the program is occupation-based, so non-clinical university faculty/admin generally don't qualify (veterans being the exception &mdash; they qualify regardless). Income limits are set by county, and it provides up to \$35,000 toward down payment and closing costs.</p>",
  '{"@type":"Question","name":"Does Hometown Heroes work for UF and UF Health employees?","acceptedAnswer":{"@type":"Answer","text":"Yes. Full-time employees of a Florida-based employer who meet the county income limit qualify, including UF and UF Health staff, teachers, nurses, and first responders. It provides up to $35,000 toward down payment and closing costs."}}'
  =>
  '{"@type":"Question","name":"Does Hometown Heroes work for UF and UF Health employees?","acceptedAnswer":{"@type":"Answer","text":"UF Health clinical staff qualify squarely - nurses, techs, therapists, physicians, pharmacists and 50+ other healthcare roles - as do K-12 teachers and school staff, first responders, and military. Since July 2025 the program is occupation-based, so non-clinical university faculty generally do not qualify, though veterans qualify regardless. It provides up to $35,000 toward down payment and closing costs."}}',
));

// 3. Belleview city page
brm_swap('belleview-mortgage-broker', array(
  "<strong>Perfect for commuters and frontline workers.</strong> Folks working in The Villages or Ocala can buy here for less &mdash; and if you work full-time for a Florida employer, <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> can put up to \$35,000 toward your purchase."
  =>
  "<strong>Perfect for commuters and frontline workers.</strong> Folks working in The Villages or Ocala can buy here for less &mdash; and if you work in healthcare, a K-12 school, public safety, childcare, or the military (or you're a veteran), <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> can put up to \$35,000 toward your purchase.",
  "<p>It&rsquo;s one of the most common moves out here. Belleview, Summerfield, and Oxford let Villages-area workers own for less, and if you work full-time for a Florida employer you may also qualify for up to \$35,000 through <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a>.</p>"
  =>
  "<p>It&rsquo;s one of the most common moves out here. Belleview, Summerfield, and Oxford let Villages-area workers own for less &mdash; and a lot of Villages-area jobs are exactly the occupations <a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a> covers: healthcare workers, first responders, childcare, and K-12 school staff can get up to \$35,000 toward the purchase, and veterans qualify even as repeat buyers.</p>",
  '{"@type":"Question","name":"I work in The Villages but want to buy cheaper. Does that work?","acceptedAnswer":{"@type":"Answer","text":"Yes. Belleview, Summerfield, and Oxford let Villages-area workers own for less, and full-time Florida employees may qualify for up to $35,000 through Hometown Heroes."}}'
  =>
  '{"@type":"Question","name":"I work in The Villages but want to buy cheaper. Does that work?","acceptedAnswer":{"@type":"Answer","text":"Yes. Belleview, Summerfield, and Oxford let Villages-area workers own for less, and many Villages-area jobs - healthcare, first responders, childcare, K-12 school staff - qualify for up to $35,000 through Hometown Heroes. Veterans qualify even as repeat buyers."}}',
));

// 4. Rent-to-own article (table row)
brm_swap('rent-to-own-homes-in-florida', array(
  "<tr><td>A Florida W-2 job</td><td><a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a></td><td class=\"yes\">Up to \$35K help</td></tr>"
  =>
  "<tr><td>A frontline job (healthcare, K-12, first responder, military)</td><td><a href=\"/hometown-heroes-mortgage-program/\">Hometown Heroes</a></td><td class=\"yes\">Up to \$35K help</td></tr>",
));

// 5. Cheapest places article (financing list)
brm_swap('cheapest-places-to-buy-a-house-in-florida', array(
  "<li><strong><a href=\"/hometown-heroes-mortgage-program/\">Florida Hometown Heroes</a> &mdash; up to \$35,000</strong> toward down payment and closing costs for eligible Florida workers.</li>"
  =>
  "<li><strong><a href=\"/hometown-heroes-mortgage-program/\">Florida Hometown Heroes</a> &mdash; up to \$35,000</strong> toward down payment and closing costs for eligible frontline workers &mdash; healthcare, K-12 school staff, first responders, childcare, and military (veterans qualify even as repeat buyers).</li>",
));
echo "done\n";
