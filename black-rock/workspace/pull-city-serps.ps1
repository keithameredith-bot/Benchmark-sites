# Quick city-keyword SERP checks for service-area page targeting.
$auth = (Get-Content "$PSScriptRoot\dfs-auth.txt" -Raw).Trim()
$h = @{ Authorization = "Basic $auth" }
$kws = @("mortgage broker the villages fl", "mortgage lender gainesville fl", "mortgage broker belleview fl", "manufactured home financing ocala fl")
foreach ($k in $kws) {
    $body = ConvertTo-Json @(@{ keyword = $k; location_code = 21142; language_code = "en"; depth = 20 })
    $r = Invoke-RestMethod -Uri "https://api.dataforseo.com/v3/serp/google/organic/live/regular" -Method Post -Headers $h -ContentType "application/json" -Body $body
    $items = @($r.tasks[0].result[0].items | Where-Object { $_.type -eq "organic" })
    $ours = $items | Where-Object { $_.domain -like "*blackrockmortgage*" } | Select-Object -First 1
    "== '$k' -- us: $(if ($ours) { $ours.rank_absolute } else { 'not top 20' })"
    $items | Select-Object -First 6 | ForEach-Object { "   {0,2}. {1}" -f $_.rank_absolute, $_.domain }
}
