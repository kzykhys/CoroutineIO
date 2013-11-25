<?php

namespace CoroutineIO\Example;

use CoroutineIO\Exception\Exception;
use CoroutineIO\Server\Server;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 *
 * @codeCoverageIgnore
 */
class HttpServer extends Server
{

    /**
     * @param string $address example: localhost:8000
     *
     * @throws Exception
     *
     * @return resource
     */
    public function createSocket($address = '127.0.0.1:8001')
    {
        $socket = @stream_socket_server('tcp://' . $address, $no, $str);

        if (!$socket) {
            throw new Exception("$str ($no)");
        }

        return $socket;
    }

}