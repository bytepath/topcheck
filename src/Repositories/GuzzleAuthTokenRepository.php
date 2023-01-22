<?php

namespace Potatoquality\TopCheck\Repositories;

use GuzzleHttp\Client;
use Potatoquality\TopCheck\Containers\AuthToken;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;

class GuzzleAuthTokenRepository
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

    public function __construct($clientID, $secret, Client $client = null)
    {
        if(! $clientID) {
            throw InvalidCloudCredentialsException::forClientID($clientID);
        }

        if(! $secret) {
            throw InvalidCloudCredentialsException::forClientSecret($secret);
        }

        $this->clientID = $clientID;
        $this->clientSecret = $secret;
        $this->client = $client;
    }

    public function fetch(): AuthToken
    {
        $response = $this->client->post("/oauth/token", [
            "form_params" => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientID,
                'client_secret' => $this->clientSecret,
                'scope' => '*',
            ]
        ]);

        $result = json_decode($response->getBody()->__toString());
        return new AuthToken($result->access_token, $result->expires_in);
    }
}
