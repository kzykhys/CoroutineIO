<?php

use CoroutineIO\Example\HttpHandler;
use CoroutineIO\Example\HttpServer;

require __DIR__ . '/vendor/autoload.php';

$server = new HttpServer(new HttpHandler());
$server->run('localhost:8000');