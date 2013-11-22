<?php

namespace CoroutineIO\Server;

use CoroutineIO\IO\StreamSocket;
use CoroutineIO\Socket\ProtectedSocket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
interface HandlerInterface
{

    /**
     * @param StreamSocket $socket
     * @return \Generator
     */
    public function handleClient(StreamSocket $socket);

    /**
     * @param string                              $input
     * @param ProtectedSocket $socket
     *
     * @return mixed
     */
    public function handleRequest($input, ProtectedSocket $socket);

}