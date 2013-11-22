<?php

namespace CoroutineIO\Scheduler;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SystemCall
{

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param \Generator $coroutine
     *
     * @return static
     */
    public static function create(\Generator $coroutine)
    {
        return new static(function (Task $task, Scheduler $scheduler) use ($coroutine) {
            $task->setValue($scheduler->add($coroutine));
            $scheduler->schedule($task);
        });
    }

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Task      $task
     * @param Scheduler $scheduler
     *
     * @return mixed
     */
    public function __invoke(Task $task, Scheduler $scheduler)
    {
        $callback = $this->callback;

        return $callback($task, $scheduler);
    }

} 