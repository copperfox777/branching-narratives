<?php
/*
Plugin Name: Ветвящиеся нарративы 
Description: Добавляет возможность создавать истории с ветящимся сюжетом
Version: 1.3
License: GPL
Author: Франц Антон Месмер
Author URI: http://ai-digest.ru/
*/


//Регистрируем новый тип записи нарратив
function create_posttype_narratives() {
    register_post_type( 'Narratives',
        array(
            'labels' => array(
                'name' => __( 'Нарративы' ),
                'singular_name' => __( 'Нарратив' )
            ),
            'public' => true,
            'rewrite' => array('slug' => 'narratives'),
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields','post-formats'),
			'public'              => true,
			'hierarchical'        => false,
			'show_ui'             => true,
			//'show_in_menu'        => true,
			'show_in_menu' => 'edit.php',    //переносим нарративы в меню при создании
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'has_archive'         => true,
			'can_export'          => true,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'taxonomies' 	      => array('post_tag'),
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			//'map_meta_cap'		  => true
        )
    );
}
add_action( 'init', 'create_posttype_narratives' );

//Добавляем для типа записи "нарратив" загрузку нашего js
function load_scripts() {
    if( is_singular('narratives') )
    {
		wp_enqueue_script('narrscript', plugins_url( '/narrscript.js', __FILE__ ), array('jquery'), date("h:i:s"), true);
		wp_enqueue_style('narrstyle', plugin_dir_url(__FILE__).'/style.css',date("h:i:s"));
    } 
}
add_action('wp_enqueue_scripts', 'load_scripts');

//Подключаем установку плагина - это делается для создания таблицы в базе данных
require_once('branching-narratives-install.php');
register_activation_hook( __FILE__, 'branching_narratives_install');

/* //подключаем урезанную псевдоадминку (а по сути страницу статистики)
require_once('branching-narratives-admin-page.php');
add_action( 'admin_menu', 'branching_narratives_menu' );
 */

 //Отключение <br>
function my_custom_formatting($content){
	if(get_post_type()=='narratives') {
		remove_filter( 'the_content', 'wpautop' );
		return wpautop($content,0);//no autop
	}
	return $content;
}
add_filter('the_content','my_custom_formatting',0);

//Подключаем функционал шорткодов
require_once('branching-narratives-shortcodes.php');

//Добавляем ссылку на статистику для нарратива для страницы списка всех нарративов
function my_stat_post_link($actions, $post)
{
    if ($post->post_type=='narratives')
    {
        $actions['statistics'] = '<a href="#" title="" rel="permalink">Statistics</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'my_stat_post_link', 10, 2);

// Добавляем для нарратива колонку со статистикой
add_filter( 'manage_narratives_posts_columns', 'set_custom_edit_narratives_columns' );
function set_custom_edit_narratives_columns($columns) {
	unset( $columns['author'] );
	unset( $columns['tags'] );
    $columns['statistics'] = 'Краткая статистика';
    return $columns;
}
// И заполняем эту колонку
add_action( 'manage_narratives_posts_custom_column' , 'custom_narratives_column', 10, 2 );
function custom_narratives_column( $column, $post_id ) {
    switch ( $column ) {

		case 'statistics' :
			
		
			



			break;
			
    }
}


function showNarrStat() {
	global $wpdb;
	$ajax_nonce = wp_create_nonce("tproger_quiz_secret");
	// извлекаем все виктрины
	$list = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."tquiz_list WHERE hidden_=0 ORDER BY `time` DESC", ARRAY_A);
	$count = count($list); // сколько всего викторин?
	echo "<input type='hidden' value='".$ajax_nonce."' id='secret_ajax_nonce'/>";
	// выводим списко викторин на экран
	// TODO: переписать с использованием wp_table_list class 
	echo "<table id='quiz_list_table' class='wp-list-table widefat fixed striped' style='display:none;'>";
	echo "<thead><tr>
		<th width=50px>#</th>
		<th>Название викторины</th>
		<th>Дата</th>
		<th>Код для вставки</th>
		<th>Количество прошедших тест</th>
		<th width=50px></th>
	</tr></thead>";
	foreach ($list as $item => $quiz) {
		$voted = $wpdb->get_results("SELECT MIN(voted) as 'voted' FROM ".$wpdb->prefix."tquiz_questions WHERE quiz_id = ".$quiz['id'], ARRAY_A);
		echo "<tr>";
		echo "<td>".($count - $item)."</td>";
		echo '<td><a href="?page=tquiz-admin-page&act=edit&quiz_id='.$quiz['id'].'" target="_blank">
		'.$quiz['name'].'</a> </td>';
		echo '<td>('.date('d.m.y h:i', $quiz['time']).')</td>';
		echo '<td><input type="text" value="[tquiz id=&quot;'.$quiz['id'].'&quot;]"></td>';
		echo "<td>".($voted[0]['voted'])."</td>";
		echo "<td>
			<a href='?page=tquiz-admin-page&act=edit&quiz_id=".$quiz['id']."' target='_blank'><span class='dashicons dashicons-edit'></span></a>
			<span class='edit_quiz' data-quiz_id=".$quiz['id']."></span>
			<span class='delete_quiz' data-quiz_id=".$quiz['id']."><span class='dashicons dashicons-trash'></span></span>
		</td>";
		echo "</tr>";
	}
	echo "</table>";
}



