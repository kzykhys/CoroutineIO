<?php

class ValueTest extends \PHPUnit_Framework_TestCase
{

    public function testValue()
    {
        $value = new \CoroutineIO\Scheduler\Value(1000);

        $this->assertEquals(1000, $value->get());
    }

} 