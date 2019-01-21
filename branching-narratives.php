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

//Подключаем админку
require_once('branching-narratives-admin-page.php');

//Подключаем функционал шорткодов
require_once('branching-narratives-shortcodes.php');

// Подключение крон задачи для выгрузки статистики из мемкеша
// (Статистика заносится в мемкэш с помощью файла stat-to-memcache.php)
require_once('cron-flush-memcache.php');

 
/* function showNarrStat($post_id) {
	global $wpdb;

	$list = $wpdb->get_results("SELECT session_id, result  FROM ".$wpdb->prefix."branching_narratives_list WHERE post_id=".$post_id, ARRAY_A);
	return $list;
}
 */


