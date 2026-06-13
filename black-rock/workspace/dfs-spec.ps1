$auth = Get-Content "C:\Users\keith\Desktop\black-rock-workspace\dfs-auth.txt" -Raw
$h = @{ Authorization = "Basic $($auth.Trim())"; "Content-Type" = "application/json" }

# 1. search volumes (US national - product serves builders broadly)
$kw = @("spec construction loans","spec home construction loans","spec home loans","spec home financing","construction loans for builders","builder construction loans","speculative construction loan","spec building loans","spec loans for builders","spec loans","construction spec loans","spec house financing","new construction spec loans","spec construction loans florida","builder spec loans")
$body = '[{"keywords":' + ($kw | ConvertTo-Json) + ',"location_code":2840,"language_code":"en"}]'
$r = Invoke-RestMethod -Method Post -Uri "https://api.dataforseo.com/v3/keywords_data/google_ads/search_volume/live" -Headers $h -Body $body
"=== VOLUMES ==="
$r.tasks[0].result | Sort-Object search_volume -Descending | ForEach-Object { "{0,-38} vol={1,-7} cpc={2,-7} comp={3}" -f $_.keyword, $_.search_volume, $_.cpc, $_.competition }
