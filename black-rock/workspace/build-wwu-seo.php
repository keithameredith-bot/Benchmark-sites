<?php
// WWU SEO upgrade: how-to section + FAQPage schema + slug -> become-a-mortgage-broker (+old-slug redirect).
global $wpdb;
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (!get_post_meta($pid, '_brm_wwuseo_backup', true)) add_post_meta($pid, '_brm_wwuseo_backup', wp_slash($c), true);

// ---- 1. How-to section (informational intent + pivot) ----
$howto = '<!-- HOWTO -->
<div class="sec" id="how-to-become">
  <p class="kick">Start Here</p>
  <h2>How to Become a Mortgage Broker in Florida</h2>
  <p class="lead">Becoming a mortgage broker is more straightforward than most loan officers think &mdash; and on the broker side you keep dramatically more of what you produce. Here&rsquo;s the honest path.</p>
  <div class="wwu-cards" style="margin-top:24px;">
    <div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div><h3>1. Get licensed</h3><p>Pass the SAFE exam, clear a background and credit check, and hold your state MLO license &mdash; that&rsquo;s your NMLS number. Already licensed at a bank or retail shop? You&rsquo;re most of the way there; you just move your license to a broker (we add states for you).</p></div>
    <div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18M12 3v18"/></svg></div><h3>2. Choose how you&rsquo;ll operate</h3><p>Join an established broker and originate under their name, run your own team or DBA, or build fully independent. All three are real options here &mdash; and you own your brand and your client list either way.</p></div>
    <div class="wwu-card teal"><div class="ic"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#049F82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.5 8 8 11 4.5-3 8-6 8-11V5z"/></svg></div><h3>3. Pick your platform &mdash; this is everything</h3><p>The shop you hang your license with decides your pricing, lender access, comp, technology, and how much support you get when a file gets hard. It&rsquo;s the difference between thriving and grinding.</p></div>
  </div>
  <p style="text-align:center;font-size:16.5px;color:#465552;margin-top:20px;max-width:760px;margin-left:auto;margin-right:auto;line-height:1.6;">Step three is what the rest of this page is about. We&rsquo;ve been on both the bank side <em>and</em> the broker side &mdash; here&rsquo;s why the broker side, done on the right platform, wins.</p>
</div>

<!-- PAIN -->';
if (strpos($c, '<!-- HOWTO -->') === false && strpos($c, '<!-- PAIN -->') !== false) {
    $c = str_replace('<!-- PAIN -->', $howto, $c);
    echo "how-to section inserted\n";
} else echo "how-to anchor issue\n";

// ---- 2. FAQPage schema from the existing recruiting FAQ ----
if (strpos($c, 'FAQPage') === false) {
    preg_match_all('/<details[^>]*><summary>(.*?)<\/summary><div class="a"><p>(.*?)<\/p>/s', $c, $m, PREG_SET_ORDER);
    $items = array();
    foreach ($m as $q) {
        $question = trim(html_entity_decode(strip_tags($q[1]), ENT_QUOTES));
        $answer = trim(html_entity_decode(strip_tags($q[2]), ENT_QUOTES));
        $question = preg_replace('/\s+/', ' ', $question);
        $answer = preg_replace('/\s+/', ' ', $answer);
        if ($question && $answer) {
            $items[] = '{"@type":"Question","name":' . json_encode($question, JSON_UNESCAPED_SLASHES) . ',"acceptedAnswer":{"@type":"Answer","text":' . json_encode($answer, JSON_UNESCAPED_SLASHES) . '}}';
        }
    }
    echo "FAQ items extracted: " . count($items) . "\n";
    if (count($items) >= 3) {
        $schema = '

<!-- wp:html -->
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","@id":"https://www.blackrockmortgage.com/become-a-mortgage-broker/#faq","mainEntity":[' . implode(',', $items) . ']}
</script>
<!-- /wp:html -->';
        $c .= $schema;
        echo "FAQPage schema appended\n";
    }
}

// ---- 3. slug change + old-slug redirect ----
$old_slug = $wpdb->get_var("SELECT post_name FROM {$wpdb->posts} WHERE ID=$pid");
$wpdb->update($wpdb->posts, array('post_content'=>$c, 'post_name'=>'become-a-mortgage-broker'), array('ID'=>$pid));
if ($old_slug && $old_slug !== 'become-a-mortgage-broker') {
    add_post_meta($pid, '_wp_old_slug', $old_slug); // WP built-in 301 from old slug
    echo "slug: $old_slug -> become-a-mortgage-broker (old-slug redirect meta added)\n";
}
clean_post_cache($pid);
wp_cache_flush();
file_put_contents('C:/Users/keith/AppData/Local/Temp/wwu-seo-content.html', $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid"));
echo "done. new url: /become-a-mortgage-broker/\n";
