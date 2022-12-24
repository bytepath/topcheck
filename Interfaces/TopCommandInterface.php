<?php

namespace Domain\TopCheck\Interfaces;

use Domain\TopCheck\Containers\SystemPerformanceInfo;

/**
 * Defines a class that uses the top command to get the current performance information of the system.
 */
interface TopCommandInterface
{
    /**
     * Runs a command that will get the current performance information for the system
     * @return SystemPerformanceInfo
     */
    public function run(): SystemPerformanceInfo;
}
