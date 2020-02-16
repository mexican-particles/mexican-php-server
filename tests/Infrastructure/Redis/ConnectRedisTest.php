<?php

namespace Tests\Infrastructure\Redis;

use Exception;
use Redis;
use Tests\TestCase;

/**
 * @package Tests\Infrastructure\Redis
 */
class ConnectRedisTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testConnecting()
    {
        $app = $this->getAppInstance();
        $redis = $app->getContainer()->get(Redis::class);
        $redis->set($key = 'testKey', $expected = 'hoge');
        self::assertSame($expected, $redis->get($key));
    }
}