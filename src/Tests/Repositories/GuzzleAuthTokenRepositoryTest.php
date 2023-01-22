<?php

namespace Potatoquality\TopCheck\Tests\Repositories;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Potatoquality\TopCheck\Containers\AuthToken;
use Potatoquality\TopCheck\Repositories\GuzzleAuthTokenRepository;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;
use Tests\TestCase;

class GuzzleAuthTokenRepositoryTest extends TestCase
{
    public function test_throws_exception_if_clientID_null()
    {
        $this->expectException(InvalidCloudCredentialsException::class);
        $this->getItem(null);
    }

    public function test_throws_exception_if_secret_null()
    {
        $this->expectException(InvalidCloudCredentialsException::class);
        $this->getItem('client', null);
    }

    public function test_fetch_makes_call_to_server_to_get_token()
    {
        $handler = new MockHandler([new Response(200, ['X-Foo' => 'Bar'], json_encode([
            "token_type" => "Bearer",
            "expires_in" => 1,
            "access_token" => "potato",
        ]))]);
        $result = $this->getItem('client', 'secret', $handler)->fetch();

        $this->assertIsClass(AuthToken::class, $result);
        $this->assertEquals('potato', $result->getToken());
        $this->assertEquals(Carbon::now()->addSeconds(1)->timestamp, $result->getExpiresAt()->timestamp);
        $this->assertEquals("/oauth/token", $handler->getLastRequest()->getUri()->getPath());
    }

    protected function getItem($clientID = 'client', $secret = 'secret', $handler = null)
    {
        $responseArray = [
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
        ];

        if ($handler === null) {
            $handler = new MockHandler($responseArray);
        }

        $guzzle = new Client([
            "base_uri" => "http://potato.com",
            "handler" => HandlerStack::create($handler)
        ]);

        return new GuzzleAuthTokenRepository($clientID, $secret, $guzzle);
    }
}
