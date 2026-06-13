<?php
$blocks = get_option('widget_block');
$c = $blocks[14]['content'] ?? '';
$from = '.brm-foot-brand .footer-cta { display: inline-block; margin-top: 24px; background: #049F82; color: #fff !important; padding: 12px 24px; text-decoration: none; font-size: 13px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; transition: all .2s; }';
$to   = '.brm-foot-brand .footer-cta { display: inline-block; margin-top: 24px; background: #049F82; color: #fff !important; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; transition: all .2s; }';
if (strpos($c, $from) !== false) { $blocks[14]['content'] = str_replace($from, $to, $c); update_option('widget_block', $blocks); echo "footer-cta rounded at source\n"; }
elseif (strpos($c, $to) !== false) echo "already rounded\n";
else echo "pattern not found (customizer rule still covers it)\n";
wp_cache_flush();
