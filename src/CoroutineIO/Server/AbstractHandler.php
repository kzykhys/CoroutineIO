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
        $data   = (yield $reader->read());

        $response = $this->handleRequest($data, new ProtectedSocket($socket));

        $writer = new StreamWriter($socket);

        yield $writer->write($response);
        yield $socket->close();
    }

}