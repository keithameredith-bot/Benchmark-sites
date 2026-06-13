$auth = Get-Content "C:\Users\keith\Desktop\black-rock-workspace\dfs-auth.txt" -Raw
$h = @{ Authorization = "Basic $($auth.Trim())"; "Content-Type" = "application/json" }
foreach ($k in @("spec construction loans","spec home financing")) {
    $body = '[{"keyword":"' + $k + '","location_code":2840,"language_code":"en","people_also_ask_click_depth":1,"depth":20}]'
    $r = Invoke-RestMethod -Method Post -Uri "https://api.dataforseo.com/v3/serp/google/organic/live/advanced" -Headers $h -Body $body
    "=== PAA for: $k ==="
    foreach ($item in $r.tasks[0].result[0].items) {
        if ($item.type -eq 'people_also_ask') {
            foreach ($q in $item.items) { "  Q: " + $q.title }
        }
        if ($item.type -eq 'organic' -and $item.rank_absolute -le 5) { "  #" + $item.rank_absolute + " " + $item.domain + " - " + $item.title }
    }
}
