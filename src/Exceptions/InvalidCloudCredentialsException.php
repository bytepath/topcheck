<?php

namespace Potatoquality\TopCheck\Exceptions;

use \Exception;

/**
 * This exception is thrown if the credentials passed to the CloudSystemPerformanceInfoRepository class are invalid in
 * some way.
 */
class InvalidCloudCredentialsException extends Exception
{
    /**
     * You passed a client ID that is no good
     * @param $client string the invalid client ID value
     * @return static
     */
    public static function forClientID($client)
    {
        if($client === null) {
            $client = "null";
        }

        return new static("Provided Client ID is invalid. ($client)");
    }

    /**
     * You passed a client secret that is no good
     * @param $secret string the invalid client secret value
     * @return static
     */
    public static function forClientSecret($secret)
    {
        if($secret === null) {
            $secret = "null";
        }
        return new static("Provided Client Secret is invalid. ($secret)");
    }

    /**
     * You passed a url that is no good
     * @param $url string the invalid url
     * @return static
     */
    public static function forUrl($url)
    {
        if($url === null) {
            $url = "null";
        }

        return new static("Provided URL is invalid. ($url)");
    }
}
