<?php

namespace Domain\TopCheck\Tests\Hardware;

use Domain\TopCheck\Hardware\CPUCore;
use Domain\TopCheck\Hardware\Memory;
use Domain\TopCheck\Hardware\PhysicalMemory;
use Tests\TestCase;

class MemoryTest extends TestCase
{
    public function test_can_create_from_output_of_top_function()
    {
        $data = [
        "total" => "5944.6",
        "free" => "4776.1",
        "used" => "320.0",
        "buff" => "848.5",
        "cache" => "0"
    ];

        $memory = new Memory($data);
        $this->assertIsClass(Memory::class, $memory);
        // Need to force units somehow
        $this->assertEquals("N/A", $memory->getUnit());
        $this->assertEquals(5944.6, $memory->getTotalMemory());
        $this->assertEquals(4776.1, $memory->getFreeMemory());
        $this->assertEquals(320.0, $memory->getUsedMemory());
        $this->assertEquals(848.5, $memory->getBuffedMemory());
        $this->assertEquals(0, $memory->getCacheMemory());

    }

    public function test_can_convert_to_array()
    {
        $data = [
            "total" => "5944.6",
            "free" => "4776.1",
            "used" => "320.0",
            "buff" => "848.5",
            "cache" => "69.420"
        ];

        $arr = (new Memory($data, "the-type", "the-unit"))->toArray();

        // Need to force units somehow
        $this->assertEquals("the-unit", $arr["unit"]);
        $this->assertEquals("the-type", $arr["type"]);
        $this->assertEquals(5944.6, $arr["total"]);
        $this->assertEquals(4776.1, $arr["free"]);
        $this->assertEquals(320, $arr["used"]);
        $this->assertEquals(848.5, $arr["buff"]);
        $this->assertEquals(69.420, $arr["cache"]);
    }


    public function test_can_set_unit_type_in_constructor()
    {
        $this->assertEquals("cats", (new Memory([], "physical", "cats"))->getUnit());
    }

    public function test_ignores_other_values_in_data_arg()
    {
        $data = [
            "total" => "5944.6",
            "free" => "4776.1",
            "used" => "320.0",
            "buff" => "848.5",
            "cache" => "0"
        ];

        unset($data["total"]);
        $memory = new Memory($data);
        $this->assertNull($memory->getTotalMemory());

        unset($data["free"]);
        $memory = new Memory($data);
        $this->assertNull($memory->getFreeMemory());

        unset($data["used"]);
        $memory = new Memory($data);
        $this->assertNull($memory->getUsedMemory());

       unset($data["buff"]);
        $memory = new Memory($data);
        $this->assertNull($memory->getBuffedMemory());

        unset($data["cache"]);
        $memory = new Memory($data);
        $this->assertNull($memory->getCacheMemory());
    }


}
