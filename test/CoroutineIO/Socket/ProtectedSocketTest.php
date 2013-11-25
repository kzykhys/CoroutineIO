<?php

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class ProtectedSocketTest extends \PHPUnit_Framework_TestCase
{

    public function testProtectedSocket()
    {
        $socket = new \CoroutineIO\Socket\Socket(fopen('php://memory', 'r'));
        $pSocket = new \CoroutineIO\Socket\ProtectedSocket($socket);

        $this->assertEquals($pSocket->getId(), $socket->getId());
    }

} 