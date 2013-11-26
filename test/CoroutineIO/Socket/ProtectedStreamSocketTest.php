<?php

use CoroutineIO\Socket\ProtectedStreamSocket;
use CoroutineIO\Socket\StreamSocket;

class ProtectedStreamSocketTest extends \PHPUnit_Framework_TestCase
{

    public function testSocket()
    {
        $socket = new StreamSocket(@stream_socket_server('tcp://localhost:8001'));
        $pSocket = new ProtectedStreamSocket($socket);

        $pSocket->getId();
        $pSocket->getRemoteName();
        $pSocket->getLocalName();

        $socket->close();
    }

} 