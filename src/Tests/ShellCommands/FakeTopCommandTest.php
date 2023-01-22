<?php

namespace Potatoquality\TopCheck\Tests\ShellCommands;

use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\ShellCommands\FakeTopCommand;
use Tests\TestCase;

class FakeTopCommandTest extends TestCase
{
    public function test_returns_fake_SystemPerformanceInfo_class()
    {
        $this->assertIsClass(SystemPerformanceInfo::class, $this->getItem()->run());
    }

    public function test_returns_fake_raw_array()
    {
        $arr = $this->getItem()->raw();

        $this->assertTrue(is_array($arr));

        // Top level should have fields for each check type
        foreach(["top", 'cpu0', 'cpu1', 'mem', 'swap'] as $key) {
            $this->assertTrue(array_key_exists($key, $arr));
        }

        // Verify CPU measurement types. Check the top man file for info on what these are
        foreach(["us", "sy", "ni", "id", "wa", "hi", "si", "st"] as $key) {
            $this->assertTrue(array_key_exists($key, $arr['cpu0']));
            $this->assertTrue(array_key_exists($key, $arr['cpu1']));
        }

        // Verify Memory measurement types. Check top man file for info on what these are
        foreach(["total", "free", "used", ] as $key) {
            $this->assertTrue(array_key_exists($key, $arr['mem']));
            $this->assertTrue(array_key_exists($key, $arr['swap']));
        }

        $this->assertTrue(array_key_exists("buff", $arr['mem']));
        $this->assertTrue(array_key_exists("avail", $arr['swap']));
    }

    public function getItem()
    {
        return new FakeTopCommand();
    }
}
