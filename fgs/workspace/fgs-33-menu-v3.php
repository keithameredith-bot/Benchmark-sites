<?php
// Menu rebuild v3 (full, deterministic): Blog moves under About per Keith.
$menu = wp_get_nav_menu_object("Main Menu");
foreach (wp_get_nav_menu_items($menu->term_id) as $item) wp_delete_post($item->ID, true);
$add = function($title, $pid, $parent = 0) use ($menu) {
  return wp_update_nav_menu_item($menu->term_id, 0, [
    "menu-item-title" => $title, "menu-item-object" => "page", "menu-item-object-id" => $pid,
    "menu-item-type" => "post_type", "menu-item-status" => "publish", "menu-item-parent-id" => $parent,
  ]);
};
$add("Home", 90);
$svc = $add("Services", 146);
foreach ([
  "Geotechnical Engineering" => 146, "Sinkhole Investigation" => 167, "Geotechnical Drilling" => 205,
  "Soil Testing & Lab" => 216, "Construction Materials Testing" => 202, "Concrete & Asphalt Testing" => 230,
  "Foundation Engineering" => 269, "Ground Penetrating Radar" => 264, "Environmental Site Assessment" => 223,
  "Pavement Design & Evaluation" => 225,
] as $t => $pid) $add($t, $pid, $svc);
$add("Gallery", 99);
$about = $add("About", 92);
$add("Our Mission", 96, $about);
$add("Blog", 588, $about);
$add("Contact", 94);
echo "menu rebuilt: Home, Services(+10), Gallery, About(+Mission,+Blog), Contact\n";
