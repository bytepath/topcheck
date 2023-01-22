<?php

namespace Potatoquality\TopCheck\ShellCommands;

use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\Interfaces\TopCommandInterface;

/**
 * A script that uses the top command to pull the current performance info for this server.
 * The result of the top cmd is ran through a series of pipes to extract the CPU and Ram data
 */
class DarwinTopCommand extends FakeTopCommand
{
    // Mac OS isn't actually supported yet but I needed this for testing purposes
}
