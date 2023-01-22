<?php

namespace Potatoquality\TopCheck\Tests\Containers;

use Carbon\Carbon;
use Potatoquality\TopCheck\Containers\AuthToken;
use Tests\TestCase;

class AuthTokenTest extends TestCase
{
    public function test_getToken_returns_auth_token()
    {
        $this->assertEquals("potato", (new AuthToken("potato", 0))->getToken());
    }

    public function test_getExpiresAt_returns_expiry_time()
    {
        Carbon::setTestNow(Carbon::createFromTimestamp(0));

        // The expires InSeconds value is added to Carbon->now() to determine expiry date
        $expires = (new AuthToken("potato", 0))->getExpiresAt();
        $this->assertIsClass(Carbon::class, $expires);
        $this->assertEquals(0, $expires->timestamp);

        // This time we add 30 seconds so the time should be 30
        $expires = (new AuthToken("potato", 30))->getExpiresAt();
        $this->assertIsClass(Carbon::class, $expires);
        $this->assertEquals(30, $expires->timestamp);
    }
}
