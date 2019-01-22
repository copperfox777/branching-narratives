<?php
// Создаем в базе данных таблицу для хранения информации
function branching_narratives_install_bd() {
	global $wpdb;
	
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	// таблица для хранения ответов нарратива 
	$sql = "CREATE TABLE ".$wpdb->prefix."branching_narratives_list (
			id int(10) NOT NULL AUTO_INCREMENT,
			post_id int(10) NOT NULL,
			session_id CHAR(5) NOT NULL,
			result text NOT NULL,
			time datetime NOT NULL,            
			UNIQUE KEY id (id)
	) $charset_collate;";

	dbDelta( $sql );
}


// При активации плагина обновляем пермалинки, сначала создаем флаг обновления
// и если он поднят обновляем и снимаем флаг. Таким образом выполняется 1 раз
// при активации плагина

function branching_narratives_install_permalinks() {
    if ( ! get_option( 'narrs_flush_rewrite_rules_flag' ) ) {
        add_option( 'narrs_flush_rewrite_rules_flag', true );
    }
}

// Обновляем правила 
function narrs_flush_rewrite_rules() {
    if ( get_option( 'narrs_flush_rewrite_rules_flag' ) ) {
        flush_rewrite_rules();
        delete_option( 'narrs_flush_rewrite_rules_flag' );
    }
}