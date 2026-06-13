# Ask LLMs the money questions, save raw responses to seo-data\llm\.
$auth = (Get-Content "$PSScriptRoot\dfs-auth.txt" -Raw).Trim()
$h = @{ Authorization = "Basic $auth" }
$dir = "$PSScriptRoot\seo-data\llm"
if (-not (Test-Path $dir)) { New-Item -ItemType Directory $dir | Out-Null }

$prompts = @(
    "What are the best mortgage brokers in Ocala Florida?",
    "Who should I use for a USDA loan in Florida?",
    "What lender is best for manufactured home financing in Florida?",
    "How do I apply for the Florida Hometown Heroes program and which lenders participate?",
    "What are current USDA turn times in Florida and how do I check them?",
    "Best FHA lender in Florida for a first time home buyer with a 600 credit score?"
)
$engines = @(
    @{ se = "chat_gpt";   model = "gpt-4o-mini" },
    @{ se = "perplexity"; model = "sonar" }
)
$i = 0
foreach ($p in $prompts) {
    $i++
    $j = 0
    foreach ($e in $engines) {
        $j++
        $body = ConvertTo-Json @(@{ user_prompt = $p; model_name = $e.model; web_search = $true }) -Depth 4
        try {
            $raw = Invoke-WebRequest -Uri "https://api.dataforseo.com/v3/ai_optimization/$($e.se)/llm_responses/live" -Method Post -Headers $h -ContentType "application/json" -Body $body -UseBasicParsing -TimeoutSec 180
            [System.IO.File]::WriteAllText("$dir\q$i-$($e.se).json", $raw.Content)
            $ok = ($raw.Content | Select-String -Pattern '"status_message":"Ok\."' -Quiet)
            "q$i $($e.se): saved $($raw.Content.Length) bytes (ok: $ok)"
        } catch { "q$i $($e.se): ERR $($_.Exception.Message)" }
    }
}
