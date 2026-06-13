# Derive va-construction-form.html from construction-form.html (UTF-8 safe, entities only).
# Changes: VA-flavored copy, NO program step (we know it's VA), budget scaled up w/ $1M+ (VA jumbo).
$utf8 = New-Object System.Text.UTF8Encoding($false)
$dir = "C:\Users\keith\Local Sites\black-rock-mortgage\app\public\wp-content\uploads\forms"
$c = [System.IO.File]::ReadAllText("$dir\construction-form.html", [System.Text.Encoding]::UTF8)

# 1. intro copy -> VA
$c = $c.Replace('<div class="eyebrow">Construction check &middot; no credit pull</div>', '<div class="eyebrow">VA construction check &middot; no credit pull</div>')
$c = $c.Replace('<h1>Let&rsquo;s plan your build.</h1>', '<h1>Let&rsquo;s plan your VA build.</h1>')
$c = $c.Replace('<p class="sub">One-time-close construction loans &mdash; FHA, VA, USDA, and conventional. A few quick questions first.</p>', '<p class="sub">$0 down with your VA entitlement, one closing &mdash; and with full entitlement there&rsquo;s no loan cap. A few quick questions first.</p>')

# 2. budget options scaled for VA (incl jumbo) + sub note
$c = $c.Replace('<p class="sub">Land + build, rough number &mdash; we&rsquo;ll dial it in later.</p>', '<p class="sub">Land + build, rough number. Full entitlement means no VA loan cap &mdash; yes, we do VA jumbo.</p>')
$old = '<button class="opt" data-val="Under $250k"><span class="t">Under $250k</span></button>
<button class="opt" data-val="$250k-$400k"><span class="t">$250k&ndash;$400k</span></button>
<button class="opt" data-val="$400k-$600k"><span class="t">$400k&ndash;$600k</span></button>
<button class="opt" data-val="$600k+"><span class="t">$600k+</span></button>
<button class="opt" data-val="Not sure"><span class="t">Not sure yet</span></button>'
$new = '<button class="opt" data-val="Under $400k"><span class="t">Under $400k</span></button>
<button class="opt" data-val="$400k-$700k"><span class="t">$400k&ndash;$700k</span></button>
<button class="opt" data-val="$700k-$1M"><span class="t">$700k&ndash;$1M</span></button>
<button class="opt" data-val="$1M+ (VA jumbo)"><span class="t">$1M+ &mdash; VA jumbo</span></button>
<button class="opt" data-val="Not sure"><span class="t">Not sure yet</span></button>'
$c = $c.Replace($old, $new)

# 3. remove the PROGRAM screen entirely
$c = [regex]::Replace($c, '(?s)<!-- 5: PROGRAM -->.*?</section>\s*(?=<!-- 6: GROUND -->)', '')

# 4. order/labels/payload/recap/source — drop program
$c = $c.Replace('let order=["land","plans","builder","budget","program","ground","contact"];', 'let order=["land","plans","builder","budget","ground","contact"];')
$c = $c.Replace('const labels={land:"Your land",plans:"Plans",builder:"Builder",budget:"Budget",program:"Program",ground:"Timeline",contact:"Contact",done:"Done"};', 'const labels={land:"Your land",plans:"Plans",builder:"Builder",budget:"Budget",ground:"Timeline",contact:"Contact",done:"Done"};')
$c = $c.Replace('["Program", data.program],', '')
$c = $c.Replace("budget:data.budget||'', program:data.program||'', ground:data.ground||'',", "budget:data.budget||'', program:'VA', ground:data.ground||'',")
$c = $c.Replace("source:'Construction loan form',", "source:'VA construction form',")

[System.IO.File]::WriteAllText("$dir\va-construction-form.html", $c, $utf8)
$check = [System.IO.File]::ReadAllText("$dir\va-construction-form.html", [System.Text.Encoding]::UTF8)
$mojiPattern = [string][char]0x00E2 + [char]0x20AC + '|' + [char]0x00F0 + [char]0x0178
"va-construction-form.html: $((Get-Item "$dir\va-construction-form.html").Length) bytes | screens:$([regex]::Matches($check,'class="screen').Count) | jumbo:$($check.Contains('VA jumbo')) | program-screen-gone:$(-not $check.Contains('<!-- 5: PROGRAM -->')) | mojibake:$($check -match $mojiPattern)"