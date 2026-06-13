# Summarize FL SERPs: our position + top organic results per keyword.
$j = (Get-Content "$PSScriptRoot\seo-data\serps-fl.json" -Raw | ConvertFrom-Json)
foreach ($t in $j.tasks) {
    $kw = $t.data.keyword
    $loc = $t.data.location_code
    $items = $t.result[0].items | Where-Object { $_.type -eq "organic" }
    $ours = $items | Where-Object { $_.domain -like "*blackrockmortgage*" } | Select-Object -First 1
    $ourPos = if ($ours) { "$($ours.rank_absolute) ($($ours.url -replace 'https://www.blackrockmortgage.com',''))" } else { "NOT IN TOP 30" }
    ""
    "=== '$kw' [loc $loc] -- US: $ourPos"
    $items | Select-Object -First 10 | ForEach-Object {
        $mark = if ($_.domain -like "*blackrockmortgage*") { " <<<< US" } else { "" }
        "  {0,2}. {1,-42} {2}{3}" -f $_.rank_absolute, $_.domain, ($_.title -replace '^(.{55}).*','$1...'), $mark
    }
}
