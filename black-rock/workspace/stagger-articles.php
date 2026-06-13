<?php
// Stagger the 5 new articles: 2/week, 9:00 AM, flagships first.
$schedule = array(
  987515420 => '2026-06-15 09:00:00', // Cheapest Places (Mon)
  987515421 => '2026-06-18 09:00:00', // FTHB Grants (Thu)
  987515422 => '2026-06-22 09:00:00', // Rent-to-Own (Mon)
  987515423 => '2026-06-25 09:00:00', // Requirements (Thu)
  987515424 => '2026-06-29 09:00:00', // Property Tax (Mon)
);
foreach ($schedule as $pid => $date) {
    $r = wp_update_post(array(
        'ID' => $pid,
        'post_status' => 'future',
        'post_date' => $date,
        'post_date_gmt' => get_gmt_from_date($date),
        'edit_date' => true,
    ), true);
    $p = get_post($pid);
    echo (is_wp_error($r) ? "ERR $pid: " . $r->get_error_message() : "[{$p->post_status}] {$p->post_date}  {$p->post_name}") . "\n";
}
