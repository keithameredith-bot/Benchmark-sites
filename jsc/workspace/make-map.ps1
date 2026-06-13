# Build a static map image for the contact page — OSM tiles, JSC-blue pin, attribution.
# Output: jsc-map-silver-springs.png in this folder (880x560, 2x retina for ~440px sidebar display).
Add-Type -AssemblyName System.Drawing

$lat = 29.1831808; $lng = -82.1100544   # GBP pin
$zoom = 15
$W = 880; $H = 560

# slippy-map tile math
$n = [math]::Pow(2, $zoom)
$xtileF = ($lng + 180.0) / 360.0 * $n
$latRad = $lat * [math]::PI / 180.0
$ytileF = (1.0 - [math]::Log([math]::Tan($latRad) + 1.0 / [math]::Cos($latRad)) / [math]::PI) / 2.0 * $n

# pixel position of the pin in global tile space
$cxPx = $xtileF * 256; $cyPx = $ytileF * 256
$left = [math]::Floor(($cxPx - $W / 2) / 256); $right = [math]::Floor(($cxPx + $W / 2) / 256)
$top  = [math]::Floor(($cyPx - $H / 2) / 256); $bottom = [math]::Floor(($cyPx + $H / 2) / 256)

$bmp = New-Object System.Drawing.Bitmap($W, $H)
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = 'AntiAlias'
$wc = New-Object System.Net.WebClient
$wc.Headers.Add('User-Agent', 'JSC-contracting-site-build/1.0 (one-time static map; keithameredith@gmail.com)')

for ($tx = $left; $tx -le $right; $tx++) {
  for ($ty = $top; $ty -le $bottom; $ty++) {
    $sub = @('a','b','c','d')[($tx + $ty) % 4]
    $url = "https://$sub.basemaps.cartocdn.com/rastertiles/voyager/$zoom/$tx/$ty.png"
    $bytes = $wc.DownloadData($url)
    $ms = New-Object System.IO.MemoryStream(,$bytes)
    $tile = [System.Drawing.Image]::FromStream($ms)
    $dx = [int]($tx * 256 - ($cxPx - $W / 2))
    $dy = [int]($ty * 256 - ($cyPx - $H / 2))
    $g.DrawImage($tile, $dx, $dy, 256, 256)
    $tile.Dispose(); $ms.Dispose()
    Start-Sleep -Milliseconds 150
  }
}

# pin: JSC blue circle, white ring, centered
$px = [int]($W / 2); $py = [int]($H / 2)
$shadow = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(60, 0, 0, 0))
$g.FillEllipse($shadow, $px - 16, $py - 13, 34, 34)
$white = [System.Drawing.Brushes]::White
$g.FillEllipse($white, $px - 17, $py - 17, 34, 34)
$blue = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(255, 33, 102, 211))
$g.FillEllipse($blue, $px - 13, $py - 13, 26, 26)
$g.FillEllipse($white, $px - 5, $py - 5, 10, 10)

# OSM attribution (license requirement)
$font = New-Object System.Drawing.Font('Segoe UI', 9)
$text = [char]0x00A9 + ' OpenStreetMap contributors ' + [char]0x00A9 + ' CARTO'
$size = $g.MeasureString($text, $font)
$bgBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(200, 255, 255, 255))
$g.FillRectangle($bgBrush, $W - $size.Width - 8, $H - $size.Height - 4, $size.Width + 8, $size.Height + 4)
$g.DrawString($text, $font, [System.Drawing.Brushes]::Black, $W - $size.Width - 4, $H - $size.Height - 2)

$out = "C:\Users\keith\Desktop\jsc-kadence-mockup\jsc-map-silver-springs.png"
$bmp.Save($out, [System.Drawing.Imaging.ImageFormat]::Png)
$g.Dispose(); $bmp.Dispose()
"saved $out ($((Get-Item $out).Length) bytes), tiles x $left..$right y $top..$bottom"
