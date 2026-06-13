# LCP round 2 on PRODUCTION: media-gated preloads for the hero + 30KB mobile hero via CSS media query.
$ErrorActionPreference = "Stop"
$SITE = "https://www.tireexpressandservice.com"
$cred = Get-Content "C:\Users\keith\.tire-express-rest-auth.txt"
$pw = ($cred | Where-Object { $_ -match '^app-password: (.+)$' }) -replace '^app-password: ',''
$b64 = [Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes("admin:$pw"))
$H = @{ Authorization = "Basic $b64" }

$preloads = '<link rel="preload" as="image" href="/wp-content/uploads/2026/06/store-front-hero.webp" media="(min-width:641px)"><link rel="preload" as="image" href="/wp-content/uploads/2026/06/store-front-hero-mobile.webp" media="(max-width:640px)">'
$mobileCss = "@media(max-width:640px){.te-np .hero{background:`n  linear-gradient(105deg,rgba(7,11,20,.96) 0%,rgba(9,15,28,.90) 40%,rgba(13,38,96,.38) 72%,rgba(18,72,215,.18) 100%),`n  url(`"/wp-content/uploads/2026/06/store-front-hero-mobile.webp`") center 78% / cover no-repeat;}}`n</style>"
$ids = @(7,15,18,226001,226003,226004,226005,226006,226007,226138,226144,227931,227932,227941,227942,227943,227950,227951,227952,533,711,858)

foreach ($id in $ids) {
  try {
    $page = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/${id}?context=edit" -Headers $H
    $c = $page.content.raw
    if ($c -match 'store-front-hero-mobile') { "skip $id (done)"; continue }
    # preloads right after the fonts stylesheet link
    $c = $c -replace '(family=Space\+Grotesk:wght@500;600;700&display=swap">)', ('$1' + $preloads)
    # mobile hero override appended to the style block
    $rx = New-Object System.Text.RegularExpressions.Regex("</style>")
    $c = $rx.Replace($c, $mobileCss, 1)
    $json = @{ content = $c } | ConvertTo-Json -Compress
    $null = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/$id" -Method Post -Headers $H -ContentType "application/json; charset=utf-8" -Body ([Text.Encoding]::UTF8.GetBytes($json))
    "fixed $id ($($page.slug))"
  } catch { "ERROR $id : $($_.Exception.Message)" }
}
"DONE"
