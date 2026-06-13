<?php
// Extract answer text + cited domains/brands from saved LLM responses.
$dir = __DIR__ . '/seo-data/llm';
$allDomains = [];
foreach (glob("$dir/q*.json") as $f) {
    $j = json_decode(file_get_contents($f), true);
    $task = $j['tasks'][0] ?? null;
    $name = basename($f, '.json');
    if (!$task || $task['status_code'] != 20000) { echo "$name: " . ($task['status_message'] ?? '?') . "\n"; continue; }
    $prompt = $task['data']['user_prompt'] ?? '';
    $items = $task['result'][0]['items'] ?? [];
    $text = '';
    $domains = [];
    foreach ($items as $it) {
        foreach (($it['sections'] ?? []) as $sec) {
            $text .= ($sec['text'] ?? '') . "\n";
            foreach (($sec['annotations'] ?? []) as $an) {
                if (!empty($an['url'])) {
                    $d = parse_url($an['url'], PHP_URL_HOST);
                    if ($d) { $d = preg_replace('/^www\./', '', $d); $domains[$d] = true; $allDomains[$d] = ($allDomains[$d] ?? 0) + 1; }
                }
            }
        }
    }
    // also catch raw URLs in text
    preg_match_all('#https?://([a-z0-9.-]+)#i', $text, $m);
    foreach ($m[1] as $d) { $d = preg_replace('/^www\./', '', strtolower($d)); $domains[$d] = true; $allDomains[$d] = ($allDomains[$d] ?? 0) + 1; }

    echo "=== $name: \"$prompt\"\n";
    echo "  cited: " . (count($domains) ? implode(', ', array_keys($domains)) : '(none)') . "\n";
    // brand mentions in text
    $brands = ['black rock' => 'BLACK ROCK', 'makeflorida' => 'makefloridayourhome', 'doce group' => 'thedocegroup', '21st mortgage' => '21st', 'ocala mortgage' => 'ocalamortgageloans'];
    $found = [];
    foreach ($brands as $needle => $label) if (stripos($text, $needle) !== false) $found[] = $label;
    if ($found) echo "  brands in answer: " . implode(', ', $found) . "\n";
    $snippet = trim(preg_replace('/\s+/', ' ', strip_tags($text)));
    echo "  answer (first 350 chars): " . substr($snippet, 0, 350) . "\n\n";
}
arsort($allDomains);
echo "=== DOMAINS CITED ACROSS ALL ANSWERS ===\n";
foreach (array_slice($allDomains, 0, 25, true) as $d => $n) echo "  $d ($n)\n";
