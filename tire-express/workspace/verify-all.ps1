# Tire Express full verification sweep -- pages: 200, exactly one H1, self-canonical, meta description, no broken images.
# usage: .\verify-all.ps1 [-BASE https://staging-url]
param([string]$BASE = "http://tire-express.local")
$pages = @(
  "/", "/services/", "/about-us/", "/our-team/", "/testimonials/", "/our-gallery/", "/our-faqs/", "/blogs/", "/contact-us/", "/accessibility/", "/privacy-policy/",
  "/new-tires-in-ocala/", "/used-tires-ocala/", "/tire-repair-ocala/", "/tire-installation-ocala/", "/tire-balancing-and-rotation/", "/wheel-alignment-ocala/", "/lifted-truck-tires-ocala/",
  "/oil-change-in-ocala/", "/brake-jobs-in-ocala/", "/battery-replacement-in-ocala/", "/tune-ups-in-ocala/", "/car-air-conditioning-recharge/", "/cv-axle-replacement-ocala/", "/fleet-maintenance-in-ocala/",
  "/florida-heat-tire-warning-signs-ocala/", "/car-ac-not-blowing-cold-ocala/", "/tire-rotation-in-ocala/"
)
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
  $imgs = [regex]::Matches($h, '<img[^>]+(?:data-src|src)="(/wp-content/uploads/[^"]+)"') | ForEach-Object { $_.Groups[1].Value } | Sort-Object -Unique
  foreach ($img in $imgs) { try { $null = Invoke-WebRequest -Uri "$BASE$img" -Method Head -UseBasicParsing } catch { $issues += "broken-img:$img" } }
  if ($issues.Count) { "FAIL $u -- $($issues -join ' | ')"; $fail++ } else { "OK   $u" }
}
# redirects
foreach ($pair in @(,@("/our-testimonial/", "/testimonials/"))) {
  try { $r = Invoke-WebRequest -Uri "$BASE$($pair[0])" -UseBasicParsing -MaximumRedirection 0 -ErrorAction SilentlyContinue } catch { $r = $_.Exception.Response }
  $loc = "$($r.Headers.Location)"
  if (([int]$r.StatusCode -eq 301) -and ($loc -match [regex]::Escape($pair[1]))) { "OK   301 $($pair[0]) -> $($pair[1])" } else { "FAIL 301 $($pair[0]) got $([int]$r.StatusCode) -> $loc"; $fail++ }
}
"====="
if ($fail) { "FAILURES: $fail" } else { "ALL CHECKS PASSED" }
