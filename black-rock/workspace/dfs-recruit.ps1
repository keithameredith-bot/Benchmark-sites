$auth = Get-Content "C:\Users\keith\Desktop\black-rock-workspace\dfs-auth.txt" -Raw
$h = @{ Authorization = "Basic $($auth.Trim())"; "Content-Type" = "application/json" }
$kw = @(
"become a mortgage broker","how to become a mortgage broker","mortgage broker sponsorship",
"mortgage loan officer jobs","loan officer jobs","mortgage loan originator jobs",
"become an independent mortgage broker","independent mortgage broker","1099 loan officer",
"best mortgage company to work for","mortgage net branch","mortgage branch opportunity",
"work for a mortgage broker","join a mortgage broker","loan officer careers",
"how to start a mortgage company","mortgage broker dba","wholesale mortgage broker jobs",
"become a loan officer","loan officer independent contractor","mortgage broker vs loan officer",
"switch to mortgage broker","mortgage company sponsorship","loan originator opportunity",
"flat fee mortgage broker","best wholesale lender for brokers","mortgage broker careers")
$body = '[{"keywords":' + ($kw | ConvertTo-Json) + ',"location_code":2840,"language_code":"en"}]'
$r = Invoke-RestMethod -Method Post -Uri "https://api.dataforseo.com/v3/keywords_data/google_ads/search_volume/live" -Headers $h -Body $body
"=== US MONTHLY VOLUMES (recruiting intent) ==="
$r.tasks[0].result | Sort-Object search_volume -Descending | ForEach-Object { "{0,-40} vol={1,-7} cpc={2,-7} comp={3}" -f $_.keyword, $_.search_volume, $_.cpc, $_.competition }
