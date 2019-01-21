<?php
// Здесь мы обрабатываем клик и добавляем статистику в мемкэш
header('Content-Type: text/html');
header('X-Content-Type-Options: nosniff');

header('Cache-Control: no-cache');
header('Pragma: no-cache');

define('SHORTINIT', true);
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

$m = new Memcached();
if($m->addServer('localhost', 11211)===FALSE){echo 'error connecting memcached server';}
$stat_arr = $m->get('stat');
print_r($stat_arr);
