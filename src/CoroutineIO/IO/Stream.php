<?php


namespace CoroutineIO\IO;

use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Socket\Socket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
abstract class Stream
{

    /**
     * @var \CoroutineIO\Socket\Socket
     */
    protected $socket;

    /**
     * @param Socket $socket
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->socket->getId();
    }

    /**
     * @return Socket
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @return SystemCall
     */
    abstract public function wait();

} 