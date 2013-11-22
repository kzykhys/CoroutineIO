<?php

namespace CoroutineIO\Example;

use CoroutineIO\Exception\Exception;
use CoroutineIO\Server\Server;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
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
    public function createSocket($address = 'localhost:8000')
    {
        $socket = @stream_socket_server('tcp://' . $address, $no, $str);

        if (!$socket) {
            throw new Exception("$str ($no)");
        }

        return $socket;
    }

}