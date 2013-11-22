<?php

namespace CoroutineIO\Server;

use CoroutineIO\IO\StreamSocket;
use CoroutineIO\Socket\ProtectedSocket;

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

        $response = $this->handleRequest($data, new ProtectedSocket($socket));

        yield $socket->write($response);
        yield $socket->close();
    }

}