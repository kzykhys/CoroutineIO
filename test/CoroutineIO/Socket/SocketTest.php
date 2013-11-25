<?php

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SocketTest extends \PHPUnit_Framework_TestCase
{

    public function testSocket()
    {
        $socket = new \CoroutineIO\Socket\Socket(fopen('php://memory', 'w'));
        $this->assertEquals(3, $socket->write('ABC'));

        rewind($socket->getRaw());
        $this->assertEquals('ABC', $socket->read(1024));

        $id1 = $socket->getId();
        $socket->close();

        $socket = new \CoroutineIO\Socket\Socket(fopen('php://temp', 'r'));

        $this->assertNotEquals($id1, $socket->getId());

        $socket->close();
    }

} 