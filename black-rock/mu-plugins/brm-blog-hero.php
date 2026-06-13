<?php
/**
 * Plugin Name: BRM Blog Hero
 * Description: Branded teal hero on the blog archive + category archives, replacing the plain title band.
 */
if (!defined('ABSPATH')) exit;

add_action('kadence_archive', function () {
    if (!is_home() && !is_category()) return;

    if (is_home()) {
        $eyebrow = 'The Black Rock Blog';
        $h1 = 'Straight Talk on Florida Mortgages';
        $sub = 'Real programs, real numbers, and the things most lenders won&rsquo;t tell you &mdash; written by a broker who closes what he writes about.';
    } else {
        $cat = get_queried_object();
        $eyebrow = 'The Black Rock Blog';
        $h1 = esc_html($cat->name);
        $sub = $cat->description ? esc_html($cat->description) : 'Articles in this category &mdash; real numbers, Keith&rsquo;s take, no fluff.';
    }

    $cats = get_categories(array('hide_empty' => true, 'exclude' => array(21))); // hide the listings cat
    $chips = '';
    foreach ($cats as $c) {
        $active = (is_category() && get_queried_object_id() === $c->term_id);
        $style = $active
            ? 'background:#F5A524;border-color:#F5A524;color:#1a1a1a;font-weight:700;'
            : 'background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.22);color:#e8f5f1;';
        $chips .= '<a href="' . esc_url(get_category_link($c)) . '" style="display:inline-block;border:1.5px solid;border-radius:999px;padding:8px 16px;font-size:13.5px;text-decoration:none;transition:all .15s ease;' . $style . '">' . esc_html($c->name) . '</a>';
    }
    if (is_category()) {
        $chips = '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '" style="display:inline-block;border:1.5px solid rgba(255,255,255,.22);border-radius:999px;padding:8px 16px;font-size:13.5px;text-decoration:none;background:rgba(255,255,255,.07);color:#e8f5f1;">&larr; All articles</a>' . $chips;
    }
    ?>
<div class="brm-blog-hero" style="max-width:1140px;margin:18px auto 6px;padding:0 20px;font-family:Karla,-apple-system,sans-serif;">
  <div style="position:relative;overflow:hidden;background:radial-gradient(120% 120% at 85% -10%,rgba(93,202,165,.18),transparent 60%),linear-gradient(180deg,#0f2e2d,#0a1f1e);color:#fff;border-radius:16px;padding:48px 40px;">
    <p style="font-family:Rubik,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.16em;font-size:12px;color:#5dcaa5;margin:0 0 10px;"><?php echo $eyebrow; ?></p>
    <h1 style="font-family:Rubik,sans-serif;font-weight:800;color:#fff;font-size:clamp(28px,4vw,42px);line-height:1.12;margin:0 0 12px;"><?php echo $h1; ?></h1>
    <p style="color:#cfe0de;font-size:17.5px;line-height:1.55;max-width:680px;margin:0 0 22px;"><?php echo $sub; ?></p>
    <div style="display:flex;flex-wrap:wrap;gap:9px;font-family:Rubik,sans-serif;"><?php echo $chips; ?></div>
  </div>
</div>
<style>
body.blog .entry-hero, body.category .entry-hero { display: none !important; }
.brm-blog-hero a:hover { border-color: #5dcaa5 !important; }
@media (max-width: 720px) { .brm-blog-hero > div { padding: 34px 22px !important; border-radius: 12px !important; } }
</style>
    <?php
}, 5);
