# Crop Keith's Google Maps screenshot around the red JSC pin -> 880x560 for the contact sidebar.
Add-Type -AssemblyName System.Drawing
$src = "C:\Users\keith\Downloads\Screenshot 2026-06-10 111116.png"
$out = "C:\Users\keith\Desktop\jsc-kadence-mockup\jsc-map-silver-springs.png"

$img = [System.Drawing.Bitmap]::FromFile($src)
"source: $($img.Width)x$($img.Height)"

# find the red Google pin (centroid of strongly-red pixels)
$sumX = 0; $sumY = 0; $count = 0
for ($y = 0; $y -lt $img.Height; $y += 2) {
  for ($x = 0; $x -lt $img.Width; $x += 2) {
    $p = $img.GetPixel($x, $y)
    if ($p.R -gt 190 -and $p.G -lt 90 -and $p.B -lt 80) { $sumX += $x; $sumY += $y; $count++ }
  }
}
if ($count -lt 5) { "NO PIN FOUND"; $img.Dispose(); exit 1 }
$pinX = [int]($sumX / $count); $pinY = [int]($sumY / $count) + 8  # nudge toward pin tip
"pin at $pinX,$pinY ($count red px)"

# largest 11:7 crop centered on the pin that fits the image
$ratio = 880 / 560
$cw = $img.Width; $ch = [int]($cw / $ratio)
if ($ch -gt $img.Height) { $ch = $img.Height; $cw = [int]($ch * $ratio) }
$cx = [math]::Max(0, [math]::Min($img.Width - $cw, $pinX - [int]($cw / 2)))
$cy = [math]::Max(0, [math]::Min($img.Height - $ch, $pinY - [int]($ch / 2)))
"crop: $cw x $ch at $cx,$cy"

$bmp = New-Object System.Drawing.Bitmap(880, 560)
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.InterpolationMode = 'HighQualityBicubic'
$srcRect = New-Object System.Drawing.Rectangle($cx, $cy, $cw, $ch)
$dstRect = New-Object System.Drawing.Rectangle(0, 0, 880, 560)
$g.DrawImage($img, $dstRect, $srcRect, [System.Drawing.GraphicsUnit]::Pixel)
$bmp.Save($out, [System.Drawing.Imaging.ImageFormat]::Png)
$g.Dispose(); $bmp.Dispose(); $img.Dispose()
"saved $out"
