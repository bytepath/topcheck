<?php

namespace Potatoquality\TopCheck\Factories;

use Potatoquality\TopCheck\Exceptions\CommandNotFoundException;
use Potatoquality\TopCheck\ShellCommands\FakeTopCommand;

class CommandFactory
{
    /**
     * Returns the command to use for the provided operating system.
     * @param $currentOS
     * @return mixed
     * @throws CommandNotFoundException
     */
    public static function forOperatingSystem($currentOS) {
        // Check and see if a command for the current OS exists in the Potatoquality\TopCheck\ShellCommands namespace.
        // Example: If your OS is Linux, this will look for a class called
        // Potatoquality\TopCheck\ShellCommands\LinuxTopCommand
        $namespace = "Potatoquality\\TopCheck\\ShellCommands\\";
        $command = $currentOS . "TopCommand";
        $className = $namespace . $command;
        if(class_exists($className)) {
            return new $className();
        }

        throw CommandNotFoundException::forOperatingSystem($currentOS);
    }
}
