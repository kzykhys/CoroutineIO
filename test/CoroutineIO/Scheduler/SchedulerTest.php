<?php

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SchedulerTest extends \PHPUnit_Framework_TestCase
{

    public function testAddGenerator()
    {
        $scheduler = new \CoroutineIO\Scheduler\Scheduler();
        $scheduler->add($this->coroutineTest1());
    }

    public function testRun()
    {
        $scheduler = new \CoroutineIO\Scheduler\Scheduler();
        $scheduler->add($this->coroutineTest1());
        $scheduler->run();
    }

    public function testStackedCoroutine()
    {
        $scheduler = new \CoroutineIO\Scheduler\Scheduler();
        $scheduler->add($this->coroutineTest2());
        $scheduler->run();
    }

    public function testKill()
    {
        $scheduler = new \CoroutineIO\Scheduler\Scheduler();
        $id = $scheduler->add($this->coroutineTest1());
        $scheduler->kill($id);
        $scheduler->add($this->coroutineKillTest2());
        $scheduler->run();
        $this->assertFalse($scheduler->kill(0));
    }

    public function testSystemCall()
    {
        $scheduler = new \CoroutineIO\Scheduler\Scheduler();
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
        $value = (yield new \CoroutineIO\Scheduler\Value(1000));
        $this->assertEquals(1000, $value);
    }

    protected function coroutineKillTest1()
    {
        yield \CoroutineIO\Scheduler\SystemCall::create($this->coroutineTest1());
    }

    protected function coroutineKillTest2()
    {
        $id = (yield \CoroutineIO\Scheduler\SystemCall::create($this->coroutineTest1()));
        yield \CoroutineIO\Scheduler\SystemCall::kill($id);
    }

} 