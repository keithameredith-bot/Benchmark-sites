<?php
// Create Ben Bishop as an Author and assign all blog posts to him. Idempotent.
$ben = get_user_by( 'login', 'ben' );
if ( ! $ben ) {
	$id = wp_insert_user( array(
		'user_login'   => 'ben',
		'user_pass'    => wp_generate_password( 24 ),
		'user_email'   => 'ben@tireexpressandservice.com',
		'display_name' => 'Ben Bishop',
		'first_name'   => 'Ben',
		'last_name'    => 'Bishop',
		'role'         => 'author',
		'description'  => 'Owner and manager of Tire Express & Complete Auto Service in Ocala, FL. Straight answers, fair prices, and a standard that every vehicle leaves the shop done right.',
	) );
	if ( is_wp_error( $id ) ) { echo 'ERR: ' . $id->get_error_message() . "\n"; exit; }
	echo "created user ben ($id)\n";
	$ben = get_user_by( 'id', $id );
} else {
	echo "user ben exists ({$ben->ID})\n";
}
foreach ( get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => -1 ) ) as $p ) {
	if ( (int) $p->post_author !== (int) $ben->ID ) {
		wp_update_post( array( 'ID' => $p->ID, 'post_author' => $ben->ID ) );
		echo "post {$p->ID} -> ben\n";
	}
}
echo "done\n";
