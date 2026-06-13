<?php
// WWU: 2 mid-content CTAs -> #talk, call-Keith box under the form, featured image.
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/image.php';
$pid = 18179;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
$n = 0;

$cta1 = '<!-- MIDCTA1 -->
<div class="sec" style="padding-top:0;padding-bottom:10px;">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;background:#f4faf8;border:1px solid #d9ece7;border-radius:14px;padding:24px 30px;max-width:980px;margin:0 auto;">
    <p style="margin:0;font-family:Rubik,sans-serif;font-weight:700;font-size:18px;color:#1c2b29;">Numbers make sense? The conversation is the easy part.</p>
    <a href="#talk" style="display:inline-flex;align-items:center;background:#F5A524;color:#1a1a1a;font-family:Rubik,sans-serif;font-weight:700;font-size:14.5px;padding:13px 26px;border-radius:6px;text-decoration:none;white-space:nowrap;">Let&rsquo;s Talk &mdash; Confidentially</a>
  </div>
</div>

<!-- 3-COL TABLE -->';
if (strpos($c, 'MIDCTA1') === false) { $c = str_replace('<!-- 3-COL TABLE -->', $cta1, $c); $n++; }

$cta2 = '<!-- MIDCTA2 -->
<div class="sec" style="padding-top:0;padding-bottom:10px;">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;background:#f4faf8;border:1px solid #d9ece7;border-radius:14px;padding:24px 30px;max-width:980px;margin:0 auto;">
    <p style="margin:0;font-family:Rubik,sans-serif;font-weight:700;font-size:18px;color:#1c2b29;">Already picturing your name on the door?</p>
    <a href="#talk" style="display:inline-flex;align-items:center;background:#F5A524;color:#1a1a1a;font-family:Rubik,sans-serif;font-weight:700;font-size:14.5px;padding:13px 26px;border-radius:6px;text-decoration:none;white-space:nowrap;">Start the Conversation</a>
  </div>
</div>

<!-- SUPPORT -->';
if (strpos($c, 'MIDCTA2') === false) { $c = str_replace('<!-- SUPPORT -->', $cta2, $c); $n++; }

// call-Keith box under the form iframe (inside the final dark section)
$anchor = '<iframe id="brmRecruit" src="/wp-content/uploads/forms/recruiting-form.html?v=1" title="Confidential recruiting conversation" scrolling="no" loading="lazy"></iframe>';
$callbox = $anchor . '
  <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;max-width:720px;margin:22px auto 0;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.16);border-radius:14px;padding:22px 26px;">
    <img src="/wp-content/uploads/2026/04/Keith-Meredith-division-president-of-black-rock-mortgage.webp" alt="Keith Meredith" style="width:72px;height:72px;border-radius:50%;object-fit:cover;flex:0 0 auto;" id="wwuKeithPic" loading="lazy">
    <div style="flex:1;min-width:220px;">
      <p style="margin:0 0 4px;font-family:Rubik,sans-serif;font-weight:700;font-size:17px;color:#fff;">Rather just talk it out right now?</p>
      <p style="margin:0;font-size:15px;color:#cfe0de;line-height:1.55;">Call or text Keith&rsquo;s direct cell &mdash; <a href="tel:3526151613" style="color:#F5A524;font-weight:700;text-decoration:none;">352-615-1613</a>. No script, no pitch deck. Just two originators talking about joining the Coast 2 Coast family.</p>
    </div>
    <a href="tel:3526151613" style="display:inline-flex;align-items:center;background:#F5A524;color:#1a1a1a;font-family:Rubik,sans-serif;font-weight:700;font-size:14px;padding:12px 22px;border-radius:6px;text-decoration:none;white-space:nowrap;">Call / Text Keith</a>
  </div>';
if (strpos($c, 'Rather just talk it out right now') === false && strpos($c, $anchor) !== false) { $c = str_replace($anchor, $callbox, $c); $n++; }

$wpdb->update($wpdb->posts, array('post_content'=>$c), array('ID'=>$pid));
clean_post_cache($pid);

// featured image
if (!get_post_thumbnail_id($pid)) {
    $up = wp_upload_dir();
    $file = 'work-with-us-black-rock-mortgage.webp';
    $dest = $up['path'] . '/' . $file;
    if (file_exists('C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file)) {
        copy('C:/Users/keith/Desktop/black-rock-workspace/featured-ready/' . $file, $dest);
        $att = wp_insert_attachment(array('post_mime_type'=>'image/webp','post_title'=>'Work With Us - loan originator careers - Black Rock Mortgage / Coast 2 Coast','post_status'=>'inherit'), $dest, $pid);
        wp_update_attachment_metadata($att, wp_generate_attachment_metadata($att, $dest));
        update_post_meta($att, '_wp_attachment_image_alt', 'Work with us - loan originator opportunities at Black Rock Mortgage, a division of Coast 2 Coast');
        set_post_thumbnail($pid, $att);
        $n++;
        echo "featured image set (att $att)\n";
    } else echo "featured file not found - run magick first\n";
}
wp_cache_flush();
echo "done: $n changes\n";
