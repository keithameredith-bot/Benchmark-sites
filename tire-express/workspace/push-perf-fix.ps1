# Performance pass on PRODUCTION via REST: remove @import font chain (-> parallel <link>s),
# swap 426KB hero JPEG -> 182KB webp. Transforms each page in place; idempotent.
$ErrorActionPreference = "Stop"
$SITE = "https://www.tireexpressandservice.com"
$cred = Get-Content "C:\Users\keith\.tire-express-rest-auth.txt"
$pw = ($cred | Where-Object { $_ -match '^app-password: (.+)$' }) -replace '^app-password: ',''
$b64 = [Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes("admin:$pw"))
$H = @{ Authorization = "Basic $b64" }

$fontLinks = '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap">'
$ids = @(7,15,18,226001,226003,226004,226005,226006,226007,226138,226144,227931,227932,227941,227942,227943,227950,227951,227952,533,711,858)

foreach ($id in $ids) {
  try {
    $page = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/${id}?context=edit" -Headers $H
    $c = $page.content.raw
    $orig = $c
    # 1. @import -> parallel links placed just before the <style> block
    if ($c -match '@import url\(') {
      $c = [regex]::Replace($c, "@import url\('https://fonts\.googleapis\.com[^']*'\);\s*", "")
      $c = $c -replace '<style>', "$fontLinks`n<style>"
    }
    # 2. hero bg -> optimized webp (relative + absolute forms)
    $c = $c.Replace('url("/wp-content/uploads/2026/06/store-front.jpg")', 'url("/wp-content/uploads/2026/06/store-front-hero.webp")')
    $c = $c.Replace('url("https://www.tireexpressandservice.com/wp-content/uploads/2026/06/store-front.jpg")', 'url("/wp-content/uploads/2026/06/store-front-hero.webp")')
    if ($c -eq $orig) { "skip $id (nothing to change)"; continue }
    $json = @{ content = $c } | ConvertTo-Json -Compress
    $null = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/$id" -Method Post -Headers $H -ContentType "application/json; charset=utf-8" -Body ([Text.Encoding]::UTF8.GetBytes($json))
    "fixed $id ($($page.slug))"
  } catch { "ERROR $id : $($_.Exception.Message)" }
}
"DONE"
