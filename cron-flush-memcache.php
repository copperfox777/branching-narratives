<?php
$m = new Memcached();

if($m->addServer('localhost', 11211)){
    $stat = $m->get($post_id);
    print_r($stat);
    
}