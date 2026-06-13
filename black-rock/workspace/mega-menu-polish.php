<?php
// Mega menu polish via Customizer CSS: per-item emoji icons (::before on menu item IDs)
// + spacing/gap fixes + description styling. Idempotent.
$css = wp_get_custom_css();
if (strpos($css, '/* BRM mega menu polish */') !== false) { echo "already polished\n"; return; }

$icons = array(
  // Loans
  87 => '1F3DB',        // Conventional 🏛
  15691 => '1F511',     // First-Time Buyer 🔑
  821 => '1F9F1',       // Piggy Back 🧱
  62 => '1F3E0',        // FHA 🏠
  63 => '1F33E',        // USDA 🌾
  200 => '1F396',       // VA 🎖
  615 => '1F69A',       // Manufactured 🚚
  17550 => '1F4CD',     // Moved 📍
  17645 => '25AD',      // Singlewides ▭
  18308 => '1F33F',     // USDA Mfg 🌿
  987514393 => '1F4C2', // Non-QM 📂
  1997 => '1F3E6',      // Bank Statement 🏦
  880 => '1F4BC',       // Self-Employed 💼
  987514399 => '1F4C8', // DSCR 📈
  15765 => '1F9B8',     // Hometown Heroes 🦸
  16598 => '1F3D7',     // New Construction 🏗
  18475 => '1F6E0',     // VA New Construction 🛠
  17867 => '1F3E1',     // New Houses Ocala 🏡
  17696 => '1F3E8',     // Condotel 🏨
  18131 => '1F48E',     // Jumbo 💎
  987512693 => '1F381', // DPA 🎁
  987515437 => '1FA7A', // Physician 🩺
  // Tools
  809 => '1F4D6',       // Buyer's Guide 📖
  336 => '1F4DA',       // Glossary 📚
  882 => '1F4CB',       // Documents 📋
  987514401 => '1F9EE', // Affordability 🧮
  18029 => '1F522',     // Mortgage Calc 🔢
  987514949 => '1F9FE', // Closing Cost 🧾
  987514951 => '1F501', // Refi Calc 🔁
  987514668 => '1F396', // VA Funding Fee 🎖
  987514391 => '2753',  // FAQ ❓
  18427 => '1F4C9',     // Rate Buydowns 📉
  987514924 => '1F4D0', // Buydown Calc 📐
  987514666 => '1F5FA', // Loan Limits 🗺
  987514670 => '1F33E', // USDA Eligibility 🌾
  987514672 => '1F9ED', // Program Finder 🧭
  // About
  987513124 => '1F4DE', // Contact 📞
  565 => '1F465',       // Team 👥
  186 => '1F464',       // Keith 👤
  987515439 => '2B50',  // Reviews ⭐
  987515441 => '1F5FA', // Where We Lend 🗺
  // Areas
  987515429 => '1F40E', // Ocala 🐎
  987515430 => '26F3',  // Villages ⛳
  987515431 => '1F40A', // Gainesville 🐊
  987515432 => '1F333', // Belleview 🌳
  // Refinance
  18173 => '26A1',      // FHA Streamline ⚡
  225 => '1F33E',       // USDA Streamline 🌾
  16316 => '1F69A',     // Refi Mfg 🚚
  539 => '1F3D6',       // HECM guide 🏖
  17759 => '1F4B3',     // HELOC 💳
  987514938 => '1F504', // Reverse 🔄
);

$rules = '';
foreach ($icons as $id => $hex) {
    $rules .= "#main-menu .menu-item-$id > a::before{content:\"\\$hex\";}\n";
}

$add = '

/* BRM mega menu polish */
/* icons */
#main-menu .sub-menu .menu-item > a::before{content:"";display:inline-block;margin-right:9px;font-size:15px;line-height:1;vertical-align:-1px;font-family:"Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji",sans-serif;}
' . $rules . '
/* spacing: tighten gaps, even columns, polish descriptions */
.primary-menu-container .kadence-menu-mega-enabled > .sub-menu{padding:22px 26px !important;gap:0 28px !important;border-radius:0 0 14px 14px;box-shadow:0 18px 44px -18px rgba(15,46,45,.35);}
.primary-menu-container .kadence-menu-mega-enabled > .sub-menu > li{padding:0 !important;margin:0 !important;}
.primary-menu-container .kadence-menu-mega-enabled .sub-menu .sub-menu{padding:0 !important;margin:4px 0 10px !important;box-shadow:none !important;border:none !important;}
.primary-menu-container .kadence-menu-mega-enabled .sub-menu a{padding:8px 10px !important;border-radius:8px;line-height:1.35;}
.primary-menu-container .kadence-menu-mega-enabled .sub-menu a:hover{background:#eafaf6;}
/* second-level items acting as column headers */
.primary-menu-container .kadence-menu-mega-enabled > .sub-menu > li > a{font-family:"Rubik",sans-serif;font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.06em;color:#0f2e2d;}
/* the descriptions */
#main-menu .menu-item-description{display:block;font-size:12px;color:#5b6b6b;font-weight:400;text-transform:none;letter-spacing:0;margin-top:1px;line-height:1.35;}
';
wp_update_custom_css_post($css . $add);
wp_cache_flush();
echo "mega menu polish CSS added (" . count($icons) . " icons)\n";
