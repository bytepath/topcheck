<?php

namespace Potatoquality\TopCheck\Exceptions;

class EmptyRepositoryException
{
    public static function forSystemInfo($info)
    {
        $class = get_class($info);
        return new static("Repository is null in: " . $info);
    }
}
