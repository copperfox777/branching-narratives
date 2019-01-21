<?php

// create a scheduled event (if it does not exist already)
function cronstarter_activation() {
	if( !wp_next_scheduled( 'mycronjob' ) ) {  
	   wp_schedule_event( time(), 'daily', 'mycronjob' );  
	}
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');


function flush_narratives_cache(){}
$m = new Memcached();

if($m->addServer('localhost', 11211)){
        $stat_arr = $m->get('stat');
        $m->flush();
    }

    global $wpdb;
    $database_table = $wpdb->prefix."branching_narratives_list";

    foreach ($stat_arr as $item){
        // print_r($item);
        if($wpdb->insert($database_table,$item)===FALSE){
            echo 'Error';
        }
    
    }
}