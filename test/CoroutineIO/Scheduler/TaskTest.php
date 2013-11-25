<?php

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{

    public function testTask()
    {
        $task = new \CoroutineIO\Scheduler\Task(1, $this->coroutine1());

        $this->assertEquals(1, $task->getId());
        $task->setId(2);
        $this->assertEquals(2, $task->getId());
    }

    public function testRun()
    {
        $task = new \CoroutineIO\Scheduler\Task(1, $this->coroutine2());
        $task->setValue(100);
        $task->run();
        $task->run();

        $this->assertNull($task->getValue());
    }

    protected function coroutine1()
    {
        yield true;
    }

    protected function coroutine2()
    {
        $value = (yield true);

        $this->assertEquals(100, $value);
    }

} 