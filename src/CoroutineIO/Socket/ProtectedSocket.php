<?php

namespace CoroutineIO\Socket;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class ProtectedSocket
{

    /**
     * @var Socket
     */
    private $socket;

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
     * @return string
     */
    public function getRemoteName()
    {
        return $this->socket->getRemoteName();
    }

    /**
     * @return string
     */
    public function getLocalName()
    {
        return $this->socket->getLocalName();
    }

} 