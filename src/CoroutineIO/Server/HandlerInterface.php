<?php

namespace CoroutineIO\Server;

use CoroutineIO\IO\ProtectedStreamSocket;
use CoroutineIO\IO\StreamSocket;

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
     * @param ProtectedStreamSocket $socket
     *
     * @return mixed
     */
    public function handleRequest($input, ProtectedStreamSocket $socket);

}