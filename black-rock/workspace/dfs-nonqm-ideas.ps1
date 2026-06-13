$auth = Get-Content "C:\Users\keith\Desktop\black-rock-workspace\dfs-auth.txt" -Raw
$h = @{ Authorization = "Basic $($auth.Trim())"; "Content-Type" = "application/json" }
$kw = @(
"itin home loans","itin mortgage florida","foreign national mortgage","foreign national loans florida",
"asset depletion mortgage","asset based mortgage loans","p&l only mortgage","1099 only mortgage",
"build to rent financing","fix to rent loans","model home financing","land development loans florida",
"bridge loans florida real estate","no doc heloc","bank statement heloc","dscr heloc",
"mortgage after foreclosure","mortgage one day out of bankruptcy","non warrantable condo loans",
"40 year mortgage florida","interest only mortgage florida","fix and flip loans florida")
$body = '[{"keywords":' + ($kw | ConvertTo-Json) + ',"location_code":2840,"language_code":"en"}]'
$r = Invoke-RestMethod -Method Post -Uri "https://api.dataforseo.com/v3/keywords_data/google_ads/search_volume/live" -Headers $h -Body $body
$r.tasks[0].result | Sort-Object search_volume -Descending | ForEach-Object { "{0,-38} vol={1,-7} cpc={2,-7} comp={3}" -f $_.keyword, $_.search_volume, $_.cpc, $_.competition }
