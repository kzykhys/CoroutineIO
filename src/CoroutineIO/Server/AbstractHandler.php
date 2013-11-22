<?php

namespace CoroutineIO\Server;

use CoroutineIO\IO\StreamReader;
use CoroutineIO\IO\StreamWriter;
use CoroutineIO\Socket\ProtectedSocket;
use CoroutineIO\Socket\Socket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
abstract class AbstractHandler implements HandlerInterface
{

    /**
     * @param Socket $socket
     *
     * @return \Generator
     */
    public function handleClient(Socket $socket)
    {
        $reader = new StreamReader($socket);
        yield $reader->wait();

        $response = $this->handleRequest($reader->read(), new ProtectedSocket($socket));

        $writer = new StreamWriter($socket);
        yield $writer->wait();

        $writer->write($response);
        $socket->close();
    }

}