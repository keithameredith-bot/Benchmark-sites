# Add a distinguished FUB node to the BRM Recruiting workflow (source + tags fence recruits off from borrowers).
$k = (Get-Content "C:\Users\keith\.n8n-api.txt" -Raw).Trim()
$h = @{ "X-N8N-API-KEY" = $k; "Content-Type" = "application/json" }
$base = "https://benchmarkwebd.app.n8n.cloud/api/v1"
$id = "hVmQMclZV7JnVQ9z"
$NL = "`n"

$wf = Invoke-RestMethod -Uri "$base/workflows/$id" -Headers $h
if (($wf.nodes | Where-Object { $_.name -eq "FUB recruit" })) { "already added"; exit }

$fubBody = '={' + $NL + '  "source": "LO RECRUITING - Work With Us",' + $NL + '  "system": "Benchmark Web Design",' + $NL + '  "type": "Registration",' + $NL + '  "message": "LO RECRUIT (not a mortgage lead).\nNMLS: {{ $json.nmls }}\n{{ $json.summaryEscaped }}\nPage: {{ $json.page }}",' + $NL + '  "person": {' + $NL + '    "firstName": "{{ $json.first }}",' + $NL + '    "lastName": "{{ $json.last }}",' + $NL + '    "emails": [{ "value": "{{ $json.email }}" }],' + $NL + '    "phones": [{ "value": "{{ $json.phone }}" }],' + $NL + '    "tags": ["LO Recruit", "Recruiting Pipeline"]' + $NL + '  }' + $NL + '}'

$nodes = @($wf.nodes)
$nodes += @{
  name = "FUB recruit"; type = "n8n-nodes-base.httpRequest"; typeVersion = 4.2; position = @(440, 160)
  parameters = @{
    method = "POST"; url = "https://api.followupboss.com/v1/events"
    authentication = "genericCredentialType"; genericAuthType = "httpBasicAuth"
    sendHeaders = $true
    headerParameters = @{ parameters = @(@{ name = "Content-Type"; value = "application/json" }) }
    sendBody = $true; specifyBody = "json"; jsonBody = $fubBody
    options = @{}
  }
  credentials = @{ httpBasicAuth = @{ id = "Opqzt9o1dsjvitwx"; name = "Unnamed credential" } }
}
$conns = @{
  "Webhook" = @{ main = @(, @(@{ node = "Format lead"; type = "main"; index = 0 })) }
  "Format lead" = @{ main = @(, @(
      @{ node = "Telegram alert"; type = "main"; index = 0 },
      @{ node = "FUB recruit"; type = "main"; index = 0 }
  )) }
}
$update = @{ name = $wf.name; nodes = $nodes; connections = $conns; settings = @{ executionOrder = "v1" } } | ConvertTo-Json -Depth 14
$null = Invoke-RestMethod -Method Put -Uri "$base/workflows/$id" -Headers $h -Body ([System.Text.Encoding]::UTF8.GetBytes($update))
"FUB recruit node added + wired"
# re-activate (PUT can deactivate)
try { $null = Invoke-RestMethod -Method Post -Uri "$base/workflows/$id/activate" -Headers $h; "re-activated" } catch { "already active" }

# test fire
Start-Sleep 2
$body = "name=TEST RecruitFUB&first=TEST&last=RecruitFUB&phone=3525550103&email=test4@test.com&nmls=888888&role=Retail / mortgage banker&volume=6-10 loans / month&states=2-5 states&branding=Coast 2 Coast branding / team name&timeline=Ready to move now&message=FUB distinction test - ignore&source=LO recruiting&page=test"
$null = Invoke-RestMethod -Method Post -Uri "https://benchmarkwebd.app.n8n.cloud/webhook/brm-recruiting" -Body $body -ContentType "application/x-www-form-urlencoded"
Start-Sleep 4
$ex = Invoke-RestMethod -Uri "$base/executions?limit=2" -Headers $h
$ex.data | Select-Object id, workflowId, status | Format-Table