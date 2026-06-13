<?php
// Phase C: extend the WPCode loan-schema snippet's $loan_map to cover ALL loan program pages.
global $wpdb;
$pid = 987515099;
$c = $wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID=$pid");
if (strpos($c, '/florida-physician-loan/') !== false) { echo "already extended\n"; return; }

$anchor = "\t\t// ... add the rest of your loan program pages here ...";
if (strpos($c, $anchor) === false) { echo "anchor not found - checking alt\n"; $anchor = "// ... add the rest of your loan program pages here ..."; if (strpos($c,$anchor)===false) { echo "no anchor; abort\n"; return; } }

$new = <<<'PHP'
		'/florida-physician-loan/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Physician Loan',
			'loan_type'   => 'Physician / Medical Professional',
		),
		'/florida-dscr-loan/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida DSCR Investor Loan',
			'loan_type'   => 'DSCR',
		),
		'/florida-non-qm-loans/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Non-QM Loan Programs',
			'loan_type'   => 'Non-QM',
		),
		'/self-employed-mortgage/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Self-Employed Mortgage',
			'loan_type'   => 'Self-Employed / Bank Statement',
		),
		'/self-employed-mortgage/bank-statement-mortgage-program/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Bank Statement Mortgage',
			'loan_type'   => 'Bank Statement',
		),
		'/condo-tel-financing-in-florida/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Condotel Financing',
			'loan_type'   => 'Condotel / Non-Warrantable Condo',
		),
		'/florida-cash-out-refinance/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Cash-Out Refinance',
			'loan_type'   => 'Cash-Out Refinance',
		),
		'/refinance-mortgage/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Mortgage Refinance',
			'loan_type'   => 'Refinance',
		),
		'/home-equity-line-of-credit-in-florida/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Home Equity Line of Credit',
			'loan_type'   => 'HELOC',
		),
		'/reverse-mortgages/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Reverse Mortgage (HECM)',
			'loan_type'   => 'Reverse Mortgage',
		),
		'/florida-construction-loan/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida One-Time Close Construction Loan',
			'loan_type'   => 'Construction',
		),
		'/fha-home-mortgage-loan/fha-streamline-refinance/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'FHA Streamline Refinance',
			'loan_type'   => 'FHA Streamline',
		),
		'/hometown-heroes-mortgage-program/' => array(
			'schema_type' => 'LoanOrCredit',
			'loan_name'   => 'Florida Hometown Heroes Down Payment Assistance',
			'loan_type'   => 'Down Payment Assistance',
		),
PHP;

$c = str_replace($anchor, $new . "\n" . $anchor, $c);
$wpdb->update($wpdb->posts, array('post_content' => $c), array('ID' => $pid));
clean_post_cache($pid);
// wpcode may cache compiled snippets
if (function_exists('wpcode')) { wp_cache_flush(); }
echo "loan_map extended with 13 pages\n";
