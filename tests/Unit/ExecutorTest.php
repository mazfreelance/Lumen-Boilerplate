<?php

use Tests\TestCase;
use App\Ship\Support\Facades\Executor;
use App\Ship\Support\Executor as SupportExecutor;

/**
 * @coversDefaultClass \App\Ship\Support\Executor
 */
class ExecutorTest extends TestCase
{
    /**
     * Can set api version test
     *
     * @covers ::setApiVersion
     */
    public function testCanSetApiVersion()
    {
        Executor::setApiVersion('v_test');
        $this->assertEquals('v_test', SupportExecutor::$apiVersion);
    }

    /**
     * Can get api version test
     *
     * @covers ::getApiVersion
     */
    public function testCanGetApiVersion()
    {
        SupportExecutor::$apiVersion = 'v_test';
        $this->assertEquals('v_test', Executor::getApiVersion());
    }
}
