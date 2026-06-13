<?php
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, 'FAQPage') !== false) { echo "schema already present\n"; return; }
// correct regex: answer is inside <div class="a">...</div> (no <p>)
preg_match_all('/<summary>(.*?)<\/summary>\s*<div class="a">(.*?)<\/div>\s*<\/details>/s', $c, $m, PREG_SET_ORDER);
$items = array();
foreach ($m as $q) {
    $question = preg_replace('/\s+/', ' ', trim(html_entity_decode(strip_tags($q[1]), ENT_QUOTES)));
    $answer = preg_replace('/\s+/', ' ', trim(html_entity_decode(strip_tags($q[2]), ENT_QUOTES)));
    if ($question && $answer) $items[] = '{"@type":"Question","name":' . json_encode($question, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . ',"acceptedAnswer":{"@type":"Answer","text":' . json_encode($answer, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . '}}';
}
echo "FAQ items: " . count($items) . "\n";
if (count($items) < 3) { echo "too few, aborting\n"; return; }
$schema = "\n\n<!-- wp:html -->\n<script type=\"application/ld+json\">\n" . '{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/become-a-mortgage-broker/#faq","mainEntity":[' . implode(',', $items) . ']}' . "\n</script>\n<!-- /wp:html -->";
$c .= $schema;
$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);
wp_cache_flush();
file_put_contents('C:/Users/keith/AppData/Local/Temp/wwu-seo-content.html', $c);
// validate JSON
$json = json_decode(preg_match('/<script type="application\/ld\+json">\s*(\{.*?FAQPage.*?\})\s*<\/script>\s*<!-- \/wp:html -->$/s', $c, $mm) ? $mm[1] : '{}');
echo "schema appended; JSON valid: " . ($json && isset($json->mainEntity) ? 'YES (' . count($json->mainEntity) . ' Qs)' : 'NO') . "\n";
