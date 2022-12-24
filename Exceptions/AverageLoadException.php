<?php

namespace Domain\TopCheck\Exceptions;

use \Exception;

class AverageLoadException extends Exception
{
    public static function forEmptyArray()
    {
        return new static("AverageLoad class was passed an empty array");
    }
}
