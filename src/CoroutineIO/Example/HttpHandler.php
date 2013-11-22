<?php

namespace CoroutineIO\Example;

use CoroutineIO\Server\AbstractHandler;
use CoroutineIO\Socket\ProtectedSocket;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class HttpHandler extends AbstractHandler
{

    /**
     * {@inheritdoc}
     */
    public function handleRequest($input, ProtectedSocket $socket)
    {
        // Displays request information
        echo $socket->getRemoteName() . "\n";
        echo $input;

        return "HTTP/1.1 200 OK\nContent-Type: text/plain\nContent-Length: 5\n\nHello";
    }

}