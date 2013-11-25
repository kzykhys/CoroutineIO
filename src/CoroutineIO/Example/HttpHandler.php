<?php

namespace CoroutineIO\Example;

use CoroutineIO\Socket\ProtectedStreamSocket;
use CoroutineIO\Server\AbstractHandler;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 *
 * @codeCoverageIgnore
 */
class HttpHandler extends AbstractHandler
{

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