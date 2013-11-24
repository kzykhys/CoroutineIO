<?php

namespace CoroutineIO\Server;

use CoroutineIO\IO\ProtectedStreamSocket;
use CoroutineIO\IO\StreamSocket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
abstract class AbstractHandler implements HandlerInterface
{

    /**
     * @param \CoroutineIO\IO\StreamSocket $socket
     *
     * @return \Generator
     */
    public function handleClient(StreamSocket $socket)
    {
        $data = (yield $socket->read(8048));

        $response = $this->handleRequest($data, new ProtectedStreamSocket($socket));

        yield $socket->write($response);
        yield $socket->close();
    }

}