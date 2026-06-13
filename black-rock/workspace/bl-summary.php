<?php
// Summarize backlink pulls. Run with plain php.exe (no WP needed).
$d = __DIR__ . '/seo-data';

$s = json_decode(file_get_contents("$d/bl-summary.json"), true);
$t = $s['tasks'][0]['result'][0] ?? null;
if (!$t) { echo "summary status: " . ($s['tasks'][0]['status_message'] ?? '?') . "\n"; exit; }
echo "=== BACKLINK SUMMARY blackrockmortgage.com ===\n";
echo "rank: {$t['rank']} | backlinks: {$t['backlinks']} | referring domains: {$t['referring_domains']}\n";
echo "ref domains (nofollow): {$t['referring_domains_nofollow']} | broken backlinks: {$t['broken_backlinks']} | broken pages: {$t['broken_pages']}\n";
echo "referring IPs: {$t['referring_ips']} | TLDs: " . json_encode(array_slice($t['referring_links_tld'] ?? [], 0, 8)) . "\n";
echo "link types: " . json_encode($t['referring_links_types'] ?? []) . "\n";
echo "attrs: " . json_encode($t['referring_links_attributes'] ?? []) . "\n\n";

$r = json_decode(file_get_contents("$d/bl-refdomains.json"), true);
$items = $r['tasks'][0]['result'][0]['items'] ?? [];
echo "=== TOP REFERRING DOMAINS (" . count($items) . " shown, by rank) ===\n";
foreach (array_slice($items, 0, 40) as $i) {
    printf("%-45s rank:%-4d backlinks:%-5d dofollow:%-5s first:%s\n",
        $i['domain'], $i['rank'], $i['backlinks'],
        ($i['referring_links_attributes']['nofollow'] ?? 0) == $i['backlinks'] ? 'NO' : 'yes',
        substr($i['first_seen'] ?? '', 0, 10));
}

$a = json_decode(file_get_contents("$d/bl-anchors.json"), true);
$items = $a['tasks'][0]['result'][0]['items'] ?? [];
echo "\n=== TOP ANCHORS ===\n";
foreach (array_slice($items, 0, 25) as $i) {
    printf("%-55s backlinks:%-5d domains:%d\n", substr($i['anchor'] ?? '[empty]', 0, 54), $i['backlinks'], $i['referring_domains']);
}
