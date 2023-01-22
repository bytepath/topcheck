<?php

namespace Potatoquality\TopCheck\Repositories;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Potatoquality\TopCheck\Containers\AuthToken;
use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;

class CloudSystemPerformanceInfoRepository
{
    /**
     * @var string
     */
    protected $clientID = null;

    /**
     * @var string
     */
    protected $clientSecret = null;

    /**
     * The client we use to make the HTTP request
     * @var Client|null
     */
    protected $client = null;

    public function __construct($clientID, $secret, Client $client)
    {
        if (!$clientID) {
            throw InvalidCloudCredentialsException::forClientID($clientID);
        }

        if (!$secret) {
            throw InvalidCloudCredentialsException::forClientSecret($secret);
        }

        $this->clientID = $clientID;
        $this->clientSecret = $secret;
        $this->client = $client;
    }

    public function save(SystemPerformanceInfo $info): bool
    {
        $authToken = $this->fetchAuthToken();
        $arr = $info->toArray();

        return true;
    }

    protected function fetchAuthToken(): AuthToken
    {
        return (new GuzzleAuthTokenRepository($this->clientID, $this->clientSecret, $this->client))->fetch();
    }
}

