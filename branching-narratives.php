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
			'show_in_menu' => 'edit.php',
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





