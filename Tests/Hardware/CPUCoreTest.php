<?php

namespace Domain\TopCheck\Tests\Hardware;

use Domain\TopCheck\Hardware\CPUCore;
use Tests\TestCase;

class CPUCoreTest extends TestCase
{
    public function test_can_create_from_output_of_top_function()
    {
        $data = [
            "us" => "4.1",
            "sy" => "5.2",
            "ni" => "0.0",
            "id" => "60.0",
            "wa" => "110.44",
            "hi" => "1.200",
            "si" => "20.2",
            "st" => "7.8",
        ];

        $core = new CPUCore("cat", $data);
        $this->assertIsClass(CPUCore::class, $core);
        $this->assertEquals("cat", $core->getName());
        $this->assertEquals(4.1, $core->getUserUsage());
        $this->assertEquals(5.2, $core->getKernelUsage());
        $this->assertEquals(0, $core->getNiceUsage());
        $this->assertEquals(60.0, $core->getIdleUsage());
        $this->assertEquals(40, $core->getTotalUsage());
        $this->assertEquals(110.44, $core->getWaitUsage());
        $this->assertEquals(1.2, $core->getHardwareInterruptUsage());
        $this->assertEquals(20.2, $core->getSoftwareInterruptUsage());
        $this->assertEquals(7.8, $core->getStealTimeUsage());
    }

    public function test_can_convert_to_array()
    {
        $data = [
            "us" => "4.1",
            "sy" => "5.2",
            "ni" => "0.0",
            "id" => "45.4",
            "wa" => "110.44",
            "hi" => "1.200",
            "si" => "20.2",
            "st" => "7.8",
        ];

        $arr = (new CPUCore("cat", $data))->toArray();
        $this->assertEquals("cat", $arr["name"]);
        $this->assertEquals(54.6, $arr["total"]);
        $this->assertEquals(4.1, $arr["user"]);
        $this->assertEquals(5.2, $arr["kernel"]);
        $this->assertEquals(0, $arr["nice"]);
        $this->assertEquals(45.4, $arr["idle"]);
        $this->assertEquals(110.44, $arr["io_wait"]);
        $this->assertEquals(1.2, $arr["hardware_interrupt"]);
        $this->assertEquals(20.2, $arr["software_interrupt"]);
        $this->assertEquals(7.8, $arr["steal"]);
    }

    public function test_ignores_other_values_in_data_arg()
    {
        $data = [
            "us" => "4.1",
            "sy" => "5.2",
            "ni" => "0.0",
            "id" => "100.0",
            "wa" => "110.44",
            "hi" => "1.200",
            "si" => "20.2",
            "st" => "7.8",
            "cat" => "potato",
            5 => "snackcakes",
        ];

        $core = new CPUCore("dog", $data);
        $this->assertIsClass(CPUCore::class, $core);
        $this->assertEquals("dog", $core->getName());
        $this->assertEquals(4.1, $core->getUserUsage());
        $this->assertEquals(5.2, $core->getKernelUsage());
        $this->assertEquals(0, $core->getNiceUsage());
        $this->assertEquals(110.44, $core->getWaitUsage());
        $this->assertEquals(1.2, $core->getHardwareInterruptUsage());
        $this->assertEquals(20.2, $core->getSoftwareInterruptUsage());
        $this->assertEquals(7.8, $core->getStealTimeUsage());
    }
}
