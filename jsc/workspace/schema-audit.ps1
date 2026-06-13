# Dump every JSON-LD node on key pages: @type / @id + checks for org identity, provider refs, dupes.
$urls = @(
  "http://jsc.local/",
  "http://jsc.local/barndominium-builders-in-florida/",
  "http://jsc.local/central-florida-dock-builder/",
  "http://jsc.local/container-home-builders-in-florida/",
  "http://jsc.local/contact/",
  "http://jsc.local/get-a-free-quote/",
  "http://jsc.local/blog/barndominium-cost-central-florida-2026/"
)

foreach ($u in $urls) {
  Write-Host "`n===== $u ====="
  $html = (Invoke-WebRequest -Uri $u -UseBasicParsing).Content
  $scripts = [regex]::Matches($html, '(?s)<script type="application/ld\+json"[^>]*>(.*?)</script>')
  $orgIds = @()
  foreach ($s in $scripts) {
    try { $j = $s.Groups[1].Value | ConvertFrom-Json } catch { Write-Host "  !! UNPARSEABLE JSON-LD"; continue }
    $nodes = if ($j.'@graph') { $j.'@graph' } else { @($j) }
    foreach ($n in $nodes) {
      $type = ($n.'@type' | ForEach-Object { $_ }) -join '+'
      $line = "  [$type] $($n.'@id')"
      if ($n.provider) { $line += "  provider->$($n.provider.'@id')" }
      if ($n.author)   { $aid = $n.author.'@id'; if (-not $aid) { $aid = $n.author.name }; $line += "  author->$aid" }
      Write-Host $line
      if ($type -match 'Organization|LocalBusiness|GeneralContractor|HomeAndConstructionBusiness') { $orgIds += $n.'@id' }
      if ($n.aggregateRating) { Write-Host "  !! aggregateRating PRESENT on $type" }
      if ($type -match 'Organization|Contractor|LocalBusiness') {
        if ($n.openingHoursSpecification -or $n.openingHours) { Write-Host "    hours: yes" }
        if ($n.address) { Write-Host "    address: $($n.address.streetAddress), $($n.address.addressLocality) $($n.address.postalCode)" }
        if ($n.telephone) { Write-Host "    tel: $($n.telephone)" }
        if ($n.hasCredential) { Write-Host "    credential: $(($n.hasCredential | ConvertTo-Json -Compress -Depth 4))" }
      }
    }
  }
  if ($orgIds.Count -gt 1) { Write-Host "  !! MULTIPLE ORG-LIKE NODES: $($orgIds -join ' | ')" }
}
