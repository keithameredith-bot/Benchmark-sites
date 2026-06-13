# FGS full verification sweep -- pages: 200, exactly one H1, self-canonical, meta description, no broken images.
# usage: .\verify-all.ps1 [-BASE https://staging-url]   (location pages are drafts; pass -IncludeDrafts after publishing)
param([string]$BASE = "http://fsg.local", [switch]$IncludeDrafts)
$pages = @(
  "/", "/about/", "/contact/", "/free-quote/", "/services/", "/our-mission/", "/gallery/", "/privacy-policy/",
  "/geotechnical-engineering-services-florida/", "/sinkhole-investigation-florida/",
  "/geotechnical-drilling-services-florida/", "/soil-testing-laboratory-services-florida/",
  "/construction-materials-testing-florida/", "/concrete-and-asphalt-testing-florida/",
  "/pavement-design-evaluation-florida/", "/environmental-site-assessment-florida/",
  "/ground-penetrating-radar-gpr-florida/", "/foundation-engineering-florida/"
)
if ($IncludeDrafts) {
  $pages += @(
    "/geotechnical-engineering-gainesville-fl/", "/geotechnical-engineering-the-villages-fl/",
    "/geotechnical-engineering-sumter-county-fl/", "/sinkhole-inspection-citrus-county-fl/",
    "/geotechnical-engineering-lake-county-fl/", "/geotechnical-engineering-putnam-county-fl/"
  )
}
$fail = 0
foreach ($u in $pages) {
  try { $r = Invoke-WebRequest -Uri "$BASE$u" -UseBasicParsing -TimeoutSec 30 } catch { "FAIL $u -- HTTP error"; $fail++; continue }
  $h = $r.Content
  $issues = @()
  $h1s = [regex]::Matches($h, '<h1[\s>]').Count
  if ($h1s -ne 1) { $issues += "h1=$h1s" }
  $canon = [regex]::Match($h, '<link rel="canonical" href="([^"]+)"').Groups[1].Value
  if ($canon -ne "$BASE$u") { $issues += "canonical=$canon" }
  if (-not ($h -match '<meta name="description" content="[^"]{40,}')) { $issues += "no-meta-desc" }
  # placeholders are INTENTIONAL until client photos arrive (Keith 2026-06-11) -- warn, don't fail
  if ($h -match '(src|data-src)="https://placehold\.co') { "WARN $u -- placeholder image (expected until client photos)" }
  $imgs = [regex]::Matches($h, '<img[^>]+(?:data-src|src)="(/wp-content/uploads/[^"]+)"') | ForEach-Object { $_.Groups[1].Value } | Sort-Object -Unique
  foreach ($img in $imgs) { try { $null = Invoke-WebRequest -Uri "$BASE$img" -Method Head -UseBasicParsing } catch { $issues += "broken-img:$img" } }
  if ($issues.Count) { "FAIL $u -- $($issues -join ' | ')"; $fail++ } else { "OK   $u" }
}
# redirects (apply on production at launch -- see redirects.csv; only checked when not on local)
if ($BASE -notmatch "fsg.local") {
  foreach ($pair in @(,@("/services/geotechnical-engineering", "/geotechnical-engineering-services-florida/"))) {
    try { $r = Invoke-WebRequest -Uri "$BASE$($pair[0])" -UseBasicParsing -MaximumRedirection 0 -ErrorAction SilentlyContinue } catch { $r = $_.Exception.Response }
    $loc = "$($r.Headers.Location)"
    if (([int]$r.StatusCode -eq 301) -and ($loc -match [regex]::Escape($pair[1]))) { "OK   301 $($pair[0]) -> $($pair[1])" } else { "FAIL 301 $($pair[0]) got $([int]$r.StatusCode) -> $loc"; $fail++ }
  }
}
# OG + theme-color on homepage
$homeHtml = (Invoke-WebRequest -Uri "$BASE/" -UseBasicParsing).Content
if ($homeHtml -match 'property="og:image" content="[^"]*fgs-og-image') { "OK   og:image" } else { "FAIL og:image missing"; $fail++ }
if ($homeHtml -match 'name="theme-color" content="#a91513"') { "OK   theme-color" } else { "FAIL theme-color missing"; $fail++ }
"====="
if ($fail) { "FAILURES: $fail" } else { "ALL CHECKS PASSED" }
