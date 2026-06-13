<?php
$p = get_page_by_path("free-quote", OBJECT, "page");
if (!$p) WP_CLI::error("free-quote not found");
if (strpos($p->post_content, "fgs-callout") !== false) { WP_CLI::success("callout already present"); return; }
$anchor = "<!-- wp:shortcode -->\n[wpforms id=\"367\" title=\"false\"]";
$callout = "<!-- wp:html -->\n<div class=\"fgs-callout\"><span class=\"fgs-callout__dot\"></span><span>You can expect a call back the <strong>same business day</strong> &mdash; no later than the next.</span></div>\n<!-- /wp:html -->\n\n";
$pos = strpos($p->post_content, $anchor);
if ($pos === false) WP_CLI::error("form anchor not found");
$new = substr($p->post_content, 0, $pos) . $callout . substr($p->post_content, $pos);
wp_update_post(["ID" => $p->ID, "post_content" => wp_slash($new)], true);
WP_CLI::log("callout inserted above the form");
// CSS
$ms = "/* fgs-callout:start */"; $me = "/* fgs-callout:end */";
$ncss = ".fgs-callout{display:flex;align-items:center;gap:12px;background:#f3efe8;border:1px solid #e8e1d6;border-left:5px solid #a91513;border-radius:12px;padding:16px 20px;margin:20px auto 8px;max-width:560px;font-size:15.5px;line-height:1.5;color:#2d2d2d;font-weight:600}
.fgs-callout strong{color:#a91513}
.fgs-callout__dot{flex:0 0 11px;width:11px;height:11px;border-radius:50%;background:#1fa463;animation:fgsPulse 2s ease-out infinite}
@keyframes fgsPulse{0%{box-shadow:0 0 0 0 rgba(31,164,99,.45)}70%{box-shadow:0 0 0 10px rgba(31,164,99,0)}100%{box-shadow:0 0 0 0 rgba(31,164,99,0)}}";
$css = (string) wp_get_custom_css();
$css = preg_replace("#" . preg_quote($ms, "#") . ".*?" . preg_quote($me, "#") . "#s", "", $css);
wp_update_custom_css_post(rtrim($css) . "\n\n" . $ms . "\n" . $ncss . "\n" . $me . "\n");
WP_CLI::success("callout + CSS done");
