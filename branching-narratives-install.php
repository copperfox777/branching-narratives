<?php
function branching_narratives_install() {
	global $wpdb;
	
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	// таблица для хранения ответов нарратива 
	$sql = "CREATE TABLE ".$wpdb->prefix."branching_narratives_list (
			id int(10) NOT NULL AUTO_INCREMENT,
			post_id int(10) NOT NULL,
			result text NOT NULL,
			time datetime NOT NULL,            
			UNIQUE KEY id (id)
	) $charset_collate;";

	dbDelta( $sql );
}