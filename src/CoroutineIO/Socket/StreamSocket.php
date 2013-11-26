<?php

namespace CoroutineIO\Socket;

use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Task;
use CoroutineIO\Scheduler\Value;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class StreamSocket extends Socket
{

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
     * @param bool $block
     */
    public function block($block = false)
    {
        socket_set_blocking($this->socket, $block);
    }

    /**
     * @return static
     */
    public function accept()
    {
        yield new SystemCall(function (Task $task, SocketScheduler $scheduler) {
            $scheduler->addReader($this, $task);
        });
        yield new Value(new static(stream_socket_accept($this->socket, 0)));
    }

    /**
     * @param $length
     *
     * @return string
     */
    public function read($length)
    {
        yield new SystemCall(function (Task $task, SocketScheduler $scheduler) {
            $scheduler->addReader($this, $task);
        });
        yield new Value(parent::read($length));
    }

    /**
     * @param $buffer
     *
     * @return int
     */
    public function write($buffer)
    {
        yield new SystemCall(function (Task $task, SocketScheduler $scheduler) {
            $scheduler->addWriter($this, $task);
        });
        yield parent::write($buffer);
    }

}