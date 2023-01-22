<?php

namespace Potatoquality\TopCheck\Exceptions;

use \Exception;

class EmptyRepositoryException extends Exception
{
    public static function forSystemInfo($info)
    {
        $class = get_class($info);
        return new static("Repository is null in: " . $info);
    }
}
