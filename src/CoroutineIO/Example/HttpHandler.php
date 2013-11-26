<?php

namespace CoroutineIO\Example;

use CoroutineIO\Server\HandlerInterface;
use CoroutineIO\Socket\ProtectedStreamSocket;
use CoroutineIO\Socket\StreamSocket;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 *
 * @codeCoverageIgnore
 */
class HttpHandler implements HandlerInterface
{

    /**
     * {@inheritdoc}
     */
    public function handleClient(StreamSocket $socket)
    {
        $socket->block(false);
        $data = (yield $socket->read(8048));

        $response = $this->handleRequest($data, new ProtectedStreamSocket($socket));

        yield $socket->write($response);
        yield $socket->close();
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest($input, ProtectedStreamSocket $socket)
    {
        // Displays request information
        echo $socket->getRemoteName() . "\n";
        echo $input;

        return "HTTP/1.1 200 OK\nContent-Type: text/plain\nContent-Length: 5\n\nHello";
    }

}