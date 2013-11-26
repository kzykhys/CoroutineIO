<?php
use CoroutineIO\Scheduler\Scheduler;
use CoroutineIO\Scheduler\SystemCall;
use CoroutineIO\Scheduler\Value;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SchedulerTest extends \PHPUnit_Framework_TestCase
{

    public function testAddGenerator()
    {
        $scheduler = new Scheduler();
        $scheduler->add($this->coroutineTest1());
    }

    public function testRun()
    {
        $scheduler = new Scheduler();
        $scheduler->add($this->coroutineTest1());
        $scheduler->run();
    }

    public function testStackedCoroutine()
    {
        $scheduler = new Scheduler();
        $scheduler->add($this->coroutineTest2());
        $scheduler->run();
    }

    public function testKill()
    {
        $scheduler = new Scheduler();
        $id = $scheduler->add($this->coroutineTest1());
        $scheduler->kill($id);
        $scheduler->add($this->coroutineKillTest2());
        $scheduler->run();
        $this->assertFalse($scheduler->kill(0));
    }

    public function testShutdown()
    {
        $scheduler = new Scheduler();
        $scheduler->add($this->infiniteLoop());
        $scheduler->add($this->shutdownTask());
        $scheduler->run();
    }

    public function testSystemCall()
    {
        $scheduler = new Scheduler();
        $scheduler->add($this->coroutineKillTest1());
        $scheduler->run();
    }

    protected function coroutineTest1()
    {
        for ($i = 0; $i < 5; $i++) {
            yield $i;
        }
    }

    protected function coroutineTest2()
    {
        yield $this->coroutineTest1();
        $value = (yield new Value(1000));
        $this->assertEquals(1000, $value);
    }

    protected function coroutineKillTest1()
    {
        yield SystemCall::create($this->coroutineTest1());
    }

    protected function coroutineKillTest2()
    {
        $id = (yield SystemCall::create($this->coroutineTest1()));
        yield SystemCall::kill($id);
    }

    protected function infiniteLoop()
    {
        while (true) {
            yield;
        }
    }

    protected function shutdownTask()
    {
        yield SystemCall::shutdown();
    }

} 