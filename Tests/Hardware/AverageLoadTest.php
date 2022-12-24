<?php

namespace Potatoquality\TopCheck\Tests\Hardware;

use Potatoquality\TopCheck\Exceptions\AverageLoadException;
use Potatoquality\TopCheck\Hardware\AverageLoad;
use Potatoquality\TopCheck\Hardware\CPUCore;
use Tests\TestCase;

class AverageLoadTest extends TestCase
{
    public function test_can_create_from_output_of_top_function()
    {
        $data = [
            "11.3",
            "43.4",
            "1"
        ];

        $load = new AverageLoad($data);
        $this->assertIsClass(AverageLoad::class, $load);
        $this->assertEquals(11.3, $load->getShortAvg());
        $this->assertEquals(43.4, $load->getMedAvg());
        $this->assertEquals(1, $load->getLongAvg());
    }

    public function test_can_convert_object_to_array()
    {
        $data = [
            "11.3",
            "43.4",
            "1"
        ];

        $arr = (new AverageLoad($data))->toArray();
        foreach (["short", "med", "long"] as $d) {
            $this->assertArrayHasKey($d, $arr);
        }

        $this->assertEquals(11.3, $arr["short"]);
        $this->assertEquals(43.4, $arr["med"]);
        $this->assertEquals(1, $arr["long"]);
    }

    public function test_ignores_empty_strings()
    {
        $load = new AverageLoad(["11.3", "", "1"]);
        $this->assertEquals(11.3, $load->getShortAvg());
        $this->assertNull($load->getMedAvg());
        $this->assertEquals(1, $load->getLongAvg());

        $load = new AverageLoad(["", "43.4", "1"]);
        $this->assertNull($load->getShortAvg());
        $this->assertEquals(43.4, $load->getMedAvg());
        $this->assertEquals(1, $load->getLongAvg());

        $load = new AverageLoad(["11.3", "43.4", ""]);
        $this->assertEquals(11.3, $load->getShortAvg());
        $this->assertEquals(43.4, $load->getMedAvg());
        $this->assertNull($load->getLongAvg());
    }

    public function test_med_and_long_if_not_provided_values()
    {
        $load = new AverageLoad(["11.3", "43.4"]);
        $this->assertEquals(11.3, $load->getShortAvg());
        $this->assertEquals(43.4, $load->getMedAvg());
        $this->assertNull($load->getLongAvg());

        $load = new AverageLoad(["11.3"]);
        $this->assertEquals(11.3, $load->getShortAvg());
        $this->assertNull($load->getMedAvg());
        $this->assertNull($load->getLongAvg());
    }

    public function test_throws_exception_if_given_empty_array()
    {
        $this->expectException(AverageLoadException::class);
        $load = new AverageLoad([]);
    }
}
