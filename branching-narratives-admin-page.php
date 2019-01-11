<?php
// добавляем панель управления плагином
function branching_narratives_menu() {
	$page_hook_suffix = add_posts_page( 'Нарративы_1', 'Статистика нарративов', 'edit_posts', 'branching-narratives-admin-page', 'branching_narratives_admin' );

	
	//add_posts_page('Редактирование викторины', 'Редактирование викторины', 'edit_posts', 'branching-narratives-edit-quiz', 'branching_narratives_edit' );
	
	
	//add_action('admin_print_scripts-' . $page_hook_suffix, 'tp_admin_custom_scripts');
	
	//Страница конфигурации плагина
	//add_submenu_page("edit.php","Настройки Викторин","Настройки викторин","manage_options","tp_quiz_config","tp_quiz_config");
}


/* function tp_quiz_config(){
	require_once("branching-narratives-config-page.php");
}
 */
/* function tp_admin_custom_scripts(){
	wp_enqueue_script('tp_quiz_admin', plugin_dir_url(__FILE__).'js/admin.js',array('jquery'), false, true);
	wp_enqueue_style('tp_quiz_admin-style',plugin_dir_url(__FILE__).'css/admin-style.css');
} */


//Код дальше выводит страницу со списком плагинов и прочее
function branching_narratives_admin() {
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	/* 
	// если нужно, то показываем страницу редактирования
	if ($_GET['act'] == 'edit') {
	include('branching-narratives-edit-quiz.php');
	return;
	} */

	// обрабатываем и сохраняем новую викторину, выводим 
	//require_once('branching-narratives-create.php');

	// подключаем функцию, которая выводит список викторин (showbranching_narrativesList())
	// require_once('branching-narratives-list.php');

	// выводим список викторин и форму создания новой (делаем доступной по клике на кнопку создания)
	// стандартные настройки 
	?>

	<div class="wrap" id="branching_narratives">
		<h1>Нарративы <a href="/wp-admin/post-new.php?post_type=narratives" class="page-title-action" id="create">Добавить новую</a></h1>


		<div id="quiz_list">
			<?php //showbranching_narrativesList() ?>
		</div>

	</div>
<?php
}
