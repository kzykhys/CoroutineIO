<?php

namespace CoroutineIO\Scheduler;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class Scheduler
{

    /**
     * @var int
     */
    protected $sequence = 0;

    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * @var \SplQueue|Task[]
     */
    protected $queue;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    /**
     * @param \Generator $coroutine
     *
     * @return int
     */
    public function add(\Generator $coroutine)
    {
        $id = ++$this->sequence;
        $task = new Task($id, $coroutine);
        $this->tasks[$id] = $task;
        $this->schedule($task);

        return $id;
    }

    /**
     * @param Task $task
     */
    public function schedule(Task $task)
    {
        $this->queue->enqueue($task);
    }

    /**
     * Starts scheduler
     */
    public function run()
    {
        while (!$this->queue->isEmpty()) {
            $task = $this->queue->dequeue();
            $return = $task->run();

            if ($return instanceof SystemCall) {
                $return($task, $this);
                continue;
            }

            if ($task->isFinished()) {
                unset($this->tasks[$task->getId()]);
            } else {
                $this->schedule($task);
            }
        }
    }

} 