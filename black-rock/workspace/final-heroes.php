<?php
global $wpdb;
require __DIR__ . '/hero-fn.php';

// FAQ (31): no H1 -> prepend hero
$pid=31; $c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if(strpos($c,'class="brm-hero"')===false){
  $hero=brm_hero_html('Florida Mortgage FAQ &bull; NMLS #303217','Florida Mortgage FAQ','Straight answers to the questions Florida buyers ask most &mdash; from a broker who picks up the phone, not a call center.','Get Pre-Approved','/get-pre-approved/',false);
  if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($c),true);
  $wpdb->update($wpdb->posts,array('post_content'=>$hero."\n\n".$c),array('ID'=>$pid)); clean_post_cache($pid);
  echo "mortgage-faq: hero prepended\n";
} else echo "mortgage-faq: already hero\n";

// Glossary (318): has H1 advancedheading -> prepend hero, demote old H1 to H2
$pid=318; $c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if(strpos($c,'class="brm-hero"')===false){
  // demote existing first H1 (advancedheading level 1)
  $c=preg_replace('/("level":)1/', '${1}2', $c, 1);
  $c=preg_replace('/<h1(\s)/', '<h2$1', $c, 1);
  $c=preg_replace('/<\/h1>/', '</h2>', $c, 1);
  $hero=brm_hero_html('Mortgage Glossary &bull; NMLS #303217','Mortgage Glossary','140+ mortgage terms explained in plain English &mdash; so you actually understand what you&rsquo;re signing.','Get Pre-Approved','/get-pre-approved/',false);
  if(!get_post_meta($pid,'_brm_hero_backup',true)) add_post_meta($pid,'_brm_hero_backup',wp_slash($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid")),true);
  $wpdb->update($wpdb->posts,array('post_content'=>$hero."\n\n".$c),array('ID'=>$pid)); clean_post_cache($pid);
  echo "mortgage-glossary: hero prepended + old H1 demoted\n";
} else echo "mortgage-glossary: already hero\n";

// Author bio photo (987514146): round corners for conformity
$pid=987514146; $c=$wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if(strpos($c,'border-radius')===false || strpos($c,'width:300px;border-radius')===false){
  $c2=str_replace('style="width:300px"','style="width:300px;border-radius:16px"',$c);
  if($c2!==$c){ $wpdb->update($wpdb->posts,array('post_content'=>$c2),array('ID'=>$pid)); clean_post_cache($pid); echo "author-bio photo: rounded (16px)\n"; }
  else echo "author-bio photo: img style not matched\n";
} else echo "author-bio photo: already rounded\n";
