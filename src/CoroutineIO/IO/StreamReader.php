<?php


namespace CoroutineIO\IO;

use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Task;
use CoroutineIO\Socket\SocketScheduler;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class StreamReader extends Stream
{

    /**
     * @return SystemCall
     */
    public function wait()
    {
        return new SystemCall(function (Task $task, SocketScheduler $scheduler) {
            $scheduler->addReader($this, $task);
        });
    }

    /**
     * @return string
     */
    public function read()
    {
        return $this->socket->read(8048);
    }

} 