<?php
// Embed the custom forms on mfg hub (607) + construction (16460) with the standard v3 CTA wrapper.
global $wpdb;

function brm_form_block($formFile, $h2, $lead) {
    return <<<HTML
<!-- wp:html -->
<style>
.brm-prog-cta{--pt-accent:#5dcaa5;--pt-gold:#f5a524;position:relative;background:radial-gradient(120% 90% at 80% -10%,rgba(93,202,165,0.16),transparent 60%),linear-gradient(180deg,#0f2e2d 0%,#0a1f1e 100%);color:#fff;padding:90px 24px 88px;border-radius:20px;max-width:1200px;margin:48px auto;overflow:hidden;font-family:"Karla",-apple-system,sans-serif;box-sizing:border-box;}
.brm-prog-cta *,.brm-prog-cta *::before,.brm-prog-cta *::after{box-sizing:border-box;}
.brm-prog-cta-wrap{max-width:1180px;margin:0 auto;}
.brm-prog-cta-eyebrow{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.18em;font-size:12.5px;color:var(--pt-accent);text-align:center;margin:0 0 14px;}
.brm-prog-cta h2{font-family:"Rubik",sans-serif;color:#fff !important;text-align:center;font-size:clamp(30px,4vw,44px);text-transform:uppercase;font-weight:800;margin:0 0 18px;line-height:1.15;}
.brm-prog-cta-lead{color:#cfe0de !important;text-align:center !important;max-width:720px;margin:0 auto 36px !important;font-size:17px;line-height:1.6;}
.brm-prog-cta-form-wrap{max-width:1000px;margin:0 auto;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:28px;-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);}
.brm-prog-cta-form-wrap iframe{width:100%;border:0;display:block;min-height:700px;overflow:hidden;border-radius:6px;background:#fff;}
.brm-prog-cta-readylabel{font-family:"Rubik",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.14em;font-size:12.5px;color:#5dcaa5;text-align:center;margin:110px 0 0;}
.brm-prog-cta-actions{margin:16px 0 0 !important;display:flex;flex-wrap:wrap;gap:14px;justify-content:center;align-items:center;}
.brm-prog-cta-actions a{display:inline-flex;align-items:center;justify-content:center;font-family:"Rubik",sans-serif;font-weight:700;font-size:15px;letter-spacing:.01em;line-height:1.35;padding:15px 30px;border-radius:6px;text-decoration:none !important;transition:all 180ms ease;}
.brm-prog-cta-portal