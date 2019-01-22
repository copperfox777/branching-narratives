<?php
// Создаем задачу крон которая раз в две минуты выгружает статистику из мемкэша в БД
// 

// Создаем промежуток времени 3 мин для крона
function cron_add_3minutes( $schedules ) {
    $schedules['every3minutes'] = array(
	    'interval' => 180,
	    'display' => __( 'Once Every 3 Minutes' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_3minutes' );

// создаем крон(добавляем проверку что наш крон активен каждый раз при загрузке вордпресса)
function narr_cron_activation() {
	if( !wp_next_scheduled( 'narr_cron_job' ) ) {  
	   wp_schedule_event( time(), 'every3minutes', 'narr_cron_job' );  
	}
}
add_action('wp', 'narr_cron_activation');

// отключение крона при деактивации плагина
function narr_cron_deactivation() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('narr_cron_job');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'narr_cron_job');
} 
register_deactivation_hook (__FILE__, 'narr_cron_deactivation');


function flush_narratives_cache(){
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
add_action ('narr_cron_job', 'flush_narratives_cache');