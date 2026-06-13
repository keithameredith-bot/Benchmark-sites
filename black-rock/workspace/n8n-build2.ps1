# n8n build v2 (ASCII-safe): create+activate BRM Recruiting, upgrade brm-preapproval formatter.
$k = (Get-Content "C:\Users\keith\.n8n-api.txt" -Raw).Trim()
$h = @{ "X-N8N-API-KEY" = $k; "Content-Type" = "application/json" }
$base = "https://benchmarkwebd.app.n8n.cloud/api/v1"

# emoji via code points (PS 5.1-safe)
$eHands = [char]::ConvertFromUtf32(0x1F91D)  # handshake
$eHouse = [char]::ConvertFromUtf32(0x1F3E0)
$ePerson = [char]::ConvertFromUtf32(0x1F464)
$ePhone = [char]::ConvertFromUtf32(0x1F4DE)
$eMail = [char]::ConvertFromUtf32(0x2709) + [char]0xFE0F
$ePage = [char]::ConvertFromUtf32(0x1F4C4)
$NL = "`n"

$fmtCode = @'
const b = $input.first().json.body || {};
const labels = {purpose:'Looking to',land:'Land',hometype:'Home type',year:'Year built',moved:'Moved',
plans:'Plans',builder:'Builder',budget:'Budget',program:'Program',ground:'Break ground',
credit:'Credit',timeline:'Timeline',topic:'Topic',message:'Message',role:'Role',volume:'Volume',
states:'Licensed states',branding:'Branding choice',nmls:'NMLS #',amount:'Amount',stage:'Stage',goal:'Goal'};
const skip = ['first','last','name','page','source','phone','email'];
const lines = [];
for (const [key, val] of Object.entries(b)) {
  if (!val || skip.includes(key)) continue;
  lines.push((labels[key] || key) + ': ' + val);
}
return [{ json: { ...b, summary: lines.join('\n'), summaryEscaped: lines.join('\\n') } }];
'@

# ---------- 1. BRM Recruiting ----------
$tgRecruitText = '=' + $eHands + ' NEW LO RECRUIT - Work With Us page' + $NL + $NL + $ePerson + ' {{ $json.name }}   (NMLS: {{ $json.nmls }})' + $NL + $ePhone + ' {{ $json.phone }}' + $NL + $eMail + ' {{ $json.email }}' + $NL + $NL + '{{ $json.summary }}' + $NL + $NL + $ePage + ' {{ $json.page }}'

$recruit = @{
  name = "BRM Recruiting - LO Leads"
  settings = @{ executionOrder = "v1" }
  nodes = @(
    @{ name = "Webhook"; type = "n8n-nodes-base.webhook"; typeVersion = 2; position = @(0, 0)
       parameters = @{ httpMethod = "POST"; path = "brm-recruiting"; options = @{} } },
    @{ name = "Format lead"; type = "n8n-nodes-base.code"; typeVersion = 2; position = @(220, 0)
       parameters = @{ jsCode = $fmtCode } },
    @{ name = "Telegram alert"; type = "n8n-nodes-base.telegram"; typeVersion = 1.2; position = @(440, 0)
       parameters = @{ chatId = "2006955250"; text = $tgRecruitText; additionalFields = @{} }
       credentials = @{ telegramApi = @{ id = "mOYcH4MrZV4yQEar"; name = "Telegram account 2" } } }
  )
  connections = @{
    "Webhook" = @{ main = @(, @(@{ node = "Format lead"; type = "main"; index = 0 })) }
    "Format lead" = @{ main = @(, @(@{ node = "Telegram alert"; type = "main"; index = 0 })) }
  }
}
$body = $recruit | ConvertTo-Json -Depth 14
$r = Invoke-RestMethod -Method Post -Uri "$base/workflows" -Headers $h -Body ([System.Text.Encoding]::UTF8.GetBytes($body))
"created BRM Recruiting: $($r.id)"
$null = Invoke-RestMethod -Method Post -Uri "$base/workflows/$($r.id)/activate" -Headers $h
"activated: /webhook/brm-recruiting LIVE"

# ---------- 2. upgrade brm-preapproval ----------
$wf = Invoke-RestMethod -Uri "$base/workflows/gynQw95S8WbHcyGm" -Headers $h
$tgLeadText = '=' + $eHouse + ' NEW LEAD - {{ $json.source }}' + $NL + $NL + $ePerson + ' {{ $json.first }} {{ $json.last }}' + $NL + $ePhone + ' {{ $json.phone }}' + $NL + $eMail + ' {{ $json.email }}' + $NL + $NL + '{{ $json.summary }}' + $NL + $NL + $ePage + ' Page: {{ $json.page }}'
$fubBody = '={' + $NL + '  "source": "Black Rock Mortgage Website",' + $NL + '  "system": "Benchmark Web Design",' + $NL + '  "type": "Registration",' + $NL + '  "message": "{{ $json.source }} from website.\n{{ $json.summaryEscaped }}\nSource page: {{ $json.page }}",' + $NL + '  "person": {' + $NL + '    "firstName": "{{ $json.first }}",' + $NL + '    "lastName": "{{ $json.last }}",' + $NL + '    "emails": [{ "value": "{{ $json.email }}" }],' + $NL + '    "phones": [{ "value": "{{ $json.phone }}" }],' + $NL + '    "tags": ["Website Lead", "{{ $json.source }}"]' + $NL + '  }' + $NL + '}'

$nodes = @()
foreach ($n in $wf.nodes) {
    if ($n.name -eq "Send a text message") { $n.parameters.text = $tgLeadText }
    if ($n.name -eq "HTTP Request") { $n.parameters.jsonBody = $fubBody }
    $nodes += $n
}
$nodes += @{ name = "Format lead"; type = "n8n-nodes-base.code"; typeVersion = 2; position = @(280, -140)
             parameters = @{ jsCode = $fmtCode } }
$conns = @{
    "Webhook" = @{ main = @(, @(@{ node = "Format lead"; type = "main"; index = 0 })) }
    "Format lead" = @{ main = @(, @(
        @{ node = "Send a text message"; type = "main"; index = 0 },
        @{ node = "HTTP Request"; type = "main"; index = 0 }
    )) }
}
$update = @{ name = $wf.name; nodes = $nodes; connections = $conns; settings = @{ executionOrder = "v1" } } | ConvertTo-Json -Depth 14
$null = Invoke-RestMethod -Method Put -Uri "$base/workflows/gynQw95S8WbHcyGm" -Headers $h -Body ([System.Text.Encoding]::UTF8.GetBytes($update))
"brm-preapproval upgraded with universal formatter"
