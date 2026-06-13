<?php
// Add native Kadence accordion panes to FHA (56), USDA (42), mfg hub (607) + patch FAQPage schema if present.
global $wpdb;

function brm_add_pane($pid, $question, $answerHtml, $marker) {
    global $wpdb;
    $c = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d", $pid));
    if (strpos($c, $marker) !== false) { echo "[$pid] pane already added\n"; return; }
    $lastPane = strrpos($c, '<!-- wp:kadence/pane');
    if ($lastPane === false) { echo "[$pid] NO ACCORDION\n"; return; }
    if (!preg_match('/\{"id":(\d+),"uniqueID":"([0-9a-zA-Z]+)_/', substr($c, $lastPane, 80), $m)) { echo "[$pid] pane attrs unparsed\n"; return; }
    $newId = (int)$m[1] + 1;
    $prefix = $m[2];
    $uid = $prefix . '_brmfq' . $newId . '-aa';
    $insertAt = strpos($c, '<!-- /wp:kadence/pane -->', $lastPane) + strlen('<!-- /wp:kadence/pane -->');

    $pane = "\n\n<!-- wp:kadence/pane {\"id\":$newId,\"uniqueID\":\"$uid\"} -->\n"
      . "<div class=\"wp-block-kadence-pane kt-accordion-pane kt-accordion-pane-$newId kt-pane$uid\"><div class=\"kt-accordion-header-wrap\"><button class=\"kt-blocks-accordion-header kt-acccordion-button-label-show\" type=\"button\"><span class=\"kt-blocks-accordion-title-wrap\"><span class=\"kt-blocks-accordion-title\">$question</span></span><span class=\"kt-blocks-accordion-icon-trigger\"></span></button></div><div class=\"kt-accordion-panel\"><div class=\"kt-accordion-panel-inner\"><!-- wp:paragraph -->\n"
      . "<p><!-- $marker -->$answerHtml</p>\n"
      . "<!-- /wp:paragraph --></div></div></div>\n<!-- /wp:kadence/pane -->";

    $c = substr($c, 0, $insertAt) . $pane . substr($c, $insertAt);
    // bump the LAST paneCount (the accordion these panes belong to)
    $pcPos = strrpos(substr($c, 0, $lastPane), '"paneCount":');
    if ($pcPos !== false && preg_match('/"paneCount":(\d+)/', substr($c, $pcPos, 30), $pm)) {
        $c = substr($c, 0, $pcPos) . '"paneCount":' . ((int)$pm[1] + 1) . substr($c, $pcPos + strlen('"paneCount":' . $pm[1]));
    }
    // patch FAQPage schema if the page has our standard block format
    $sAnchor = "\n]}\n</script>";
    if (strpos($c, '"@type":"FAQPage"') !== false && substr_count($c, $sAnchor) === 1) {
        $plain = trim(strip_tags(str_replace(array('&mdash;','&rsquo;','&ldquo;','&rdquo;'), array('-', "'", '"', '"'), $answerHtml)));
        $plain = str_replace('"', '\"', $plain);
        $q = str_replace('"', '\"', strip_tags($question));
        $c = str_replace($sAnchor, ",\n{\"@type\":\"Question\",\"name\":\"$q\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"$plain\"}}" . $sAnchor, $c);
        $schema = 'schema+';
    } else $schema = 'no-schema-patch';
    $wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $pid));
    clean_post_cache($pid);
    echo "[$pid] pane $newId added ($schema): $question\n";
}

brm_add_pane(56, "What&rsquo;s the downside of an FHA loan?",
  "Honest answer: the mortgage insurance. You finance a 1.75% upfront premium and pay a monthly premium for the life of the loan &mdash; the only way off it is refinancing into conventional once you have equity, which buyers do all the time. FHA also has slightly stricter property condition standards and county loan limits (\$541,287 in most of Florida for 2026). For buyers who&rsquo;d otherwise wait years saving a bigger down payment, the math usually still favors buying now with FHA &mdash; but those are the real tradeoffs.",
  'brm-fha-downside');

brm_add_pane(42, "What disqualifies you from a USDA loan?",
  "Four main things: household income above your county&rsquo;s limit (and USDA counts <em>everyone</em> in the household &mdash; not just the borrowers on the loan), a property outside the eligible area, buying it as anything other than your primary residence, and serious property condition issues. What usually does <em>not</em> disqualify you: income that merely <em>seems</em> high (the limits run higher than people expect), prior credit events with enough seasoning, or being a repeat buyer &mdash; USDA is not first-time-only. When in doubt, send me the address and your household income and I&rsquo;ll give you a real answer in minutes.",
  'brm-usda-disqualify');

brm_add_pane(607, "Why does Dave Ramsey say not to buy a mobile home &mdash; and is he right?",
  "His argument is depreciation, and for a home-only purchase in a leased-lot park (chattel), there&rsquo;s truth to it. But that&rsquo;s not what we finance most. A manufactured home <em>on its own land</em> is a different asset: the land appreciates, the package is financed as real property at real-property rates, and in markets like Marion County, total values have climbed for years. Meanwhile renting guarantees a 100% loss every month. A \$0-down USDA purchase of a newer doublewide on land &mdash; like the \$230,000 Dunnellon closing above &mdash; routinely beats the rent math. Ramsey&rsquo;s warning applies to a specific scenario; it&rsquo;s not a verdict on manufactured homes done right.",
  'brm-mfg-ramsey');
echo "done\n";
