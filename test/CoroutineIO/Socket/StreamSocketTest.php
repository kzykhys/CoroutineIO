<?php

class StreamSocketTest extends \PHPUnit_Framework_TestCase
{

    public function testSocket()
    {
        $socket = @stream_socket_server('tcp://localhost:12345');

        $streamSocket = new \CoroutineIO\Socket\StreamSocket($socket);
        $streamSocket->block(false);
        $streamSocket->getLocalName();
        $streamSocket->getRemoteName();

        $this->assertInstanceOf('Generator', $streamSocket->read(1));
        $this->assertInstanceOf('Generator', $streamSocket->write(''));

        $gen = $streamSocket->read(1);
        $this->assertInstanceOf('CoroutineIO\\Scheduler\\SystemCall', $gen->current());
        $gen->next();
        $this->assertInstanceOf('CoroutineIO\\Scheduler\\Value', $gen->current());

        $streamSocket->close();
    }

} 