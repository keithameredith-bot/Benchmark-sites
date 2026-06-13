# Generate manufactured-form.html + construction-form.html from preapproval-form.html.
# Keeps all CSS/machinery; swaps screens, labels, flow, recap, payload, source.
$base = Get-Content "C:\Users\keith\Local Sites\black-rock-mortgage\app\public\wp-content\uploads\forms\preapproval-form.html" -Raw
$dir = "C:\Users\keith\Local Sites\black-rock-mortgage\app\public\wp-content\uploads\forms"

# ---------- shared surgical helpers ----------
function Build-Form($screens, $labels, $orderInit, $startStep, $recapRows, $payloadFields, $sourceName, $outFile) {
    $c = $base

    # 1. replace screens between PURPOSE marker and CONTACT marker
    $s = $c.IndexOf('<!-- 1: PURPOSE -->')
    $e = $c.IndexOf('<!-- 6: CONTACT -->')
    $c = $c.Substring(0, $s) + $screens + "`n" + $c.Substring($e)

    # 2. labels object
    $c = $c -replace [regex]::Escape('const labels={purpose:"Get started",buy_stage:"Your timeline",refi_goal:"Your goal",
    amount:"Loan size",credit:"Credit",timeline:"Timeline",contact:"Contact",done:"Done"};'), $labels

    # 3. order init + start step
    $c = $c.Replace('let order=["purpose"];', $orderInit)
    $c = $c.Replace('show("purpose");', "show(`"$startStep`");")

    # 4. remove purpose-branching block (linear flows)
    $branch = @'
      if(group.dataset.field==="purpose"){
        const branch=opt.dataset.next;
        order=["purpose",branch];
        if(branch!=="timeline"){order.push("amount","credit");}
        order.push("timeline","contact");
        order=order.filter((s,i)=>order.indexOf(s)===i);
      }
'@
    $c = $c.Replace($branch, '')

    # 5. remove the amount-title special case (no amtTitle element in new flows)
    $amtBlock = @'
    if(step==="amount"){
      document.getElementById('amtTitle').textContent =
        data.purpose==="Purchase" ? "What price range are you considering?"
        : "Roughly what's your home worth?";
    }
'@
    $c = $c.Replace($amtBlock, '')

    # 6. recap rows
    $recapOld = @'
    const rows=[
      ["Looking to", data.purpose],
      data.stage?["Stage", data.stage]:null,
      data.goal?["Goal", data.goal]:null,
      data.amount?[data.purpose==="Purchase"?"Price range":"Home value", data.amount]:null,
      data.credit?["Credit", data.credit]:null,
      ["Timeline", data.timeline],
      ["Contact", data.phone],
    ].filter(Boolean);
'@
    $c = $c.Replace($recapOld, $recapRows)

    # 7. payload fields
    $payloadOld = @'
        purpose:data.purpose||'', stage:data.stage||'', goal:data.goal||'',
        amount:data.amount||'', credit:data.credit||'', timeline:data.timeline||'',
        source:'Website pre-approval form',
'@
    $c = $c.Replace($payloadOld, $payloadFields)

    [System.IO.File]::WriteAllText("$dir\$outFile", $c)
    "$outFile written: $((Get-Item "$dir\$outFile").Length) bytes"
}

# ============ MANUFACTURED FORM ============
$mfgScreens = @'
<!-- 1: PURPOSE -->
<section class="screen on" data-step="purpose">
<div class="eyebrow">Manufactured home check · no credit pull</div>
<h1>Let's get your manufactured home financed.</h1>
<p class="sub">A few quick questions — singlewides welcome, and yes, we do this every month.</p>
<div class="opts" data-field="purpose">
<button class="opt" data-val="Buying"><span class="ic">🏠</span><span><span class="t">Buying</span><span class="d">A manufactured home, new or existing</span></span></button>
<button class="opt" data-val="Refinancing"><span class="ic">🔁</span><span><span class="t">Refinancing</span><span class="d">Lower my rate or take cash out</span></span></button>
</div>
</section>

<!-- 2: LAND -->
<section class="screen" data-step="land">
<div class="eyebrow">The setup</div>
<h1>Is the home on its own land?</h1>
<p class="sub">This is the single biggest factor in which programs fit.</p>
<div class="opts" data-field="land">
<button class="opt" data-val="Home with its own land"><span class="ic">🌳</span><span class="t">Home with its own land</span></button>
<button class="opt" data-val="Home only (park / leased lot)"><span class="ic">🏘️</span><span class="t">Home only — park or leased lot</span></button>
<button class="opt" data-val="Buying home and land together"><span class="ic">🧩</span><span class="t">Buying home + land together</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">Not sure yet</span></button>
</div>
</section>

<!-- 3: TYPE -->
<section class="screen" data-step="hometype">
<div class="eyebrow">The home</div>
<h1>What type of home is it?</h1>
<p class="sub">We finance them all — including singlewides most lenders won't touch.</p>
<div class="opts" data-field="hometype">
<button class="opt" data-val="Singlewide"><span class="ic">▭</span><span class="t">Singlewide</span></button>
<button class="opt" data-val="Doublewide"><span class="ic">⬜</span><span class="t">Doublewide</span></button>
<button class="opt" data-val="Triplewide / Modular"><span class="ic">🏡</span><span class="t">Triplewide / Modular</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">Not sure yet</span></button>
</div>
</section>

<!-- 4: YEAR -->
<section class="screen" data-step="year">
<div class="eyebrow">Quick history</div>
<h1>Roughly what year was it built?</h1>
<p class="sub">A ballpark is fine — this decides which programs are on the table.</p>
<div class="opts" data-field="year">
<button class="opt" data-val="1994 or newer"><span class="ic">✨</span><span class="t">1994 or newer</span></button>
<button class="opt" data-val="1976–1993"><span class="ic">📅</span><span class="t">1976–1993</span></button>
<button class="opt" data-val="Before 1976"><span class="ic">🕰️</span><span class="t">Before 1976</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">Not sure</span></button>
</div>
</section>

<!-- 5: MOVED -->
<section class="screen" data-step="moved">
<div class="eyebrow">One more on the home</div>
<h1>Has the home ever been moved?</h1>
<p class="sub">Moved homes CAN be financed — we just need to match the right program.</p>
<div class="opts" data-field="moved">
<button class="opt" data-val="Never moved"><span class="ic">📍</span><span class="t">Still on its original site</span></button>
<button class="opt" data-val="Moved once"><span class="ic">🚚</span><span class="t">Moved once</span></button>
<button class="opt" data-val="Moved more than once"><span class="ic">🔁</span><span class="t">Moved more than once</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">Not sure</span></button>
</div>
</section>

<!-- 6: CREDIT -->
<section class="screen" data-step="credit">
<div class="eyebrow">Your estimate is fine</div>
<h1>How's your credit looking?</h1>
<p class="sub">No pull happens here — just your best guess so I can match the right program.</p>
<div class="opts" data-field="credit">
<button class="opt" data-val="Excellent (740+)"><span class="ic">⭐</span><span class="t">Excellent — 740+</span></button>
<button class="opt" data-val="Good (680–739)"><span class="ic">👍</span><span class="t">Good — 680–739</span></button>
<button class="opt" data-val="Fair (620–679)"><span class="ic">🙂</span><span class="t">Fair — 620–679</span></button>
<button class="opt" data-val="Below 620 / rebuilding"><span class="ic">🛠️</span><span class="t">Below 620 / rebuilding</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">I'm not sure</span></button>
</div>
</section>

<!-- 7: TIMELINE -->
<section class="screen" data-step="timeline">
<div class="eyebrow">Almost there</div>
<h1>When are you hoping to move forward?</h1>
<p class="sub">No pressure — this just helps me prioritize.</p>
<div class="opts" data-field="timeline">
<button class="opt" data-val="As soon as possible"><span class="ic">🚀</span><span class="t">As soon as possible</span></button>
<button class="opt" data-val="1–3 months"><span class="ic">📅</span><span class="t">1–3 months</span></button>
<button class="opt" data-val="3–6 months"><span class="ic">🗓️</span><span class="t">3–6 months</span></button>
<button class="opt" data-val="Just researching"><span class="ic">📚</span><span class="t">Just researching</span></button>
</div>
</section>

'@
$mfgLabels = @'
const labels={purpose:"Get started",land:"The setup",hometype:"Home type",year:"Year built",
    moved:"Move history",credit:"Credit",timeline:"Timeline",contact:"Contact",done:"Done"};
'@
$mfgOrder = 'let order=["purpose","land","hometype","year","moved","credit","timeline","contact"];'
$mfgRecap = @'
    const rows=[
      ["Looking to", data.purpose],
      ["Land", data.land],
      ["Home type", data.hometype],
      ["Year built", data.year],
      ["Moved", data.moved],
      data.credit?["Credit", data.credit]:null,
      ["Timeline", data.timeline],
      ["Contact", data.phone],
    ].filter(Boolean);
'@
$mfgPayload = @'
        purpose:data.purpose||'', land:data.land||'', hometype:data.hometype||'',
        year:data.year||'', moved:data.moved||'',
        credit:data.credit||'', timeline:data.timeline||'',
        source:'Manufactured home form',
'@
Build-Form $mfgScreens $mfgLabels $mfgOrder 'purpose' $mfgRecap $mfgPayload 'Manufactured home form' 'manufactured-form.html'

# ============ CONSTRUCTION FORM ============
$conScreens = @'
<!-- 1: LAND -->
<section class="screen on" data-step="land">
<div class="eyebrow">Construction check · no credit pull</div>
<h1>Let's plan your build.</h1>
<p class="sub">One-time-close construction loans — FHA, VA, USDA, and conventional. A few quick questions first.</p>
<div class="opts" data-field="land">
<button class="opt" data-val="Own land already"><span class="ic">🌳</span><span><span class="t">I own my land</span><span class="d">Paid off or financed</span></span></button>
<button class="opt" data-val="Under contract on land"><span class="ic">📝</span><span><span class="t">Land under contract</span><span class="d">Closing on it soon</span></span></button>
<button class="opt" data-val="Still looking for land"><span class="ic">🔍</span><span><span class="t">Still looking for land</span><span class="d">We can finance land + build together</span></span></button>
</div>
</section>

<!-- 2: PLANS -->
<section class="screen" data-step="plans">
<div class="eyebrow">The vision</div>
<h1>Do you have building plans yet?</h1>
<p class="sub">Blueprints, a floor plan from a builder, or just ideas — all fine.</p>
<div class="opts" data-field="plans">
<button class="opt" data-val="Plans ready"><span class="ic">📐</span><span class="t">Plans / blueprints ready</span></button>
<button class="opt" data-val="Working on plans"><span class="ic">✏️</span><span class="t">Working on plans now</span></button>
<button class="opt" data-val="No plans yet"><span class="ic">💭</span><span class="t">No plans yet — just ideas</span></button>
</div>
</section>

<!-- 3: BUILDER -->
<section class="screen" data-step="builder">
<div class="eyebrow">Your builder</div>
<h1>Have you picked a builder?</h1>
<p class="sub">Any licensed builder works — we'll get them approved and keep the build on schedule.</p>
<div class="opts" data-field="builder">
<button class="opt" data-val="Builder picked"><span class="ic">🤝</span><span class="t">Yes — builder picked</span></button>
<button class="opt" data-val="Talking to builders"><span class="ic">💬</span><span class="t">Talking to a few builders</span></button>
<button class="opt" data-val="No builder yet"><span class="ic">🧭</span><span class="t">No builder yet</span></button>
</div>
</section>

<!-- 4: BUDGET -->
<section class="screen" data-step="budget">
<div class="eyebrow">Ballpark only</div>
<h1>What's your all-in build budget?</h1>
<p class="sub">Land + build, rough number — we'll dial it in later.</p>
<div class="opts two" data-field="budget">
<button class="opt" data-val="Under $250k"><span class="t">Under $250k</span></button>
<button class="opt" data-val="$250k–$400k"><span class="t">$250k–$400k</span></button>
<button class="opt" data-val="$400k–$600k"><span class="t">$400k–$600k</span></button>
<button class="opt" data-val="$600k+"><span class="t">$600k+</span></button>
<button class="opt" data-val="Not sure"><span class="t">Not sure yet</span></button>
</div>
</section>

<!-- 5: PROGRAM -->
<section class="screen" data-step="program">
<div class="eyebrow">Financing</div>
<h1>Any loan program in mind?</h1>
<p class="sub">"Not sure" is a great answer — matching this is literally my job.</p>
<div class="opts" data-field="program">
<button class="opt" data-val="VA"><span class="ic">🎖️</span><span class="t">VA — $0 down for veterans</span></button>
<button class="opt" data-val="USDA"><span class="ic">🌾</span><span class="t">USDA — $0 down rural</span></button>
<button class="opt" data-val="FHA"><span class="ic">🏠</span><span class="t">FHA — 3.5% down</span></button>
<button class="opt" data-val="Conventional"><span class="ic">🏛️</span><span class="t">Conventional</span></button>
<button class="opt" data-val="Not sure"><span class="ic">❓</span><span class="t">Not sure — match me</span></button>
</div>
</section>

<!-- 6: GROUND -->
<section class="screen" data-step="ground">
<div class="eyebrow">Almost there</div>
<h1>When do you want to break ground?</h1>
<p class="sub">No pressure — this just helps me prioritize your file.</p>
<div class="opts" data-field="ground">
<button class="opt" data-val="As soon as possible"><span class="ic">🚀</span><span class="t">As soon as possible</span></button>
<button class="opt" data-val="1–3 months"><span class="ic">📅</span><span class="t">1–3 months</span></button>
<button class="opt" data-val="3–6 months"><span class="ic">🗓️</span><span class="t">3–6 months</span></button>
<button class="opt" data-val="6+ months / researching"><span class="ic">📚</span><span class="t">6+ months — researching</span></button>
</div>
</section>

'@
$conLabels = @'
const labels={land:"Your land",plans:"Plans",builder:"Builder",budget:"Budget",
    program:"Program",ground:"Timeline",contact:"Contact",done:"Done"};
'@
$conOrder = 'let order=["land","plans","builder","budget","program","ground","contact"];'
$conRecap = @'
    const rows=[
      ["Land", data.land],
      ["Plans", data.plans],
      ["Builder", data.builder],
      ["Budget", data.budget],
      ["Program", data.program],
      ["Break ground", data.ground],
      ["Contact", data.phone],
    ].filter(Boolean);
'@
$conPayload = @'
        land:data.land||'', plans:data.plans||'', builder:data.builder||'',
        budget:data.budget||'', program:data.program||'', ground:data.ground||'',
        source:'Construction loan form',
'@
Build-Form $conScreens $conLabels $conOrder 'land' $conRecap $conPayload 'Construction loan form' 'construction-form.html'
