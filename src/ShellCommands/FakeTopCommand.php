<?php

namespace Potatoquality\TopCheck\ShellCommands;

use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\Interfaces\TopCommandInterface;

/**
 * Returns a fake SystemPerformanceInfo object you can use for testing
 */
class FakeTopCommand implements TopCommandInterface
{
    public function run(): SystemPerformanceInfo
    {
        return new SystemPerformanceInfo($this->raw());
    }

    public function raw(): array
    {
        dump("Warning -- You are using fake random data meant for testing");

        $randDec = function($max = 100, $min = 0) {
            return "" . mt_rand ($min * 10, $max * 10) / 10;
        };

        $retval = [
            "top" => [
                0 => $randDec(),
                1 => $randDec(),
                2 => $randDec(),
            ],
            "cpu0" => [
                "us" => $randDec(),
                "sy" => $randDec(),
                "ni" => $randDec(),
                "id" => $randDec(),
                "wa" => $randDec(),
                "hi" => $randDec(),
                "si" => $randDec(),
                "st" => $randDec(),
            ],
            "cpu1" => [
                "us" => $randDec(),
                "sy" => $randDec(),
                "ni" => $randDec(),
                "id" => $randDec(),
                "wa" => $randDec(),
                "hi" => $randDec(),
                "si" => $randDec(),
                "st" => $randDec(),
            ],
            "mem" => [
                "total" => $randDec(5000),
                "free" => $randDec(5000),
                "used" =>$randDec(5000),
                "buff" => $randDec(5000),
            ],
            "swap" => [
                "total" => $randDec(5000),
                "free" => $randDec(5000),
                "used" => $randDec(5000),
                "avail" => $randDec(5000),
            ],
        ];

        return $retval;
    }
}
