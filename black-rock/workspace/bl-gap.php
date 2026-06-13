<?php
// Backlink gap: quality domains linking to FL competitors but not to us.
$d = __DIR__ . '/seo-data';
function refdoms($file) {
    $j = json_decode(file_get_contents($file), true);
    return $j['tasks'][0]['result'][0]['items'] ?? [];
}
$ours = [];
foreach (refdoms("$d/bl-refdomains.json") as $i) $ours[$i['domain']] = true;

$compFiles = ['makefloridayourhome.com' => 'bl-comp-mfyh.json', 'flamortgagefirm.com' => 'bl-comp-flamf.json', 'ocalamortgageloans.com' => 'bl-comp-ocala.json'];
$prospects = [];
foreach ($compFiles as $comp => $f) {
    foreach (refdoms("$d/$f") as $i) {
        if ($i['rank'] < 15) continue;            // quality floor
        if (isset($ours[$i['domain']])) continue; // already links to us
        $dom = $i['domain'];
        if (!isset($prospects[$dom])) $prospects[$dom] = ['rank' => $i['rank'], 'links_to' => []];
        $prospects[$dom]['links_to'][] = $comp;
    }
}
uasort($prospects, fn($a, $b) => count($b['links_to']) <=> count($a['links_to']) ?: $b['rank'] <=> $a['rank']);
echo "quality domains (rank>=15) linking to competitors but NOT to us: " . count($prospects) . "\n\n";
$n = 0;
foreach ($prospects as $dom => $p) {
    printf("%-50s rank:%-4d links to: %s\n", $dom, $p['rank'], implode(', ', $p['links_to']));
    if (++$n >= 50) break;
}
// anchors summary too
$a = json_decode(file_get_contents("$d/bl-anchors.json"), true);
echo "\n=== OUR TOP ANCHORS ===\n";
foreach (array_slice($a['tasks'][0]['result'][0]['items'] ?? [], 0, 20) as $i) {
    printf("%-55s backlinks:%-5d domains:%d\n", substr($i['anchor'] ?? '[empty]', 0, 54), $i['backlinks'], $i['referring_domains']);
}
