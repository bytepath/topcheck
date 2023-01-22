<?php

namespace Potatoquality\TopCheck\Exceptions;

use \Exception;

class CommandNotFoundException extends Exception
{
    public static function forOperatingSystem($currentOS)
    {
        return new static("Could not find a TopCommand for operating system: " . $currentOS);
    }
}
