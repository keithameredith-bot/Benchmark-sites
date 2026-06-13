<?php
/**
 * Plugin Name: Black Rock Mortgage — On-Brand Social Share
 * Description: Custom, site-matching share buttons (FB, X, LinkedIn, Email, Copy Link). Appends to posts + program/tool/service pages; excludes conversion/utility pages. Replaces AddToAny.
 * Author: Benchmark Web Design
 * Version: 1.0
 */
if (!defined('ABSPATH')) exit;

if (!function_exists('brm_share_should_show')) {
    function brm_share_should_show() {
        if (is_front_page() || is_home()) return false;
        if (is_singular('post')) return true;          // all blog posts
        if (is_page()) {
            $exclude = array(
                'get-pre-approved','about-us','our-team','contact','keith-meredith',
                'privacy-policy','terms-of-service','accessibility','get-a-quote','work-with-us','become-a-mortgage-broker',
            );
            $slug = get_post_field('post_name', get_queried_object_id());
            return !in_array($slug, $exclude, true);
        }
        return false;
    }
}

if (!function_exists('brm_share_markup')) {
    function brm_share_markup() {
        $url   = rawurlencode(get_permalink());
        $title = rawurlencode(get_the_title());
        // Official Facebook Share Dialog (App ID). Works on mobile + desktop; sharer.php dead-ends in the mobile FB app.
        $fb = "https://www.facebook.com/dialog/share?app_id=4112051565753151&display=popup&href={$url}&redirect_uri={$url}";
        $x  = "https://twitter.com/intent/tweet?url={$url}&text={$title}";
        $li = "https://www.linkedin.com/sharing/share-offsite/?url={$url}";
        $em = "mailto:?subject={$title}&body={$url}";
        $plain = esc_attr(get_permalink());

        $fb_i = '<svg viewBox="0 0 24 24" width="17" height="17" aria-hidden="true"><path fill="currentColor" d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.7l-.4 2.9h-2.3v7A10 10 0 0 0 22 12Z"/></svg>';
        $x_i  = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M18.2 2H21l-6.5 7.5L22 22h-6.8l-4.3-5.6L5.9 22H3l7-8L2.5 2h6.9l3.9 5.2L18.2 2Zm-1.2 18h1.5L7 3.6H5.4L17 20Z"/></svg>';
        $li_i = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M6.94 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM3 8.5h3.9V21H3V8.5Zm6.3 0h3.7v1.7h.05c.5-.9 1.8-1.9 3.6-1.9 3.9 0 4.6 2.5 4.6 5.8V21h-3.9v-5.4c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9V21H9.3V8.5Z"/></svg>';
        $em_i = '<svg viewBox="0 0 24 24" width="17" height="17" aria-hidden="true"><path fill="currentColor" d="M2 5.5C2 4.7 2.7 4 3.5 4h17c.8 0 1.5.7 1.5 1.5v13c0 .8-.7 1.5-1.5 1.5h-17C2.7 20 2 19.3 2 18.5v-13ZM4 7v1l8 4.5L20 8V7l-8 4.5L4 7Z"/></svg>';
        $cp_i = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M9 9V6a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-3M4 9h7a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

        ob_start(); ?>
<div class="brm-share">
  <span class="brm-share-label">Share this</span>
  <a class="brm-share-btn" href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener" aria-label="Share on Facebook"><?php echo $fb_i; ?></a>
  <a class="brm-share-btn" href="<?php echo esc_url($x); ?>" target="_blank" rel="noopener" aria-label="Share on X"><?php echo $x_i; ?></a>
  <a class="brm-share-btn" href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><?php echo $li_i; ?></a>
  <a class="brm-share-btn" href="<?php echo esc_url($em); ?>" aria-label="Share by email"><?php echo $em_i; ?></a>
  <button type="button" class="brm-share-btn brm-share-copy" data-url="<?php echo $plain; ?>" aria-label="Copy link"><?php echo $cp_i; ?><span class="brm-share-copytxt">Copy link</span></button>
</div>
<?php
        return ob_get_clean();
    }
}

add_filter('the_content', function ($content) {
    if (!is_singular() || !in_the_loop() || !is_main_query()) return $content;
    if (!brm_share_should_show()) return $content;
    return $content . brm_share_markup();
}, 50);

add_action('wp_enqueue_scripts', function () {
    if (!brm_share_should_show()) return; // only load assets where the buttons appear
    $css = '
.brm-share{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:40px 0 8px;padding-top:24px;border-top:1px solid #e2ece9;font-family:"Rubik",-apple-system,sans-serif;}
.brm-share-label{font-weight:700;text-transform:uppercase;letter-spacing:.12em;font-size:12px;color:#1c2b29;margin-right:4px;}
.brm-share-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;width:42px;height:42px;border-radius:10px;background:#0f2e2d;color:#F5A524;border:0;cursor:pointer;text-decoration:none;transition:transform .16s ease,background .16s ease,color .16s ease;padding:0;}
.brm-share-btn:hover{background:#F5A524;transform:translateY(-2px);color:#1a1a1a;}
.brm-share-copy{width:auto;padding:0 16px;}
.brm-share-copytxt{font-family:"Rubik",sans-serif;font-weight:700;font-size:13px;letter-spacing:.01em;}
.brm-share-copy.copied{background:#F5A524;color:#1a1a1a;}
@media(max-width:600px){.brm-share{gap:8px;}.brm-share-copytxt{display:none;}.brm-share-copy{width:42px;padding:0;}}
';
    wp_register_style('brm-share', false);
    wp_enqueue_style('brm-share');
    wp_add_inline_style('brm-share', $css);

    $js = '
document.addEventListener("click",function(e){
  /* copy link */
  var cp=e.target.closest(".brm-share-copy");
  if(cp){
    var url=cp.getAttribute("data-url");
    navigator.clipboard.writeText(url).then(function(){
      var t=cp.querySelector(".brm-share-copytxt"); var old=t?t.textContent:"";
      cp.classList.add("copied"); if(t)t.textContent="Copied!";
      setTimeout(function(){cp.classList.remove("copied"); if(t)t.textContent=old||"Copy link";},1800);
    });
    return;
  }
  /* On desktop, open network shares (FB dialog / X / LinkedIn) in a tidy popup.
     On mobile, let the link navigate — the Facebook Share Dialog (app_id) opens
     the real FB share flow, and X/LinkedIn open their apps. */
  var sb=e.target.closest("a.brm-share-btn");
  if(sb && sb.getAttribute("target")==="_blank" && window.innerWidth>768){
    e.preventDefault();
    window.open(sb.href,"brmshare","width=600,height=560,menubar=no,toolbar=no,scrollbars=yes");
  }
});';
    wp_register_script('brm-share', '', array(), '1.0', true);
    wp_enqueue_script('brm-share');
    wp_add_inline_script('brm-share', $js);
});
