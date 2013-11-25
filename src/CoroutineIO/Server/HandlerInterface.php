<?php

namespace CoroutineIO\Server;

use CoroutineIO\Socket\StreamSocket;

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


}