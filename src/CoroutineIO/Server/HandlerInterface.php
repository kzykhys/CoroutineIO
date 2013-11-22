<?php

namespace CoroutineIO\Server;

use CoroutineIO\Socket\ProtectedSocket;
use CoroutineIO\Socket\Socket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
interface HandlerInterface
{

    /**
     * @param Socket $socket
     * @return \Generator
     */
    public function handleClient(Socket $socket);

    /**
     * @param string                              $input
     * @param ProtectedSocket $socket
     *
     * @return mixed
     */
    public function handleRequest($input, ProtectedSocket $socket);

}