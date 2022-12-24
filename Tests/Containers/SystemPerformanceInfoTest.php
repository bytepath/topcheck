<?php

namespace Domain\TopCheck\Tests\Containers;

use Domain\TopCheck\Containers\SystemPerformanceInfo;
use Domain\TopCheck\Exceptions\EmptyRepositoryException;
use Domain\TopCheck\Hardware\AverageLoad;
use Domain\TopCheck\Hardware\CPUCore;
use Domain\TopCheck\Hardware\Memory;
use Domain\TopCheck\Hardware\PhysicalMemory;
use Domain\TopCheck\Repositories\SystemPerformanceInfoRepository;
use Domain\TopCheck\Tests\FakeTopResult;
use Tests\TestCase;
use Mockery;

class SystemPerformanceInfoTest extends TestCase
{
    public function test_can_make_from_output_of_top_function()
    {
        $data = FakeTopResult::get();
        $item = new SystemPerformanceInfo($data);

        $this->assertIsClass(SystemPerformanceInfo::class, $item);

        $cores = $item->getCPUCores();
        $this->assertEquals(2, sizeof($cores));
        foreach ($cores as $core) {
            $this->assertIsClass(CPUCore::class, $core);
        }

        $load = $item->getAverageLoad();
        $this->assertIsClass(AverageLoad::class, $load);

        $physical = $item->getPhysicalMemory();
        $this->assertIsClass(Memory::class, $physical);
        $this->assertEquals("physical", $physical->getType());


        $virtual = $item->getVirtualMemory();
        $this->assertIsClass(Memory::class, $virtual);
        $this->assertEquals("virtual", $virtual->getType());
    }

    public function test_can_convert_to_array()
    {
        $data = FakeTopResult::get();
        $arr = (new SystemPerformanceInfo($data))->toArray();

        foreach(["load", "cores", "memory"] as $key) {
            $this->assertTrue(array_key_exists($key, $arr));
        }

        foreach(["physical", "virtual"] as $key) {
            $this->assertTrue(array_key_exists($key, $arr["memory"]));
        }
    }

    public function test_getRawData_returns_the_data_passed_into_function()
    {
        $data = FakeTopResult::get();
        $item = (new SystemPerformanceInfo($data))->getRawData();

        foreach(["top", "cpu0", "cpu2", "mem", "swap"] as $key) {
            $this->assertArrayHasKey($key, $item);
        }
    }
}
