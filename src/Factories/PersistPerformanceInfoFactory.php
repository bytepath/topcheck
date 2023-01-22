<?php

namespace Potatoquality\TopCheck\Factories;

use GuzzleHttp\Client;
use Potatoquality\TopCheck\Exceptions\CommandNotFoundException;
use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;
use Potatoquality\TopCheck\Exceptions\InvalidCommandDriverException;
use Potatoquality\TopCheck\Repositories\CloudSystemPerformanceInfoRepository;
use Potatoquality\TopCheck\Repositories\LocalSystemPerformanceInfoRepository;

/**
 * Returns a class that can be used to persist/save SystemPerformanceInfo objects
 */
class PersistPerformanceInfoFactory
{
    /**
     * Returns a repository used to persist performance info for the provided driver
     * @param string $driver the driver to use. Likely comes from a config file. Example: local, cloud, etc
     * @param string $client (optional) the client_id to use for cloud driver
     * @param string $secret (optional) the secret to use for cloud driver
     * @param string $url (optional) The url to use for cloud driver
     * @return mixed returns a Repository that has a save method
     * @throws CommandNotFoundException
     */
    public static function forDriver($driver, $client = null, $secret = null, $url = null)
    {
        if($driver === 'local') {
            return new LocalSystemPerformanceInfoRepository();
        }

        if($driver === 'cloud') {
            if($url === null) {
                throw InvalidCloudCredentialsException::forURL($url);
            }

            $guzzleClient = new Client([ "base_uri" => $url ]);
            return new CloudSystemPerformanceInfoRepository($client, $secret, $guzzleClient);
        }


        // You passed an invalid driver that we cant use
        throw InvalidCommandDriverException::forDriver($driver);
    }
}
