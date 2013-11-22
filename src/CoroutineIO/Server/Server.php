<?php

namespace CoroutineIO\Server;

use CoroutineIO\Exception\Exception;
use CoroutineIO\IO\StreamReader;
use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Value;
use CoroutineIO\Socket\Socket;
use CoroutineIO\Socket\SocketScheduler;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
abstract class Server
{

    /**
     * @var HandlerInterface
     */
    private $handler;

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
    public function run($address = 'localhost:8000')
    {
        $scheduler = new SocketScheduler();
        $scheduler->add($this->listen($address));
        $scheduler->run();
    }

    /**
     * @param string $address
     * @throws \Exception
     * @return \Generator
     */
    public function listen($address)
    {
        $socket = new Socket($this->createSocket($address));

        while (true) {
            yield SystemCall::create(
                $this->handler->handleClient(yield (new Value($socket->accept())))
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