<?php
$cfg = get_option('kadence_pro_theme_config');
echo "kadence_pro_theme_config type: " . gettype($cfg) . "\n";
if (is_array($cfg)||is_object($cfg)) {
    echo json_encode($cfg, JSON_PRETTY_PRINT) . "\n";
} else {
    echo var_export($cfg, true) . "\n";
}
// also check if mega menu module class exists / function
echo "\nclass Kadence_Pro mega: " . (class_exists('Kadence_Pro\\Menus') || class_exists('KadencePro\\Menus') ? 'yes' : 'unknown') . "\n";
// any nav-related theme mods
$mega = get_option('kadence_pro_mega_menu');
echo "kadence_pro_mega_menu option: " . ($mega!==false?json_encode($mega):'(not set)') . "\n";
