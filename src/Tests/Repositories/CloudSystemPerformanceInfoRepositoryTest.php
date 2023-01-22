<?php

namespace Potatoquality\TopCheck\Tests\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;
use Potatoquality\TopCheck\Repositories\CloudSystemPerformanceInfoRepository;
use Tests\TestCase;

class CloudSystemPerformanceInfoRepositoryTest extends TestCase
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

//    public function test_getToken_makes_call_to_server_if_token_not_stored_locally()
//    {
//        $this->expectException(InvalidCloudCredentialsException::class);
//        $this->getItem('client', null);
//    }

    protected function getItem($clientID = 'client', $secret = 'secret')
    {
        $responseArray = [
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
        ];

        $guzzle = new Client([
            "base_uri" => "http://potato.com",
            "handler" => HandlerStack::create(new MockHandler($responseArray))
        ]);

        return new CloudSystemPerformanceInfoRepository($clientID, $secret, $guzzle);
    }
}
