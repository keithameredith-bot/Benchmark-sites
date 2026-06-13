<?php
$j = json_decode(file_get_contents(__DIR__.'/seo-data/kw-physician.json'), true);
$items = $j['tasks'][0]['result'][0]['items'] ?? [];
echo "total: " . count($items) . "\n\n";
// filter relevant (loan/mortgage + physician/doctor/medical/dentist)
$rel = array_filter($items, function($i){
    $k = $i['keyword'];
    return preg_match('/physician|doctor|medical|dentist|resident/i',$k) && preg_match('/loan|mortgage|home/i',$k);
});
usort($rel, fn($a,$b)=>($b['keyword_info']['search_volume']??0)<=>($a['keyword_info']['search_volume']??0));
echo "=== TOP RELEVANT (loan+physician), top 40 ===\n";
foreach (array_slice($rel,0,40) as $i) {
    printf("%-48s vol:%-7s diff:%-4s cpc:%s\n", $i['keyword'], $i['keyword_info']['search_volume']??0, $i['keyword_properties']['keyword_difficulty']??'-', $i['keyword_info']['cpc']??'-');
}
echo "\n=== FLORIDA-specific ===\n";
foreach ($rel as $i) if (stripos($i['keyword'],'florida')!==false||stripos($i['keyword'],' fl')!==false) printf("%-48s vol:%-7s diff:%s\n",$i['keyword'],$i['keyword_info']['search_volume']??0,$i['keyword_properties']['keyword_difficulty']??'-');
