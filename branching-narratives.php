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
		wp_enqueue_script('narrscript', plugins_url( '/narrscript.js', __FILE__ ), array('jquery'), filetime(plugins_url( '/narrscript.js', __FILE__ )), true);
		wp_enqueue_style('narrstyle', plugin_dir_url(__FILE__).'/style.css',filetime(plugin_dir_url(__FILE__).'/style.css'));
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



//ШОРТКОДЫ
//Шорткоды начальной секции - сюда будет помещен овет
function main_section_shortcode($atts, $content = null ) {
    extract(shortcode_atts(array(
        'name' => 'name'
    ), $atts));
    
	$begining='<section label="active">';
	$end = '</section>';
	return $begining . do_shortcode($content) . $end;
}
add_shortcode('начальная_секция', 'main_section_shortcode');


//Шорткоды секций - это основное содержание
function section_shortcode($atts, $content = null ) {
    extract(shortcode_atts(array(
        'name' => 'name'
    ), $atts));
    
	$begining='<section class="hidden" label="' . $name . '">';
	$end = '</section>';
	return $begining . do_shortcode($content) . $end;
}
add_shortcode('секция', 'section_shortcode');


//Шорткод области выбора
function quizitem_shortcode($atts,$content = null ) {
   $begining='<hr><div class="quiz_item" style="display: block;">';
   $end = '</div>';
   return $begining . do_shortcode($content) . $end;
}
add_shortcode('область_ответов', 'quizitem_shortcode');


//Вопрос для выбора(не обязательно)
function question_shortcode($atts,$content = null ) {
   $begining='<div class="question"><p><span style="font-weight: 400;">';
   $end = '</span></p></div>';
   return $begining . do_shortcode($content) . $end;
}
add_shortcode('вопрос', 'question_shortcode');

//Начало вариантов ответа
function quizanswers_shortcode($atts,$content = null ) {
   $begining='<div class="answers">';
   $end = '</div>';
   return $begining . do_shortcode($content) . $end;
}
add_shortcode('ответы', 'quizanswers_shortcode');

//Ответ
function quizanswer_shortcode($atts, $content = null ) {
    extract(shortcode_atts(array(
        'goto' => 'goto'
    ), $atts));
    
	$begining='<div class="answer" goto="'. $goto.'"><span data-role="icon" class="quiz_icon"><span class="answer_circle">O</span></span><div class="answer_text">';
	$end = '</div></div>'; 
	return $begining . do_shortcode($content) . $end;   
}
add_shortcode('ответ', 'quizanswer_shortcode');



