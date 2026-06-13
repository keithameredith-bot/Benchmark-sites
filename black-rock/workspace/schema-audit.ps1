# Parse all JSON-LD blocks on key pages; report node DECLARATIONS (@type+@id) and true duplicate declarations.
function Audit-Page($url) {
    $h = curl.exe -s -L $url | Out-String
    $blocks = [regex]::Matches($h, '<script type="application/ld\+json"[^>]*>(.*?)</script>', 'Singleline')
    "== $url : $($blocks.Count) JSON-LD blocks"
    $decls = @{}
    $bi = 0
    foreach ($b in $blocks) {
        $bi++
        try { $j = $b.Groups[1].Value | ConvertFrom-Json } catch { "   block ${bi}: PARSE ERROR"; continue }
        $nodes = @()
        if ($j.'@graph') { $nodes = $j.'@graph' } else { $nodes = @($j) }
        foreach ($n in $nodes) {
            $t = $n.'@type'; if ($t -is [array]) { $t = $t -join '+' }
            $id = $n.'@id'
            if ($id) {
                $key = $id
                if ($decls.ContainsKey($key)) { $decls[$key] += ",$t(b$bi)" } else { $decls[$key] = "$t(b$bi)" }
            } else {
                "   block ${bi}: $t (no @id)"
            }
        }
    }
    foreach ($k in $decls.Keys) {
        $v = $decls[$k]
        $short = $k -replace 'https?://[^/]+',''
        if ($v -match ',') { "   DUP-DECL: $short => $v" } else { "   ok: $short => $v" }
    }
}
Audit-Page "http://black-rock-mortgage.local/fha-home-mortgage-loan/"
""
Audit-Page "http://black-rock-mortgage.local/florida-physician-loan/"
