<?php


namespace CoroutineIO\Socket;

class Socket
{

    private $socket;

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
     * @return string
     */
    public function getRemoteName()
    {
        return stream_socket_get_name($this->socket, true);
    }

    /**
     * @return string
     */
    public function getLocalName()
    {
        return stream_socket_get_name($this->socket, false);
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->socket;
    }

    /**
     * @return static
     */
    public function accept()
    {
        return new static(stream_socket_accept($this->socket, 0));
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