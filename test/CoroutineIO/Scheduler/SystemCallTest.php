<?php

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class SystemCallTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $systemCall = \CoroutineIO\Scheduler\SystemCall::create($this->coroutine());

        /** @noinspection PhpParamsInspection */
        $this->assertTrue(is_callable($systemCall));
    }

    protected function coroutine()
    {
        yield 1;
    }

} 