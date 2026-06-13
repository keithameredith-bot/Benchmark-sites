# Florida keywords makefloridayourhome.com ranks top-20 for that we rank >30 or not at all.
$d = "$PSScriptRoot\seo-data"
$comp = (Get-Content "$d\competitor-mfyh.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
$rk   = (Get-Content "$d\ranked-keywords.json" -Raw | ConvertFrom-Json).tasks[0].result[0].items
$pos = @{}
foreach ($r in $rk) { $pos[$r.keyword_data.keyword] = $r.ranked_serp_element.serp_item.rank_absolute }

$gaps = $comp | Where-Object {
    $_.ranked_serp_element.serp_item.rank_absolute -le 20 -and
    $_.keyword_data.keyword_info.search_volume -ge 50 -and
    (-not $pos.ContainsKey($_.keyword_data.keyword) -or $pos[$_.keyword_data.keyword] -gt 30)
} | Sort-Object { $_.keyword_data.keyword_info.search_volume } -Descending

"qualifying gap keywords: $($gaps.Count)"
""
$gaps | Select-Object -First 70 | ForEach-Object {
    $ours = if ($pos.ContainsKey($_.keyword_data.keyword)) { $pos[$_.keyword_data.keyword] } else { "-" }
    "{0,-62} vol:{1,-6} them:{2,-3} us:{3,-4} {4}" -f $_.keyword_data.keyword, $_.keyword_data.keyword_info.search_volume, $_.ranked_serp_element.serp_item.rank_absolute, $ours, ($_.ranked_serp_element.serp_item.relative_url -replace '^https?://[^/]+','')
}
