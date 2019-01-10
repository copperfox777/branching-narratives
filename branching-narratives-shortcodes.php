<?php
//Шорткоды начальной секции, показывается один раз при зугрузке, она впоследствии будет затёрта новым текстом. 
function main_section_shortcode($atts, $content = null ) {
    extract(shortcode_atts(array(
        'name' => 'name'
    ), $atts));
    
	$begining='<section name="active">';
	$end = '</section>';
	return $begining . do_shortcode($content) . $end;
}
add_shortcode('вступление', 'main_section_shortcode');


//Шорткоды секций - это основное содержание
function section_shortcode($atts, $content = null ) {
    extract(shortcode_atts(array(
        'name' => 'name'
    ), $atts));
    
	$begining='<section class="hidden" name="' . $name . '">';
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