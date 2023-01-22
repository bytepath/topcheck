<?php

namespace Potatoquality\TopCheck\Tests\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;
use Potatoquality\TopCheck\Repositories\CloudSystemPerformanceInfoRepository;
use Potatoquality\TopCheck\ShellCommands\FakeTopCommand;
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

    public function test_save_method_sends_SystemPerformanceInfo_object_to_server()
    {
        $handler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode([
                "token_type" => "Bearer",
                "expires_in" => 1,
                "access_token" => "potato",
            ])),

            new Response(200, [], "CAT"),
        ]);

        ($this->getItem('client', 'secret', $handler)->save((new FakeTopCommand())->run()));

        $this->assertEquals($handler->getLastRequest()->getUri()->getPath(), "/api/v1/performance/snapshot");
    }

    protected function getItem($clientID = 'client', $secret = 'secret', $handler = null)
    {
        $responseArray = [
            new Response(200, [], "CAT"),
        ];

        if ($handler === null) {
            $handler = new MockHandler($responseArray);
        }

        $guzzle = new Client([
            "base_uri" => "http://potato.com",
            "handler" => HandlerStack::create($handler)
        ]);

        return new CloudSystemPerformanceInfoRepository($clientID, $secret, $guzzle);
    }
}
