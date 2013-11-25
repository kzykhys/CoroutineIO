<?php

namespace CoroutineIO\Server;

use CoroutineIO\Exception\Exception;
use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Socket\SocketScheduler;
use CoroutineIO\Socket\StreamSocket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
abstract class Server
{

    /**
     * @var HandlerInterface
     */
    protected $handler;

    /**
     * @param HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Run as a single server
     *
     * @param string $address
     */
    public function run($address = '127.0.0.1:8000')
    {
        $scheduler = new SocketScheduler();
        $scheduler->add($this->listen($address));
        $scheduler->run();
    }

    /**
     * @param string $address
     *
     * @throws \Exception
     * @return \Generator
     */
    public function listen($address)
    {
        $socket = new StreamSocket($this->createSocket($address));
        $socket->block(false);

        while (true) {
            yield SystemCall::create(
                $this->handler->handleClient(yield $socket->accept())
            );
        }
    }

    /**
     * @param string $address example: localhost:8000
     *
     * @throws Exception
     *
     * @return resource
     */
    abstract public function createSocket($address);

} 