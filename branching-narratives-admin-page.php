<?php
// В данные момент функционал этого файла отключен в branching-narratives.php
// Оставляем только на всякий случай если захочется сделать свою админку 

//Добавляем ссылку на статистику для нарратива для страницы списка всех нарративов
// Пока не нужно потому что ститистика в сжатом виде и так норм
/* function my_stat_post_link($actions, $post)
{
    if ($post->post_type=='narratives')
    {
        $actions['statistics'] = '<a href="#" title="" rel="permalink">Statistics</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'my_stat_post_link', 10, 2); */

// Добавляем для нарратива колонку со статистикой
add_filter( 'manage_narratives_posts_columns', 'set_custom_edit_narratives_columns' );
function set_custom_edit_narratives_columns($columns) {
	unset( $columns['author'] );
	unset( $columns['tags'] );
    $columns['statistics'] = 'Краткая статистика';
    return $columns;
}
// Заполняем  колонку статистики созданную выше
add_action( 'manage_narratives_posts_custom_column' , 'custom_narratives_column', 10, 2 );
function custom_narratives_column( $column, $post_id ) {
    switch ( $column ) {
		case 'statistics' :
		global $wpdb;
		$database_table = $wpdb->prefix."branching_narratives_list";
		
		// В скольки сессиях были нажатия, сессий может быть меньше если кто то прошел более 1 раза за сессию
		$sessions = $wpdb->get_results("SELECT COUNT(DISTINCT session_id) AS itm FROM ".$database_table." WHERE post_id=".$post_id,ARRAY_A);

		// Сколько раз было нажато старт или финиш
		$clicks = $wpdb->get_results("SELECT COUNT(result) AS cnt, result FROM ".$database_table." WHERE 
		post_id=".$post_id." AND (result LIKE '%finish%' OR result LIKE '%start%') GROUP BY result",ARRAY_A);
		
		// Выводим статистику
		echo 'Колличество  сессий: '; print_r($sessions[0]["itm"]); echo '<br>';
		
		foreach (array_reverse($clicks) as $item) {
			// if(preg_match("/(start|finish)/i", $item['result'])){
			echo 'Колличество '.$item['result'].": ".$item['cnt']."</br>";
			// echo '<pre>'; echo list($item); echo '</pre>';
		//    }
		}

		// echo '<pre>Отладка:'; print_r($clicks); echo '</pre>';
		// echo $post_id; 
		break;
		 	
    }
}