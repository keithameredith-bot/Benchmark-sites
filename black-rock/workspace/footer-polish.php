<?php
// Footer polish: round EHL badge, brand-align mobile CTA, jiggle hover on footer links, gold accents.
global $wpdb;

// 1. Equal Housing badge in footer_html_content (theme mod): 4px -> 8px + subtle gold border
$mods = get_option('theme_mods_kadence');
$f = $mods['footer_html_content'] ?? '';
$from = 'border: 1px solid #555;padding: 6px 12px;border-radius: 4px;color: #fff';
$to   = 'border: 1px solid rgba(245,165,36,0.45);padding: 7px 14px;border-radius: 8px;color: #fff;background: rgba(245,165,36,0.08)';
if (strpos($f, $from) !== false) {
    $mods['footer_html_content'] = str_replace($from, $to, $f);
    update_option('theme_mods_kadence', $mods);
    echo "EHL badge: rounded + gold accent\n";
} elseif (strpos($f, $to) !== false) echo "EHL badge: already done\n";
else echo "EHL badge: pattern not found\n";

// 2. Customizer Additional CSS: append footer polish block (idempotent)
$css = wp_get_custom_css();
if (strpos($css, '/* BRM footer polish */') === false) {
    $add = '

/* BRM footer polish */
/* mobile sticky CTA: brand teal + site corner radius */
.brm-mobile-cta a { border-radius: 6px !important; }
.brm-mobile-cta .brm-mcta-primary { background: #049F82 !important; }
.brm-mobile-cta .brm-mcta-primary:hover { background: #037a64 !important; }
.brm-mobile-cta .brm-mcta-secondary { color: #049F82 !important; border-color: #049F82 !important; }

/* footer link jiggle + gold hover (GPU-only, zero perf cost) */
@keyframes brm-jiggle {
  0% { transform: translateX(0) rotate(0deg); }
  25% { transform: translateX(1px) rotate(0.6deg); }
  50% { transform: translateX(-1px) rotate(-0.6deg); }
  75% { transform: translateX(1px) rotate(0.4deg); }
  100% { transform: translateX(0) rotate(0deg); }
}
.brm-foot-col a, #colophon .footer-html a { display: inline-block; transition: color .18s ease; }
.brm-foot-col a:hover, #colophon .footer-html a:hover { color: #F5A524 !important; animation: brm-jiggle .35s ease-in-out 1; }
.brm-foot-social a:hover { background: #F5A524 !important; color: #1a1a1a !important; transform: translateY(-2px); }

/* footer top accent line */
#colophon { border-top: 3px solid #F5A524; }
@media (prefers-reduced-motion: reduce) { .brm-foot-col a:hover, #colophon .footer-html a:hover { animation: none; } }
';
    wp_update_custom_css_post($css . $add);
    echo "customizer CSS: footer polish appended\n";
} else echo "customizer CSS: already polished\n";
wp_cache_flush();
echo "done\n";
