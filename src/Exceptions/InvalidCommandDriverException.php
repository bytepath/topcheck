<?php

namespace Potatoquality\TopCheck\Exceptions;

use \Exception;

/**
 * This exception is thrown if the $driver string passed to PersistPerformanceInfoFactory was invalid in some way
 */
class InvalidCommandDriverException extends Exception
{
    /**
     * You passed a driver that is no good
     * @param $driver string the invalid driver
     * @return static
     */
    public static function forDriver($driver)
    {
        if($driver === null) {
            $driver = "null";
        }

        return new static("Provided command driver is invalid. ($driver)");
    }
}
