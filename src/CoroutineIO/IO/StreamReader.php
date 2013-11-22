<?php


namespace CoroutineIO\IO;

use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Task;
use CoroutineIO\Scheduler\Value;
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
        yield $this->wait();
        yield new Value($this->socket->read(8048));
    }

} 