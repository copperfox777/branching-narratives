<?php
define('SHORTINIT', true);
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
echo $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
global $wpdb;
// $post_id = $_POST['post_id'];
// $result = $_POST['result'];
// date_default_timezone_set('Russia/Moscow');
// $time = date('m/d/Y h:i:s a', time());

// $database_table = $wpdb->prefix."branching_narratives_list"
//wp_send_json( array( 'time' => time() ) );

// if($wpdb->insert($database_table,array(
//     'post_id'=>$post_id,
//     'result'=>$result,
//     'time'=>$time,
//     ))===FALSE){
//         echo "Error";
//     }
//     else {
//         echo "Success";
//     }
//     die();
// }
