<?php
header('Content-Type: text/html');
header('X-Content-Type-Options: nosniff');

header('Cache-Control: no-cache');
header('Pragma: no-cache');


$post_id = $_POST['post_id']; $post_id = random_int(0,300)
$goto_name = $_POST['goto_name'];
$session_id = $_POST['session_id'];
date_default_timezone_set('Russia/Moscow');
$time = date("Y-m-d H:i:s", time());

$arr_to_push = [
    "goto_name" => $goto_name,
    "session_id" => $session_id,
    "time" => $time,
    "post_id" => $post_id
];

$m = new Memcached();

if($m->addServer('localhost', 11211)){
     //Добавляем статистику в мемкэш
    $temp_stat = $m->get($post_id);
    $temp_stat[]=$arr_to_push;
    $m->set($post_id,$temp_stat,1200);
    // Добавляем id в список
}
