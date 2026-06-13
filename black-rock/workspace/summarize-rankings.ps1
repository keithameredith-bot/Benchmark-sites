# Summarize the four DataForSEO pulls into compact console tables.
$d = "$PSScriptRoot\seo-data"

$ov = (Get-Content "$d\domain-overview.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items[0].metrics.organic
"=== DOMAIN OVERVIEW (US) ==="
"pos1: $($ov.pos_1) | pos2-3: $($ov.pos_2_3) | pos4-10: $($ov.pos_4_10) | pos11-20: $($ov.pos_11_20) | pos21-50: $($ov.pos_21_50) | pos51+: $($ov.pos_51_100)"
"total keywords: $($ov.count) | est. traffic value: $([Math]::Round($ov.etv,1))"

$rk = (Get-Content "$d\ranked-keywords.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
""
"=== RANKED KEYWORDS: $($rk.Count) rows ==="
$fl = $rk | Where-Object { $_.keyword_data.keyword -match "florida|fl |ocala" }
"keywords containing florida/fl/ocala: $($fl.Count)"
""
"--- TOP 25 BY VOLUME (any position) ---"
$rk | Select-Object -First 25 | ForEach-Object {
    "{0,-55} vol:{1,-7} pos:{2,-4} url:{3}" -f $_.keyword_data.keyword, $_.keyword_data.keyword_info.search_volume, $_.ranked_serp_element.serp_item.rank_absolute, ($_.ranked_serp_element.serp_item.relative_url)
}
""
"--- STRIKING DISTANCE (pos 4-20, vol >= 30) top 30 ---"
$rk | Where-Object { $_.ranked_serp_element.serp_item.rank_absolute -ge 4 -and $_.ranked_serp_element.serp_item.rank_absolute -le 20 -and $_.keyword_data.keyword_info.search_volume -ge 30 } |
    Sort-Object { $_.keyword_data.keyword_info.search_volume } -Descending | Select-Object -First 30 | ForEach-Object {
    "{0,-55} vol:{1,-7} pos:{2,-4} url:{3}" -f $_.keyword_data.keyword, $_.keyword_data.keyword_info.search_volume, $_.ranked_serp_element.serp_item.rank_absolute, ($_.ranked_serp_element.serp_item.relative_url)
}
""
"--- FLORIDA/OCALA KEYWORDS top 25 by volume ---"
$fl | Sort-Object { $_.keyword_data.keyword_info.search_volume } -Descending | Select-Object -First 25 | ForEach-Object {
    "{0,-55} vol:{1,-7} pos:{2,-4} url:{3}" -f $_.keyword_data.keyword, $_.keyword_data.keyword_info.search_volume, $_.ranked_serp_element.serp_item.rank_absolute, ($_.ranked_serp_element.serp_item.relative_url)
}

$rp = (Get-Content "$d\relevant-pages.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
""
"=== TOP 15 PAGES BY EST. TRAFFIC ==="
$rp | Sort-Object { $_.metrics.organic.etv } -Descending | Select-Object -First 15 | ForEach-Object {
    "{0,-60} kws:{1,-5} etv:{2}" -f $_.page_address, $_.metrics.organic.count, [Math]::Round($_.metrics.organic.etv,1)
}

$cp = (Get-Content "$d\competitors.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
""
"=== TOP COMPETITORS (by intersections) ==="
$cp | Select-Object -First 20 | ForEach-Object {
    "{0,-40} intersections:{1,-6} their_kws:{2,-7} avg_pos:{3}" -f $_.domain, $_.intersections, $_.full_domain_metrics.organic.count, [Math]::Round($_.avg_position,1)
}
