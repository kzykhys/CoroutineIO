<?php

namespace CoroutineIO\IO;

use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Task;
use CoroutineIO\Socket\SocketScheduler;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class StreamWriter extends Stream
{

    /**
     * @return SystemCall
     */
    public function wait()
    {
        return new SystemCall(function (Task $task, SocketScheduler $scheduler) {
            $scheduler->addWriter($this, $task);
        });
    }

    /**
     * @param $buffer
     *
     * @return int
     */
    public function write($buffer)
    {
        yield $this->wait();
        $this->socket->write($buffer);
    }

}