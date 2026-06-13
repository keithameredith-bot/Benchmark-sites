<?php
echo "kadence-pro active: " . (is_plugin_active('kadence-pro/kadence-pro.php') ? 'YES' : 'NO') . "\n";
// Kadence Pro license / active products
foreach (array('kt_api_manager_kadence_gumball_data','kadence_pro_license','kadence_gumball','stash_kadence_pro','kadence_blocks_pro') as $opt) {
    $v = get_option($opt);
    if ($v !== false) echo "option $opt: " . (is_array($v)||is_object($v) ? json_encode($v) : $v) . "\n";
}
// Kadence Pro modules / active addons
$mods = get_option('kadence_pro_active_modules');
echo "kadence_pro_active_modules: " . ($mods!==false ? json_encode($mods) : '(not set)') . "\n";
// search options for kadence pro module flags
global $wpdb;
$rows = $wpdb->get_results("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '%kadence%pro%' OR option_name LIKE '%kt_pro%' OR option_name LIKE '%kadence_api%' LIMIT 20");
echo "kadence-pro-ish options:\n";
foreach ($rows as $r) echo "  {$r->option_name}\n";
