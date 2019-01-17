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
// Админка в дальнейшем не требуется, всё решено стандартным методом
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
// И заполняем эту колонку
add_action( 'manage_narratives_posts_custom_column' , 'custom_narratives_column', 10, 2 );
function custom_narratives_column( $column, $post_id ) {
    switch ( $column ) {
		case 'statistics' :
		global $wpdb;
		
		// Колличество нажатий "начать"
		/* $starts = $wpdb->get_results("SELECT COUNT(*) AS itm FROM ".$wpdb->prefix."branching_narratives_list WHERE result='start' AND post_id=".$post_id,ARRAY_A);
		 */
		
		 // В скольки сессиях были нажатия, сессий может быть меньше если кто то прошел более 1 раза за сессию
		$sessions = $wpdb->get_results("SELECT COUNT(DISTINCT session_id) AS itm FROM ".$wpdb->prefix."branching_narratives_list WHERE post_id=".$post_id,ARRAY_A);
		// Сколько раз было что то нажато в том числе финиши
		$clicks = $wpdb->get_results("SELECT COUNT(result) AS cnt, result FROM ".$wpdb->prefix."branching_narratives_list WHERE 
		post_id=".$post_id." AND (result LIKE '%finish%' OR result LIKE '%start%') GROUP BY result",ARRAY_A);
		/* $clicks = $wpdb->get_results("SELECT COUNT(result) AS itm, result FROM ".$wpdb->prefix."branching_narratives_list WHERE 
		result LIKE '%finish%' AND post_id=".$post_id." GROUP BY result",ARRAY_A);
		 */
		
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

 
/* function showNarrStat($post_id) {
	global $wpdb;

	$list = $wpdb->get_results("SELECT session_id, result  FROM ".$wpdb->prefix."branching_narratives_list WHERE post_id=".$post_id, ARRAY_A);
	return $list;
}
 */


