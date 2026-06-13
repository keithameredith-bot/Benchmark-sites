# DataForSEO API helper — POSTs a JSON body to an endpoint and saves the response.
# usage: .\dfs.ps1 -Endpoint "dataforseo_labs/google/ranked_keywords/live" -Body '[{...}]' -OutFile "ranked.json"
param(
    [Parameter(Mandatory)] [string] $Endpoint,
    [Parameter(Mandatory)] [string] $Body,
    [Parameter(Mandatory)] [string] $OutFile
)
$auth = (Get-Content "$PSScriptRoot\dfs-auth.txt" -Raw).Trim()
$h = @{ Authorization = "Basic $auth" }
$raw = Invoke-WebRequest -Uri "https://api.dataforseo.com/v3/$Endpoint" -Method Post -Headers $h -ContentType "application/json" -Body $Body -UseBasicParsing
$dir = "$PSScriptRoot\seo-data"
if (-not (Test-Path $dir)) { New-Item -ItemType Directory $dir | Out-Null }
[System.IO.File]::WriteAllText("$dir\$OutFile", $raw.Content)
$j = $raw.Content | ConvertFrom-Json
"endpoint: $Endpoint"
"status: $($j.tasks[0].status_message) | cost: `$$($j.cost) | saved: seo-data\$OutFile ($($raw.Content.Length) bytes)"
