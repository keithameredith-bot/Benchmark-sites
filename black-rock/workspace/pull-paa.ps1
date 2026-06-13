# Pull Google SERP (advanced, with PAA) for money topics; extract People Also Ask questions.
$auth = (Get-Content "$PSScriptRoot\dfs-auth.txt" -Raw).Trim()
$h = @{ Authorization = "Basic $auth" }
$kws = @(
    "cheapest places to buy a house in florida",
    "florida first time home buyer grants",
    "rent to own homes in florida",
    "requirements to buy a house in florida",
    "florida property tax exemptions",
    "physician mortgage loan",
    "usda loan florida",
    "fha loan requirements florida",
    "manufactured home financing florida",
    "florida hometown heroes program"
)
$out = @{}
foreach ($k in $kws) {
    $body = ConvertTo-Json @(@{ keyword = $k; location_code = 21142; language_code = "en"; depth = 20; people_also_ask_click_depth = 1 })
    try {
        $r = Invoke-RestMethod -Uri "https://api.dataforseo.com/v3/serp/google/organic/live/advanced" -Method Post -Headers $h -ContentType "application/json" -Body $body -TimeoutSec 120
        $items = $r.tasks[0].result[0].items
        $paa = @($items | Where-Object { $_.type -eq "people_also_ask" } | ForEach-Object { $_.items } | ForEach-Object { $_.title })
        $related = @($items | Where-Object { $_.type -eq "related_searches" } | ForEach-Object { $_.items })
        "=== '$k'"
        if ($paa.Count) { $paa | ForEach-Object { "  PAA: $_" } } else { "  (no PAA returned)" }
        if ($related.Count) { ($related | Select-Object -First 6) | ForEach-Object { "  rel: $_" } }
    } catch { "=== '$k' ERR: $($_.Exception.Message)" }
}
