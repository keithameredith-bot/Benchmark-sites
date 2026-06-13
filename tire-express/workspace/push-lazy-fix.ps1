# Add native loading="lazy" to content images lacking it, on all production te-np pages (in place).
$ErrorActionPreference = "Stop"
$SITE = "https://www.tireexpressandservice.com"
$cred = Get-Content "C:\Users\keith\.tire-express-rest-auth.txt"
$pw = ($cred | Where-Object { $_ -match '^app-password: (.+)$' }) -replace '^app-password: ',''
$b64 = [Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes("admin:$pw"))
$H = @{ Authorization = "Basic $b64" }
$ids = @(7,15,18,226001,226003,226004,226005,226006,226007,226138,226144,227931,227932,227941,227942,227943,227950,227951,227952,533,711,858)
foreach ($id in $ids) {
  try {
    $page = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/${id}?context=edit" -Headers $H
    $c = [regex]::Replace($page.content.raw, '<img (?![^>]*loading=)', '<img loading="lazy" decoding="async" ')
    if ($c -eq $page.content.raw) { "skip $id"; continue }
    $json = @{ content = $c } | ConvertTo-Json -Compress
    $null = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/$id" -Method Post -Headers $H -ContentType "application/json; charset=utf-8" -Body ([Text.Encoding]::UTF8.GetBytes($json))
    "lazied $id ($($page.slug))"
  } catch { "ERROR $id : $($_.Exception.Message)" }
}
"DONE"
