# Pull FL/Ocala SERPs one keyword at a time (live endpoint allows 1 task/request).
$auth = (Get-Content "$PSScriptRoot\dfs-auth.txt" -Raw).Trim()
$h = @{ Authorization = "Basic $auth" }
$kws = @(
    @{ k = "florida mortgage lenders";                loc = 21142 },
    @{ k = "fha loan florida";                        loc = 21142 },
    @{ k = "dscr loan florida";                       loc = 21142 },
    @{ k = "manufactured home loans florida";         loc = 21142 },
    @{ k = "usda loan florida";                       loc = 21142 },
    @{ k = "mortgage broker ocala fl";                loc = 1015141 },
    @{ k = "florida first time home buyer programs";  loc = 21142 },
    @{ k = "va loan florida";                         loc = 21142 },
    @{ k = "florida hometown heroes program";         loc = 21142 },
    @{ k = "mobile home financing florida";           loc = 21142 },
    @{ k = "florida construction loan";               loc = 21142 },
    @{ k = "mortgage lender near me";                 loc = 1015141 }
)
$all = @()
foreach ($x in $kws) {
    $body = ConvertTo-Json @(@{ keyword = $x.k; location_code = $x.loc; language_code = "en"; depth = 30 })
    $r = Invoke-RestMethod -Uri "https://api.dataforseo.com/v3/serp/google/organic/live/regular" -Method Post -Headers $h -ContentType "application/json" -Body $body
    $t = $r.tasks[0]
    if ($t.status_message -ne "Ok.") { "SKIP '$($x.k)': $($t.status_message)"; continue }
    $items = @($t.result[0].items | Where-Object { $_.type -eq "organic" })
    $ours = $items | Where-Object { $_.domain -like "*blackrockmortgage*" } | Select-Object -First 1
    $ourPos = if ($ours) { "pos $($ours.rank_absolute) -> $($ours.url -replace 'https?://(www\.)?blackrockmortgage\.com','')" } else { "NOT in top 30" }
    ""
    "=== '$($x.k)' [$($x.loc)] => US: $ourPos"
    $items | Select-Object -First 8 | ForEach-Object {
        "  {0,2}. {1}" -f $_.rank_absolute, $_.domain
    }
    $all += [PSCustomObject]@{ keyword = $x.k; loc = $x.loc; items = $items }
}
$all | ConvertTo-Json -Depth 6 | Out-File "$PSScriptRoot\seo-data\serps-fl-all.json" -Encoding utf8
""
"--- domains appearing in 3+ SERPs (real FL competitors) ---"
$all.items | Group-Object domain | Where-Object { $_.Count -ge 3 } | Sort-Object Count -Descending | ForEach-Object { "{0,-45} in {1} SERPs" -f $_.Name, $_.Count }
