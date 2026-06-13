<?php
// Enrich /work-with-us/: testimonial pics, DBA logo wall, platform logo strip,
// Best of Florida 2025 award band, bolder 40+ states stat (linked).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$changed = 0;

// ---- 1. bolder states stat: link the whole card, punchier copy
$old = '<div class="wwu-stat"><div class="n">40+</div><div class="l">States to lend in</div><div class="s">Co-broker anywhere we\'re licensed — even without your own license there</div></div>';
$new = '<a class="wwu-stat" href="/states-we-are-licensed/" style="text-decoration:none;display:block;border-color:#049F82;"><div class="n" style="color:#F5A524;">40+</div><div class="l">States — Your Territory</div><div class="s">One license makes you a nationwide broker via co-brokering. See the map &rarr;</div></a>';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $changed++; }

// ---- 2. testimonial avatars
$old = '<div class="wwu-quote"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"I originate mortgages part time';
$new = '<div class="wwu-quote"><div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;"><img src="/wp-content/uploads/wwu/robert-swanson.webp" alt="Robert Swanson, Loan Originator" style="width:54px;height:54px;border-radius:50%;object-fit:cover;" loading="lazy"><div class="stars" style="margin:0;">&#9733;&#9733;&#9733;&#9733;&#9733;</div></div><p>"I originate mortgages part time';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $changed++; }
$old = '<div class="wwu-quote"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"Coast 2 Coast and their over 200';
$new = '<div class="wwu-quote"><div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;"><img src="/wp-content/uploads/wwu/andy-gaab.webp" alt="Andy Gaab, Loan Originator" style="width:54px;height:54px;border-radius:50%;object-fit:cover;" loading="lazy"><div class="stars" style="margin:0;">&#9733;&#9733;&#9733;&#9733;&#9733;</div></div><p>"Coast 2 Coast and their over 200';
if (strpos($c, $old) !== false) { $c = str_replace($old, $new, $c); $changed++; }

// ---- 3. DBA logo wall after the wwu-own callout
$anchor = '</div>
</div>

<!-- SUPPORT -->';
$wall = '</div>

  <div style="margin-top:26px;">
    <p class="kick" style="margin-top:10px;">Real Brands, Built Here</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;max-width:980px;margin:16px auto 0;" class="wwu-dba-wall">
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/2026/04/cropped-black-rock-mortgage-logo.webp" alt="Black Rock Mortgage" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy" onerror="this.parentNode.innerHTML=\'<b style=&quot;font-family:Rubik,sans-serif;color:#0f2e2d;&quot;>BLACK ROCK MORTGAGE</b>\'"></div>
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/wwu/dba-printz.webp" alt="Printz Mortgage Team" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy"></div>
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/wwu/dba-hello-my-mortgage.webp" alt="Hello My Mortgage" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy"></div>
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/wwu/dba-cardenas.webp" alt="Cardenas Mortgage Group" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy"></div>
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/wwu/dba-empower-home.webp" alt="Empower Home Mortgage" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy"></div>
      <div style="background:#fff;border:1px solid #e3edea;border-radius:12px;padding:22px;display:flex;align-items:center;justify-content:center;min-height:110px;"><img src="/wp-content/uploads/wwu/dba-nature-coast.webp" alt="Nature Coast Mortgage" style="max-width:78%;max-height:74px;object-fit:contain;" loading="lazy"></div>
    </div>
    <p style="text-align:center;font-size:13.5px;color:#7b8f8b;margin-top:12px;">A few of the brands originators have built on this platform &mdash; each one owned by the originator who built it.</p>
  </div>
</div>

<!-- SUPPORT -->';
if (strpos($c, 'wwu-dba-wall') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $wall, $c); $changed++; }

// ---- 4. platform logo strip at end of SUPPORT section (after the keith box)
$anchor = '</div>
</div>

<!-- TESTIMONIALS -->';
$strip = '</div>
  <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:34px;margin:30px auto 0;max-width:860px;padding:20px;background:#fff;border:1px solid #e3edea;border-radius:12px;">
    <img src="/wp-content/uploads/wwu/logo-c2c.webp" alt="Coast 2 Coast Mortgage" style="height:40px;object-fit:contain;" loading="lazy">
    <img src="/wp-content/uploads/wwu/logo-arive.webp" alt="ARIVE point of sale" style="height:34px;object-fit:contain;" loading="lazy">
    <img src="/wp-content/uploads/wwu/logo-leaf360.webp" alt="Leaf 360 mortgage CRM" style="height:34px;object-fit:contain;" loading="lazy">
    <span style="font-size:13px;color:#7b8f8b;font-family:Rubik,sans-serif;">The platform stack behind you</span>
  </div>
</div>

<!-- TESTIMONIALS -->';
if (strpos($c, 'logo-leaf360') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $strip, $c); $changed++; }

// ---- 5. Best of Florida award band after testimonials, before FAQ
$anchor = '<!-- FAQ -->';
$band = '<!-- AWARD -->
<div class="sec" style="padding-top:6px;">
  <div style="display:flex;align-items:center;gap:30px;max-width:860px;margin:0 auto;background:linear-gradient(135deg,#10417e,#1b5cad);border-radius:14px;padding:28px 32px;color:#fff;flex-wrap:wrap;">
    <img src="/wp-content/uploads/wwu/best-of-florida-2025.webp" alt="Coast 2 Coast Mortgage voted Best of Florida 2025" style="width:200px;border-radius:10px;flex:0 0 auto;" loading="lazy">
    <div style="flex:1;min-width:240px;">
      <p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12px;color:#9cc4ef;margin:0 0 8px;">Guide to Florida &middot; Statewide Vote</p>
      <p style="font-family:Rubik,sans-serif;font-weight:800;font-size:clamp(20px,2.6vw,28px);line-height:1.2;margin:0 0 8px;color:#fff;">Voted Best of Florida 2025</p>
      <p style="font-size:15.5px;line-height:1.6;color:#d7e7f8;margin:0;">The platform you&rsquo;d be building on isn&rsquo;t a quiet little shop &mdash; Coast 2 Coast Mortgage Lending was voted Best of Florida by the Guide to Florida&rsquo;s statewide readers&rsquo; vote.</p>
    </div>
  </div>
</div>

<!-- FAQ -->';
if (strpos($c, 'best-of-florida-2025') === false) { $c = str_replace($anchor, $band, $c); $changed++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
echo "enrichments applied: $changed/6\n";
