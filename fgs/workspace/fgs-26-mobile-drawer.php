<?php
$items = get_theme_mod("header_mobile_items");
$items["popup"]["popup_content"] = ["mobile-logo", "mobile-navigation", "mobile-html"];
set_theme_mod("header_mobile_items", $items);
set_theme_mod("header_mobile_html_content", "<a class=\"fgs-mq-btn\" href=\"/free-quote/\">Get a Free Quote</a>");
set_theme_mod("header_mobile_html_wpautop", false);
set_theme_mod("mobile_html_content", "<a class=\"fgs-mq-btn\" href=\"/free-quote/\">Get a Free Quote</a>");
echo "drawer items + button content set\n";
$ms = "/* fgs-mobile-drawer:start */"; $me = "/* fgs-mobile-drawer:end */";
$ncss = "#mobile-drawer .drawer-inner{background:rgba(36,36,36,0.92) !important;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)}
#mobile-drawer .drawer-inner .mobile-navigation ul li a{text-transform:uppercase;letter-spacing:1.4px;font-size:15px !important;font-weight:600}
#mobile-drawer .drawer-inner .site-branding{margin-bottom:10px}
#mobile-drawer .drawer-inner .custom-logo{height:72px !important;width:auto !important}
#mobile-drawer .mobile-html,#mobile-drawer .header-mobile-html{width:100%}
.fgs-mq-btn{display:block;text-align:center;margin:24px 0 10px;padding:15px 18px;background:#a91513;color:#ffffff !important;border-radius:12px;font-weight:800;font-size:16px;letter-spacing:0.3px;text-decoration:none;box-shadow:0 10px 26px rgba(0,0,0,0.35);transition:transform .12s ease,background .2s ease}
.fgs-mq-btn:active{transform:scale(0.97)}
.fgs-mq-btn:hover{background:#7c0e0d;color:#ffffff !important}";
$css = (string) wp_get_custom_css();
$css = preg_replace("#" . preg_quote($ms, "#") . ".*?" . preg_quote($me, "#") . "#s", "", $css);
wp_update_custom_css_post(rtrim($css) . "\n\n" . $ms . "\n" . $ncss . "\n" . $me . "\n");
echo "drawer CSS written\n";
