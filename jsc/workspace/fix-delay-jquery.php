<?php
// WPForms depends on jQuery — exclude it from delay-all too, or the form initializes late.
$o = get_option( 'perfmatters_options' );
$ex = $o['assets']['delay_js_exclusions'] ?? array();
if ( ! in_array( 'jquery', $ex, true ) ) { $ex[] = 'jquery'; }
$o['assets']['delay_js_exclusions'] = $ex;
update_option( 'perfmatters_options', $o );
echo "delay exclusions: " . implode( ', ', $ex ) . "\n";
