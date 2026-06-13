# n8n build: (1) create+activate BRM Recruiting workflow, (2) upgrade brm-preapproval with universal formatter.
$k = (Get-Content "C:\Users\keith\.n8n-api.txt" -Raw).Trim()
$h = @{ "X-N8N-API-KEY" = $k; "Content-Type" = "application/json" }
$base = "https://benchmarkwebd.app.n8n.cloud/api/v1"

# ---------- shared formatter code ----------
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

# ---------- 1. BRM Recruiting workflow ----------
$recruit = @{
  name = "BRM Recruiting - LO Leads"
  settings = @{ executionOrder = "v1" }
  nodes = @(
    @{
      name = "Webhook"; type = "n8n-nodes-base.webhook"; typeVersion = 2; position = @(0, 0)
      parameters = @{ httpMethod = "POST"; path = "brm-recruiting"; options = @{} }
    },
    @{
      name = "Format lead"; type = "n8n-nodes-base.code"; typeVersion = 2; position = @(220, 0)
      parameters = @{ jsCode = $fmtCode }
    },
    @{
      name = "Telegram alert"; type = "n8n-nodes-base.telegram"; typeVersion = 1.2; position = @(440, 0)
      parameters = @{
        chatId = "2006955250"
        text = '=🤝 NEW LO RECRUIT — Work With Us page' + "`n`n" + '👤 {{ $json.name }}' + "`n" + '📞 {{ $json.phone }}' + "`n" + '✉️ {{ $json.email }}' + "`n`n" + '{{ $json.summary }}' + "`n`n" + '📄 {{ $json.page }}'
        additionalFields = @{}
      }
      credentials = @{ telegramApi = @{ id = "mOYcH4MrZV4yQEar"; name = "Telegram account 2" } }
    }
  )
  connections = @{
    "Webhook" = @{ main = @(, @(@{ node = "Format lead"; type = "main"; index = 0 })) }
    "Format lead" = @{ main = @(, @(@{ node = "Telegram alert"; type = "main"; index = 0 })) }
  }
}
$body = $recruit | ConvertTo-Json -Depth 14
$r = Invoke-RestMethod -Method Post -Uri "$base/workflows" -Headers $h -Body $body
"created BRM Recruiting: $($r.id)"
$null = Invoke-RestMethod -Method Post -Uri "$base/workflows/$($r.id)/activate" -Headers $h
"activated: /webhook/brm-recruiting LIVE"

# ---------- 2. upgrade brm-preapproval ----------
$wf = Invoke-RestMethod -Uri "$base/workflows/gynQw95S8WbHcyGm" -Headers $h
$nodes = @()
foreach ($n in $wf.nodes) {
    if ($n.name -eq "Send a text message") {
        $n.parameters.text = '=🏠 NEW LEAD — {{ $json.source }}' + "`n`n" + '👤 {{ $json.first }} {{ $json.last }}' + "`n" + '📞 {{ $json.phone }}' + "`n" + '✉️ {{ $json.email }}' + "`n`n" + '{{ $json.summary }}' + "`n`n" + '📄 Page: {{ $json.page }}'
    }
    if ($n.name -eq "HTTP Request") {
        $n.parameters.jsonBody = '={' + "`n" + '  "source": "Black Rock Mortgage Website",' + "`n" + '  "system": "Benchmark Web Design",' + "`n" + '  "type": "Registration",' + "`n" + '  "message": "{{ $json.source }} from website.\n{{ $json.summaryEscaped }}\nSource page: {{ $json.page }}",' + "`n" + '  "person": {' + "`n" + '    "firstName": "{{ $json.first }}",' + "`n" + '    "lastName": "{{ $json.last }}",' + "`n" + '    "emails": [{ "value": "{{ $json.email }}" }],' + "`n" + '    "phones": [{ "value": "{{ $json.phone }}" }],' + "`n" + '    "tags": ["Website Lead", "{{ $json.source }}"]' + "`n" + '  }' + "`n" + '}'
    }
    $nodes += $n
}
# add formatter node
$nodes += @{
    name = "Format lead"; type = "n8n-nodes-base.code"; typeVersion = 2; position = @(280, -140)
    parameters = @{ jsCode = $fmtCode }
}
$conns = @{
    "Webhook" = @{ main = @(, @(@{ node = "Format lead"; type = "main"; index = 0 })) }
    "Format lead" = @{ main = @(, @(
        @{ node = "Send a text message"; type = "main"; index = 0 },
        @{ node = "HTTP Request"; type = "main"; index = 0 }
    )) }
}
$update = @{ name = $wf.name; nodes = $nodes; connections = $conns; settings = @{ executionOrder = "v1" } } | ConvertTo-Json -Depth 14
$null = Invoke-RestMethod -Method Put -Uri "$base/workflows/gynQw95S8WbHcyGm" -Headers $h -Body $update
"brm-preapproval upgraded with universal formatter"
