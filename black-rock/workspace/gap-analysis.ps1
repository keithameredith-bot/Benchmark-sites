# Cross keyword ideas vs current rankings -> gap report. ASCII only (PS 5.1).
$d = "$PSScriptRoot\seo-data"

$ideas = (Get-Content "$d\keyword-ideas-fl.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
$rk    = (Get-Content "$d\ranked-keywords.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items

$pos = @{}
foreach ($r in $rk) { $pos[$r.keyword_data.keyword] = $r.ranked_serp_element.serp_item.rank_absolute }

$flIdeas = $ideas | Where-Object { $_.keyword -match "florida|\bfl\b" -and $_.keyword_info.search_volume -ge 90 }
"FL keywords with vol >= 90: $($flIdeas.Count)"
""
"--- NOT RANKING AT ALL (gaps), top 60 by volume ---"
$gap = $flIdeas | Where-Object { -not $pos.ContainsKey($_.keyword) } | Sort-Object { $_.keyword_info.search_volume } -Descending
"count: $($gap.Count)"
$gap | Select-Object -First 60 | ForEach-Object {
    "{0,-58} vol:{1,-7} diff:{2,-4} cpc:{3}" -f $_.keyword, $_.keyword_info.search_volume, $_.keyword_properties.keyword_difficulty, $_.keyword_info.cpc
}
""
"--- RANKING 21-100 (improvable), top 40 by volume ---"
$weak = $flIdeas | Where-Object { $pos.ContainsKey($_.keyword) -and $pos[$_.keyword] -gt 20 } | Sort-Object { $_.keyword_info.search_volume } -Descending
$weak | Select-Object -First 40 | ForEach-Object {
    "{0,-58} vol:{1,-7} pos:{2}" -f $_.keyword, $_.keyword_info.search_volume, $pos[$_.keyword]
}
