<?php

use CoroutineIO\Example\HttpHandler;
use CoroutineIO\Example\HttpServer;

class ServerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HttpServer
     */
    private $server;

    public function testServer()
    {
        $this->server = new HttpServer(new HttpHandler());

        $scheduler = new \CoroutineIO\Socket\SocketScheduler();
        $scheduler->add($this->server->listen('localhost:8000'));
        $scheduler->add($this->abort());
        $scheduler->run();
    }

    public function abort()
    {
        $this->server->shutdown();

        yield \CoroutineIO\Scheduler\SystemCall::shutdown();
    }

} 