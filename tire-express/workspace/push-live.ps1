# Push the mobile-grid fix to PRODUCTION via WP REST API.
# Pages from workspace files: home(7), ac(226001), brake(226004), tuneups(226007), testimonials(226144)
# Pages transformed in place:  oil(226005), new-tires(226006)
$ErrorActionPreference = "Stop"
$SITE = "https://www.tireexpressandservice.com"
$cred = Get-Content "C:\Users\keith\.tire-express-rest-auth.txt"
$pw = ($cred | Where-Object { $_ -match '^app-password: (.+)$' }) -replace '^app-password: ',''
$b64 = [Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes("admin:$pw"))
$H = @{ Authorization = "Basic $b64" }

$ws = "C:\Users\keith\Desktop\tire-express-workspace"
$css = [System.IO.File]::ReadAllText("$ws\te-np.css", [Text.Encoding]::UTF8).TrimStart([char]0xFEFF).Trim()
$css = $css.Replace("http://tire-express.local", "")

$map = @{ 7 = "page-home.html"; 226001 = "page-car-air-conditioning-recharge.html"; 226004 = "page-brake-jobs-in-ocala.html"; 226007 = "page-tune-ups-in-ocala.html"; 226144 = "page-testimonials.html" }
foreach ($id in $map.Keys) {
  $body = [System.IO.File]::ReadAllText("$ws\$($map[$id])", [Text.Encoding]::UTF8).Trim()
  $content = "<!-- wp:html -->`n<!-- te-np template (pushed via REST $(Get-Date -Format yyyy-MM-dd)) -->`n<style>`n$css`n</style>`n`n$body`n<!-- /wp:html -->"
  $json = @{ content = $content } | ConvertTo-Json -Compress
  $r = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/$id" -Method Post -Headers $H -ContentType "application/json; charset=utf-8" -Body ([Text.Encoding]::UTF8.GetBytes($json))
  "pushed $id ($($map[$id])) -> $($r.link)"
}

# oil + new-tires: fetch raw, transform, push back
$util = ".te-np .incl.cols-2{grid-template-columns:repeat(2,1fr);}`n.te-np .incl.cols-4{grid-template-columns:repeat(4,1fr);}`n@media(max-width:900px){.te-np .incl.cols-4{grid-template-columns:1fr 1fr;}}`n@media(max-width:600px){.te-np .incl.cols-2,.te-np .incl.cols-4{grid-template-columns:1fr;}}`n</style>"
foreach ($id in @(226005, 226006)) {
  $page = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/${id}?context=edit" -Headers $H
  $c = $page.content.raw
  if ($c -notmatch [regex]::Escape("incl.cols-2")) {
    $rx = New-Object System.Text.RegularExpressions.Regex("</style>")
    $c = $rx.Replace($c, $util, 1)
  }
  $c = $c.Replace('class="incl" style="grid-template-columns:repeat(2,1fr);"', 'class="incl cols-2"')
  $c = $c.Replace('class="incl" style="grid-template-columns:repeat(4,1fr);"', 'class="incl cols-4"')
  $json = @{ content = $c } | ConvertTo-Json -Compress
  $r = Invoke-RestMethod -Uri "$SITE/wp-json/wp/v2/pages/$id" -Method Post -Headers $H -ContentType "application/json; charset=utf-8" -Body ([Text.Encoding]::UTF8.GetBytes($json))
  "transformed + pushed $id -> $($r.link)"
}
"DONE"
