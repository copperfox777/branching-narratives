<?php
header('Content-Type: text/html');
header('X-Content-Type-Options: nosniff');

header('Cache-Control: no-cache');
header('Pragma: no-cache');

$memcached = new Memcached();
if ($memcached->addServer("127.0.0.1", 11211)) {
    $m->set('int', 99);
    $m->set('string', 'a simple string');
    $m->set('array', array(11, 12));
    /* expire 'object' key in 5 minutes */
    $m->set('object', new stdclass, time() + 300);


    var_dump($m->get('int'));
    var_dump($m->get('string'));
    var_dump($m->get('array'));
    var_dump($m->get('object'));
} 
