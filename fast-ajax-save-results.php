<?php
define('SHORTINIT', true);
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
//Typical headers
header('Content-Type: text/html');
send_nosniff_header();
//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$post_id = $_POST['post_id'];
$goto_name = $_POST['goto_name'];
date_default_timezone_set('Russia/Moscow');
$time = date("Y-m-d H:i:s", time());


global $wpdb;
/* $result = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_type='narratives'");

if( $result )
	foreach( $result as $post ){
		echo $post->post_title;
	} */

$database_table = $wpdb->prefix."branching_narratives_list";
echo $database_table;

/* if($wpdb->insert($database_table,array(
    'post_id'=>$post_id,
    'result'=>$goto_name,
    'time'=>$time,
    ))===FALSE){
        echo "Error";
    }
    else {
        echo "Success";
    }
    //die();
} */
