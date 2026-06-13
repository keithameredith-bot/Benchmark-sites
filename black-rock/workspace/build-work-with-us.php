<?php
// Work With Us — LO recruiting landing page. Overwrites draft 18179, publishes at /work-with-us/.
global $wpdb;

$content = <<<'HTML'
<!-- wp:html -->
<style>
.brm-wwu{font-family:"Karla",-apple-system,sans-serif;color:#353535;}
.brm-wwu *{box-sizing:border-box;}
.brm-wwu .sec{max-width:1140px;margin:0 auto;padding:34px 20px;}
.brm-wwu h2{font-family:"Rubik",sans-serif;font-weight:800;color:#1c2b29;font-size:clamp(26px,3.4vw,38px);line-height:1.15;margin:0 0 14px;text-align:center;}
.brm-wwu h3{font-family:"Rubik",sans-serif;font-weight:700;color:#1c2b29;font-size:20px;margin:0 0 10px;}
.brm-wwu .kick{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#049F82;text-align:center;margin:0 0 10px;}
.brm-wwu .lead{font-size:17.5px;line-height:1.65;color:#46555237;color:#465552;max-width:780px;margin:0 auto 8px;text-align:center;}
.brm-wwu p{font-size:16.5px;line-height:1.65;}
/* hero */
.wwu-hero{position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);color:#fff;border-radius:16px;padding:64px 44px;margin:0 0 6px;}
.wwu-hero .eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;margin:0 0 12px;}
.wwu-hero h1{font-family:"Rubik",sans-serif;font-weight:800;color:#fff !important;font-size:clamp(32px,4.8vw,52px);line-height:1.08;letter-spacing:-.01em;margin:0 0 16px;max-width:820px;}
.wwu-hero .sub{color:#cfe0de;font-size:18.5px;line-height:1.6;max-width:720px;margin:0 0 28px;}
.wwu-hero .btns{display:flex;gap:13px;flex-wrap:wrap;}
.wwu-hero a.go,.wwu-hero a.alt{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:14.5px;letter-spacing:.02em;padding:15px 30px;border-radius:6px;text-decoration:none !important;transition:all .18s ease;}
.wwu-hero a.go{background:#F5A524 !important;color:#1a1a1a !important;border:2px solid #F5A524;}
.wwu-hero a.go:hover{background:#ffb944 !important;border-color:#ffb944;transform:translateY(-1px);}
.wwu-hero a.alt{background:transparent !important;color:#fff !important;border:2px solid rgba(255,255,255,.55);}
.wwu-hero a.alt:hover{border-color:#fff;background:rgba(255,255,255,.08) !important;}
.wwu-hero .conf{display:inline-flex;align-items:center;gap:8px;margin-top:22px;font-size:13px;color:#9fc4bd;}
.wwu-hero .conf .dot{width:8px;height:8px;border-radius:50%;background:#5dcaa5;}
/* stats */
.wwu-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin:26px auto 8px;max-width:1140px;padding:0 20px;}
.wwu-stat{background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px 18px;text-align:center;}
.wwu-stat .n{font-family:"Rubik",sans-serif;font-weight:800;font-size:30px;color:#037a64;line-height:1;}
.wwu-stat .l{font-family:"Rubik",sans-serif;font-weight:700;font-size:13px;color:#1c2b29;text-transform:uppercase;letter-spacing:.06em;margin-top:8px;}
.wwu-stat .s{font-size:13px;color:#7b8f8b;margin-top:4px;line-height:1.4;}
@media(max-width:880px){.wwu-stats{grid-template-columns:repeat(2,1fr);}}
/* calculator */
.wwu-calc{background:#0f2e2d;background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.16),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);border-radius:16px;max-width:1140px;margin:30px auto;padding:46px 38px;color:#fff;}
.wwu-calc h2{color:#fff;}
.wwu-calc .kick{color:#5dcaa5;}
.wwu-calc .lead{color:#cfe0de;}
.wwu-calc .grid{display:grid;grid-template-columns:1fr 1.2fr;gap:34px;margin-top:26px;align-items:start;}
@media(max-width:880px){.wwu-calc .grid{grid-template-columns:1fr;}}
.wwu-calc .lab{display:block;font-family:"Rubik",sans-serif;font-weight:700;font-size:13px;letter-spacing:.05em;text-transform:uppercase;color:#9fc4bd;margin:0 0 8px;}
.wwu-calc .seg{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 20px;}
.wwu-calc .seg button{border:1.5px solid rgba(255,255,255,.25);background:rgba(255,255,255,.05);color:#fff;border-radius:8px;padding:10px 14px;font-family:"Karla",sans-serif;font-size:14.5px;cursor:pointer;transition:all .15s ease;}
.wwu-calc .seg button:hover{border-color:#5dcaa5;}
.wwu-calc .seg button.sel{background:#049F82;border-color:#049F82;font-weight:700;}
.wwu-calc .out{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);border-radius:14px;padding:26px;}
.wwu-calc .vs{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.wwu-calc .box{border-radius:10px;padding:18px;text-align:center;}
.wwu-calc .box.them{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);}
.wwu-calc .box.us{background:rgba(4,159,130,.22);border:1px solid #049F82;}
.wwu-calc .box .t{font-family:"Rubik",sans-serif;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#9fc4bd;margin-bottom:8px;}
.wwu-calc .box .v{font-family:"Rubik",sans-serif;font-weight:800;font-size:clamp(22px,3vw,32px);color:#fff;line-height:1;}
.wwu-calc .box.us .v{color:#7be3c4;}
.wwu-calc .box .a{font-size:12.5px;color:#9fc4bd;margin-top:6px;}
.wwu-calc .diff{text-align:center;margin-top:18px;font-family:"Rubik",sans-serif;font-weight:800;font-size:clamp(18px,2.4vw,24px);color:#F5A524;}
.wwu-calc .fine{font-size:12px;color:#7fa39c;margin-top:14px;line-height:1.5;text-align:center;}
/* cards */
.wwu-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:24px;}
@media(max-width:880px){.wwu-cards{grid-template-columns:1fr;}}
.wwu-card{background:#fff;border:1px solid #e3edea;border-radius:14px;padding:26px 24px;}
.wwu-card .ic{font-size:26px;margin-bottom:10px;}
.wwu-card h3{font-size:18px;}
.wwu-card p{font-size:15px;color:#5b6b6b;line-height:1.6;margin:0;}
.wwu-card.gold{border-top:4px solid #F5A524;}
.wwu-card.teal{border-top:4px solid #049F82;}
/* cost sheet */
.wwu-cost{max-width:860px;margin:0 auto;background:#fff;border:1px solid #e3edea;border-radius:14px;overflow:hidden;}
.wwu-cost .row{display:flex;justify-content:space-between;gap:18px;padding:18px 26px;border-bottom:1px solid #eef5f3;align-items:baseline;}
.wwu-cost .row:last-child{border-bottom:0;}
.wwu-cost .k{font-family:"Rubik",sans-serif;font-weight:700;color:#1c2b29;font-size:15.5px;}
.wwu-cost .v{text-align:right;font-size:15px;color:#465552;max-width:60%;}
.wwu-cost .v b{color:#037a64;}
/* table */
.wwu-tablewrap{overflow-x:auto;margin-top:24px;}
.wwu-table{width:100%;border-collapse:collapse;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 1px 0 #e3edea, 0 0 0 1px #e3edea;min-width:680px;}
.wwu-table th{background:#0f2e2d;color:#fff;font-family:"Rubik",sans-serif;font-size:13.5px;text-transform:uppercase;letter-spacing:.05em;padding:14px 16px;text-align:left;}
.wwu-table th.hl{background:#049F82;}
.wwu-table td{padding:13px 16px;border-bottom:1px solid #eef5f3;font-size:14.5px;vertical-align:top;}
.wwu-table td.hl{background:#f0fbf8;font-weight:700;color:#0f4f44;}
.wwu-table tr:last-child td{border-bottom:0;}
/* quote blocks */
.wwu-quotes{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:24px;}
@media(max-width:880px){.wwu-quotes{grid-template-columns:1fr;}}
.wwu-quote{background:#fff;border:1px solid #e3edea;border-left:5px solid #F5A524;border-radius:12px;padding:24px;}
.wwu-quote p{font-size:15.5px;line-height:1.65;color:#465552;font-style:italic;margin:0 0 12px;}
.wwu-quote .who{font-family:"Rubik",sans-serif;font-weight:700;font-size:14px;color:#1c2b29;font-style:normal;}
.wwu-quote .stars{color:#F5A524;font-size:14px;margin-bottom:8px;letter-spacing:2px;}
/* keith box */
.wwu-keith{display:flex;gap:20px;align-items:flex-start;background:#f4faf8;border:1px solid #d9ece7;border-left:5px solid #049F82;border-radius:12px;padding:24px;max-width:860px;margin:26px auto 0;}
.wwu-keith img{width:74px;height:74px;border-radius:50%;object-fit:cover;flex:0 0 auto;}
.wwu-keith .tag{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:11.5px;color:#037a64;margin:0 0 6px;}
.wwu-keith p{margin:0;font-size:16px;line-height:1.65;}
@media(max-width:600px){.wwu-keith{flex-direction:column;}}
/* faq */
.wwu-faq{max-width:860px;margin:20px auto 0;}
.wwu-faq details{background:#fff;border:1px solid #e3edea;border-radius:10px;margin-bottom:10px;overflow:hidden;}
.wwu-faq summary{cursor:pointer;font-family:"Rubik",sans-serif;font-weight:700;font-size:16px;color:#1c2b29;padding:17px 20px;list-style:none;position:relative;padding-right:44px;}
.wwu-faq summary::after{content:"+";position:absolute;right:18px;top:50%;transform:translateY(-50%);font-size:22px;color:#049F82;font-weight:400;}
.wwu-faq details[open] summary::after{content:"\2212";}
.wwu-faq .a{padding:0 20px 18px;font-size:15.5px;line-height:1.65;color:#465552;}
/* final cta */
.wwu-final{background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.16),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);border-radius:16px;max-width:1140px;margin:34px auto 40px;padding:54px 38px;color:#fff;}
.wwu-final h2{color:#fff;}
.wwu-final .kick{color:#5dcaa5;}
.wwu-final .lead{color:#cfe0de;margin-bottom:26px;}
.wwu-final iframe{width:100%;max-width:720px;display:block;margin:0 auto;border:0;min-height:560px;overflow:hidden;border-radius:12px;}
.wwu-own{max-width:860px;margin:26px auto 0;background:#0f2e2d;color:#fff;border-radius:14px;padding:30px;text-align:center;}
.wwu-own h3{color:#fff;font-size:22px;}
.wwu-own p{color:#cfe0de;font-size:16px;max-width:640px;margin:0 auto;}
.wwu-own .gold{color:#F5A524;font-weight:700;}
</style>

<div class="brm-wwu">

<!-- HERO -->
<div class="wwu-hero">
  <p class="eyebrow">For Loan Originators &middot; 100% Confidential</p>
  <h1>Stop Building Someone Else's Pipeline.</h1>
  <p class="sub">Same job. Radically better math. A <strong style="color:#7be3c4;">$995 flat fee per file</strong> &mdash; no splits, no tiers &mdash; on a platform closing over <strong style="color:#7be3c4;">$1 billion a year</strong> with 343 originators. Your brand, your client list, your book. Forever yours, even if you leave.</p>
  <div class="btns">
    <a class="go" href="#calc">Run Your Numbers</a>
    <a class="alt" href="#talk">Skip to the Conversation</a>
  </div>
  <div class="conf"><span class="dot"></span> Exploring quietly? Your current shop will never hear from us.</div>
</div>

<!-- STATS -->
<div class="wwu-stats">
  <div class="wwu-stat"><div class="n">$995</div><div class="l">Flat fee per file</div><div class="s">$100K loan or $1M loan — same fee. The rest is yours.</div></div>
  <div class="wwu-stat"><div class="n">$1B+</div><div class="l">Closed per year</div><div class="s">Real volume, real infrastructure behind you</div></div>
  <div class="wwu-stat"><div class="n">343</div><div class="l">Sponsored originators</div><div class="s">And built to support hundreds more</div></div>
  <div class="wwu-stat"><div class="n">40+</div><div class="l">States to lend in</div><div class="s">Co-broker anywhere we're licensed — even without your own license there</div></div>
</div>

<!-- PAIN -->
<div class="sec">
  <p class="kick">If You're On The Retail Side</p>
  <h2>Why do the exact same job for half the pay?</h2>
  <p class="lead">At a bank or retail shop: the company sets your rates (you lose deals on price), owns your clients, caps your comp, and limits your menu. You're building equity in a brand that isn't yours &mdash; with effort that absolutely could be.</p>
  <div class="wwu-cards">
    <div class="wwu-card teal"><div class="ic">&#128176;</div><h3>Keep what you earn</h3><p>Most of our broker comp agreements are set at 2.75%. After the $995 flat fee, the rest is yours. No house split. No tiers that reset every January.</p></div>
    <div class="wwu-card teal"><div class="ic">&#127981;</div><h3>Win on price</h3><p>200+ wholesale lenders competing for your client's loan &mdash; pricing retail simply can't match, plus the products to say yes when the bank says no.</p></div>
    <div class="wwu-card teal"><div class="ic">&#128188;</div><h3>Own your business</h3><p>Your brand. Your client list. Your referral network. We're the infrastructure underneath you &mdash; not the landlord above you.</p></div>
  </div>
</div>

<!-- CALCULATOR -->
<div class="wwu-calc" id="calc">
  <p class="kick">The Math</p>
  <h2>What would you have kept last month?</h2>
  <p class="lead">Drag your real numbers in. This is the comparison your recruiter never shows you.</p>
  <div class="grid">
    <div>
      <span class="lab">Closings per month</span>
      <div class="seg" id="cLoans">
        <button data-v="1">1</button><button data-v="2" class="sel">2</button><button data-v="3">3</button><button data-v="5">5</button><button data-v="8">8</button><button data-v="12">12</button>
      </div>
      <span class="lab">Average loan size</span>
      <div class="seg" id="cSize">
        <button data-v="200000">$200K</button><button data-v="300000" class="sel">$300K</button><button data-v="400000">$400K</button><button data-v="600000">$600K</button>
      </div>
      <span class="lab">What you make per loan today</span>
      <div class="seg" id="cNow">
        <button data-v="0.0070">~70 bps (typical retail)</button><button data-v="0.0100" class="sel">~100 bps</button><button data-v="0.0125">~125 bps</button><button data-v="0.0150">~150 bps</button>
      </div>
      <span class="lab">How you'd work here</span>
      <div class="seg" id="cMode">
        <button data-v="1099" class="sel">1099 contractor</button><button data-v="w2">W-2 with benefits</button>
      </div>
    </div>
    <div class="out">
      <div class="vs">
        <div class="box them"><div class="t">Where you are</div><div class="v" id="oThem">$6,000</div><div class="a">per month</div></div>
        <div class="box us"><div class="t">Here at 2.75%</div><div class="v" id="oUs">$14,510</div><div class="a">per month, after fees</div></div>
      </div>
      <div class="diff" id="oDiff">+ $102,120 more per year</div>
      <p class="fine" id="oFine">Assumes comp set at 2.75% (our most common agreement) minus the $995 flat fee per file. With correspondent lending you can price without disclosing yield spread &mdash; or go borrower-paid on brokered deals. Your comp is your call.</p>
    </div>
  </div>
</div>

<!-- HONEST COST SHEET -->
<div class="sec">
  <p class="kick">No Surprises</p>
  <h2>The honest cost sheet</h2>
  <p class="lead">You've been burned by "ask your recruiter" before. Here's everything, in public:</p>
  <div class="wwu-cost" style="margin-top:24px;">
    <div class="row"><span class="k">Per-file fee</span><span class="v"><b>$995 flat</b> &mdash; whether the loan is $100K or $1M. No splits, no tiers, no percentage to the house.</span></div>
    <div class="row"><span class="k">1099 independent contractor</span><span class="v">$995 per file. <b>That's it.</b> Maximum flexibility, deduct your business expenses.</span></div>
    <div class="row"><span class="k">W-2 employee with benefits</span><span class="v">$995 per file + a 10% company share after the $995 &mdash; in exchange for <b>real benefits</b>: medical, MetLife dental &amp; vision, and a 401(k) with Roth option.</span></div>
    <div class="row"><span class="k">Slow quarter?</span><span class="v">If you close zero loans in a 3-month period, a $250 technology fee applies. Close one loan a quarter and it never exists.</span></div>
    <div class="row"><span class="k">Processing</span><span class="v"><b>Your choice.</b> Bring your own third-party processor or plug into our vetted network.</span></div>
    <div class="row"><span class="k">Your tech stack</span><span class="v">Arrive point-of-sale and Leaf 360 &mdash; a pioneering mortgage CRM. You run them as the owner of your business; we'll walk the full sheet line-by-line in the conversation.</span></div>
  </div>
  <p style="text-align:center;font-size:14px;color:#7b8f8b;margin-top:14px;">There are shops that are slightly cheaper. There are none that are cheaper <em>and</em> back you with this level of support.</p>
</div>

<!-- 3-COL TABLE -->
<div class="sec">
  <p class="kick">Side By Side</p>
  <h2>Retail vs. a typical broker shop vs. here</h2>
  <div class="wwu-tablewrap">
  <table class="wwu-table">
    <thead><tr><th></th><th>Retail / banker</th><th>Typical broker shop</th><th class="hl">Coast 2 Coast + Black Rock</th></tr></thead>
    <tbody>
      <tr><td><b>Your comp</b></td><td>Tiered, capped, reset yearly</td><td>Splits or per-file + monthly fees</td><td class="hl">$995 flat per file. Comp commonly set at 2.75%.</td></tr>
      <tr><td><b>Pricing power</b></td><td>One rate sheet</td><td>Wholesale menu</td><td class="hl">200+ wholesale lenders + correspondent panel (Freedom, PennyMac, NewRez)</td></tr>
      <tr><td><b>Correspondent access</b></td><td>n/a — you're captive</td><td>Rarely</td><td class="hl">Yes — close in your name, price without YSP disclosure, non-QM channels included</td></tr>
      <tr><td><b>Your brand</b></td><td>Theirs</td><td>Sometimes</td><td class="hl">Yours — full DBA or "powered by" path. You own it if you leave.</td></tr>
      <tr><td><b>Your client list</b></td><td>Theirs</td><td>Gray area</td><td class="hl">Yours. In writing. We don't chase your book if you go.</td></tr>
      <tr><td><b>Geographic reach</b></td><td>Where they say</td><td>Your licenses only</td><td class="hl">Every state we're licensed in, via co-brokered deals (50/50 compliance split)</td></tr>
      <tr><td><b>Benefits</b></td><td>Yes</td><td>Almost never</td><td class="hl">Optional W-2 track: medical, dental, vision, 401(k)</td></tr>
      <tr><td><b>Support</b></td><td>Call center</td><td>You're on your own</td><td class="hl">In-house UW experts, immediate tech support, direct line to the owner</td></tr>
    </tbody>
  </table>
  </div>
</div>

<!-- BRANDING PATHS -->
<div class="sec">
  <p class="kick">Your Name On The Door</p>
  <h2>Three ways to build your brand here</h2>
  <div class="wwu-cards">
    <div class="wwu-card gold"><div class="ic">&#128081;</div><h3>Your own DBA</h3><p>Full brand independence with a small "division of Coast 2 Coast Mortgage" line &mdash; exactly how Black Rock runs. DBAs process in about two weeks, and we time it so you transition straight into your own branding on day one.</p></div>
    <div class="wwu-card gold"><div class="ic">&#9889;</div><h3>Your team, powered by C2C</h3><p>Skip the DBA process entirely: your team name with a 50/50 "powered by Coast 2 Coast Mortgage" logo. Identity now, paperwork never.</p></div>
    <div class="wwu-card gold"><div class="ic">&#9968;</div><h3>Join Black Rock</h3><p>Plug into an established, growing brand &mdash; this website and its pipeline included &mdash; with training and deal support directly from Keith on every file.</p></div>
  </div>
  <div class="wwu-own">
    <h3>You own your brand. You own your client list.</h3>
    <p>If you ever leave, your name and your book <span class="gold">go with you</span>. We grow by being worth staying for &mdash; not by holding your business hostage. And here's the proof the model works: <span class="gold">the website you're reading right now</span> is an originator's own brand, built on this platform.</p>
  </div>
</div>

<!-- SUPPORT -->
<div class="sec">
  <p class="kick">The Part Nobody Else Has</p>
  <h2>Support that actually shows up</h2>
  <div class="wwu-cards">
    <div class="wwu-card teal"><div class="ic">&#129520;</div><h3>In-house underwriting experts</h3><p>When a lender's underwriter digs in, our in-house experts help you push back intelligently &mdash; deals that die elsewhere close here.</p></div>
    <div class="wwu-card teal"><div class="ic">&#9889;</div><h3>Immediate tech support</h3><p>A human, fast &mdash; plus graphic design and social media resources when you want marketing help building your brand.</p></div>
    <div class="wwu-card teal"><div class="ic">&#128222;</div><h3>Direct access to ownership</h3><p>Keith Richardson, the owner of Coast 2 Coast, picks up the phone. The question is always "how can we help you?" &mdash; not "open a ticket."</p></div>
  </div>
  <div class="wwu-keith">
    <img src="/wp-content/uploads/2026/04/Keith-Meredith-division-president-of-black-rock-mortgage.webp" alt="Keith Meredith, Division President, Black Rock Mortgage">
    <div>
      <p class="tag">From Keith Meredith &middot; Division President &middot; NMLS #303217</p>
      <p>Real talk: this model is built for the <strong>self-motivated</strong> originator. We're not handing you leads &mdash; it's a self-generated business, by design, so the platform stays out of your way financially and you keep the most money to invest in <em>your</em> business. (Leads are available for purchase if you want them.) New originators are welcome &mdash; that's how I started &mdash; and whether you build under Black Rock, Coast 2 Coast, or your own name, you train with me directly and I'm on your deals with you.</p>
    </div>
  </div>
</div>

<!-- TESTIMONIALS -->
<div class="sec">
  <p class="kick">From Originators On The Platform</p>
  <h2>Don't take our word for it</h2>
  <div class="wwu-quotes">
    <div class="wwu-quote"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"I originate mortgages part time, so I maybe close one loan a month &mdash; and Keith gives me the support I need on every deal to make sure I'm giving my clients the advice and service that a seasoned originator of 10+ years is able to provide."</p><div class="who">&mdash; Robert Swanson, Loan Originator</div></div>
    <div class="wwu-quote"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"Coast 2 Coast and their over 200 wholesale lenders has given me the ability to become a niche lender. I don't just have to be the residential loan guy &mdash; I'm closing multi-million-dollar commercial loans."</p><div class="who">&mdash; Andy Gaab, Loan Originator</div></div>
  </div>
</div>

<!-- FAQ -->
<div class="sec">
  <p class="kick">Asked Quietly, Answered Honestly</p>
  <h2>Recruiting FAQ</h2>
  <div class="wwu-faq">
    <details open><summary>Is the $995 really the only per-file cost?</summary><div class="a">For 1099 contractors, yes — $995 per file, full stop. On the W-2 track there's a 10% company share after the $995, which is what funds your benefits package (medical, MetLife dental &amp; vision, 401(k) with Roth). The only other charge that exists: a $250 technology fee if you close zero loans in a rolling 3-month period. Processing is third-party — yours or ours, your call.</div></details>
    <details><summary>How fast can I move, and what happens to my pipeline?</summary><div class="a">A DBA takes about two weeks to process — and we deliberately start it ahead of your transition so you onboard straight into your own branding. Timing the move around your active pipeline is exactly the kind of thing the confidential conversation maps out — it's a planned handoff, not a leap.</div></details>
    <details><summary>Do I really keep my brand and clients if I leave?</summary><div class="a">Yes. You own your branding and you own your client list — if you leave, both go with you. We don't chase your book. We'd rather keep you by being the best platform you've worked on.</div></details>
    <details><summary>Can I lend outside the states I'm licensed in?</summary><div class="a">Yes — through co-brokering. Partner on the deal with an originator licensed in that state (compliance requires a 50/50 split) and you can serve clients in every state Coast 2 Coast is licensed in. One license effectively makes you a nationwide broker.</div></details>
    <details><summary>I'm new / low-volume. Is this for me?</summary><div class="a">If you're self-motivated, yes — this is how Keith started. You won't be handed leads; you'll be handed the economics and support to build your own book, with training directly from Keith and in-house experts on your files. Part-time originators thrive here too (read Robert's quote above).</div></details>
    <details><summary>What's correspondent lending and why should I care?</summary><div class="a">It means closing loans in your own name with lender-level control — faster timelines, fewer conditions, and pricing without disclosing yield spread. Our correspondent panel includes Freedom Mortgage, PennyMac, and NewRez, plus non-QM correspondent channels for deals outside agency guidelines. It's the power most broker shops simply don't have.</div></details>
  </div>
</div>

<!-- FINAL CTA / FORM -->
<div class="wwu-final" id="talk">
  <p class="kick">No Pressure. No Recruiters. No Drip Campaigns.</p>
  <h2>Confidential conversations welcome</h2>
  <p class="lead">Whether you're exploring, curious, or ready to move — six quick questions and Keith reaches out personally, usually within one business day.</p>
  <iframe id="brmRecruit" src="/wp-content/uploads/forms/recruiting-form.html?v=1" title="Confidential recruiting conversation" scrolling="no" loading="lazy"></iframe>
</div>

</div>

<script data-cfasync="false" data-no-optimize="1" data-no-defer="1" data-no-minify="1">
(function(){
  window.addEventListener("message", function(e){
    if (!e.data) return;
    if (e.data.brm === "height") {
      var f = document.getElementById("brmRecruit");
      if (f && e.data.h) { f.style.height = e.data.h + "px"; }
    }
  });
  function init(){
    var state = { loans: 2, size: 300000, now: 0.0100, mode: "1099" };
    function fmt(n){ return "$" + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
    function calc(){
      var themMo = state.loans * state.size * state.now;
      var gross = state.loans * (state.size * 0.0275 - 995);
      var usMo = state.mode === "w2" ? gross * 0.90 : gross;
      document.getElementById("oThem").textContent = fmt(themMo);
      document.getElementById("oUs").textContent = fmt(usMo);
      var d = (usMo - themMo) * 12;
      document.getElementById("oDiff").textContent = (d >= 0 ? "+ " : "− ") + fmt(Math.abs(d)) + " more per year";
    }
    [["cLoans","loans",parseInt],["cSize","size",parseInt],["cNow","now",parseFloat],["cMode","mode",String]].forEach(function(cfg){
      var el = document.getElementById(cfg[0]);
      if (!el) return;
      el.addEventListener("click", function(e){
        var b = e.target.closest("button"); if (!b) return;
        el.querySelectorAll("button").forEach(function(x){ x.classList.remove("sel"); });
        b.classList.add("sel");
        state[cfg[1]] = cfg[2](b.dataset.v);
        calc();
      });
    });
    calc();
  }
  if (document.readyState === "loading") { document.addEventListener("DOMContentLoaded", init); } else { init(); }
})();
</script>
<!-- /wp:html -->
HTML;

$pid = 18179;
$existing = get_post($pid);
if (!$existing) { echo "draft 18179 missing\n"; return; }
if (!get_post_meta($pid, '_brm_wwu_backup', true)) add_post_meta($pid, '_brm_wwu_backup', wp_slash($existing->post_content), true);
wp_update_post(array(
    'ID' => $pid,
    'post_title' => 'Work With Us — Loan Originators',
    'post_name' => 'work-with-us',
    'post_content' => $content,
    'post_status' => 'publish',
));
// AIOSEO (UPDATE auto-row)
$t = $wpdb->prefix . 'aioseo_posts';
$row = $wpdb->get_var($wpdb->prepare("SELECT id FROM $t WHERE post_id=%d", $pid));
$data = array(
  'title' => 'Become a Mortgage Broker With Us — $995 Flat Fee Per File | Black Rock Mortgage',
  'description' => 'Loan originators: keep more with a $995 flat fee, 2.75% comp, your own brand and client list, correspondent power, and support that shows up. 343 originators, $1B+/year. Confidential conversations welcome.',
  'updated' => current_time('mysql', true),
);
if ($row) $wpdb->update($t, $data, array('id'=>$row));
else { $data['post_id']=$pid; $data['created']=current_time('mysql',true); $wpdb->insert($t, $data); }
clean_post_cache($pid);
wp_cache_flush();
echo "work-with-us published (post $pid)\n";
