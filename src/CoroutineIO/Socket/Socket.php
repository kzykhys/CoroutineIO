<?php


namespace CoroutineIO\Socket;

class Socket
{

    protected $socket;

    /**
     * @param $socket
     */
    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->socket;
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->socket;
    }

    /**
     * @param $length
     *
     * @return string
     */
    public function read($length)
    {
        return fread($this->socket, $length);
    }

    /**
     * @param $buffer
     *
     * @return int
     */
    public function write($buffer)
    {
        return fwrite($this->socket, $buffer);
    }

    /**
     *
     */
    public function close()
    {
        return fclose($this->socket);
    }

} 