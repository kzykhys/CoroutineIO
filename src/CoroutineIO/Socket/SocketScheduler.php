<?php

namespace CoroutineIO\Socket;

use CoroutineIO\IO\StreamReader;
use CoroutineIO\IO\StreamWriter;
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
     * @param StreamReader                $reader
     * @param \CoroutineIO\Scheduler\Task $task
     */
    public function addReader(StreamReader $reader, Task $task)
    {
        if (!isset($this->readers[$reader->getId()])) {
            $this->readers[$reader->getId()] = [$reader, [$task]];
        } else {
            $this->readers[$reader->getId()][1][] = $task;
        }
    }

    /**
     * @param StreamWriter                $writer
     * @param \CoroutineIO\Scheduler\Task $task
     */
    public function addWriter(StreamWriter $writer, Task $task)
    {
        if (!isset($this->writers[$writer->getId()])) {
            $this->writers[$writer->getId()] = [$writer, [$task]];
        } else {
            $this->writers[$writer->getId()][1][] = $task;
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
        /* @var StreamReader[] $reader */
        /* @var StreamWriter[] $writer */

        $r = [];
        foreach ($this->readers as $reader) {
            $r[] = $reader[0]->getSocket()->getRaw();
        }

        $w = [];
        foreach ($this->writers as $writer) {
            $w[] = $writer[0]->getSocket()->getRaw();
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