<?php

namespace CoroutineIO\Socket;

use CoroutineIO\Scheduler\Scheduler;
use CoroutineIO\Scheduler\Task;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SocketScheduler extends Scheduler
{

    /**
     * @var array
     */
    private $readers = [];

    /**
     * @var array
     */
    private $writers = [];

    /**
     * @param StreamSocket                $socket
     * @param \CoroutineIO\Scheduler\Task $task
     */
    public function addReader(StreamSocket $socket, Task $task)
    {
        if (!isset($this->readers[$socket->getId()])) {
            $this->readers[$socket->getId()] = [$socket, [$task]];
        } else {
            $this->readers[$socket->getId()][1][] = $task;
        }
    }

    /**
     * @param StreamSocket                $socket
     * @param \CoroutineIO\Scheduler\Task $task
     */
    public function addWriter(StreamSocket $socket, Task $task)
    {
        if (!isset($this->writers[$socket->getId()])) {
            $this->writers[$socket->getId()] = [$socket, [$task]];
        } else {
            $this->writers[$socket->getId()][1][] = $task;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->add($this->poll());

        parent::run();
    }

    /**
     * @return \Generator
     */
    protected function poll()
    {
        while (true) {
            if ($this->queue->isEmpty()) {
                $this->doPoll(null);
            } else {
                $this->doPoll(0);
            }
            yield;
        }
    }

    /**
     * @param $timeout
     */
    protected function doPoll($timeout)
    {
        /* @var StreamSocket[] $reader */
        /* @var StreamSocket[] $writer */

        $r = [];
        foreach ($this->readers as $reader) {
            $r[] = $reader[0]->getRaw();
        }

        $w = [];
        foreach ($this->writers as $writer) {
            $w[] = $writer[0]->getRaw();
        }

        $e = [];

        if (!(count($this->readers) + count($this->writers))) {
            return;
        }

        if (!stream_select($r, $w, $e, $timeout)) {
            return;
        }

        foreach ($r as $socket) {
            list(, $tasks) = $this->readers[(int) $socket];
            unset($this->readers[(int) $socket]);

            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }

        foreach ($w as $socket) {
            list(, $tasks) = $this->writers[(int) $socket];
            unset($this->writers[(int) $socket]);

            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }
    }

} 