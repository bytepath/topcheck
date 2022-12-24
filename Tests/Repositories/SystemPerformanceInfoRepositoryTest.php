<?php

namespace Domain\TopCheck\Tests\Repositories;

use Domain\TopCheck\Containers\SystemPerformanceInfo;
use Domain\TopCheck\Repositories\SystemPerformanceInfoRepository;
use Domain\TopCheck\Tests\FakeTopResult;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SystemPerformanceInfoRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_save_performance_info()
    {
        $data = FakeTopResult::alt();
        $info = new SystemPerformanceInfo($data);
        $item = (new SystemPerformanceInfoRepository())->save($info);

        $load = DB::table("avg_load_metrics")->first();
        $this->assertEquals(1.4, $load->short);
        $this->assertEquals(3.6, $load->med);
        $this->assertEquals(7.5, $load->long);
        $this->assertNotNull($load->created_at);
        $this->assertNotNull($load->updated_at);

        $cores = DB::table("cpu_core_metrics")->get();
        $this->assertEquals(2, $cores->count());

        $this->assertNotNull($cores[0]->created_at);
        $this->assertNotNull($cores[0]->updated_at);
        $this->assertNull($cores[0]->deleted_at);
        $this->assertEquals($cores[0]->name, "0");
        $this->assertEquals($cores[0]->total, "55");
        $this->assertEquals($cores[0]->user, "1");
        $this->assertEquals($cores[0]->kernel, "45.4");
        $this->assertEquals($cores[0]->nice, "3.5");
        $this->assertEquals($cores[0]->idle, "45");
        $this->assertEquals($cores[0]->io_wait, "6");
        $this->assertEquals($cores[0]->hardware_interrupt, "7");
        $this->assertEquals($cores[0]->software_interrupt, "9.4");
        $this->assertEquals($cores[0]->steal, "3");

        $this->assertNotNull($cores[1]->created_at);
        $this->assertNotNull($cores[1]->updated_at);
        $this->assertNull($cores[1]->deleted_at);
        $this->assertEquals($cores[1]->name, "2");
        $this->assertEquals($cores[1]->total, "35");
        $this->assertEquals($cores[1]->user, "3");
        $this->assertEquals($cores[1]->kernel, "0.5");
        $this->assertEquals($cores[1]->nice, "6");
        $this->assertEquals($cores[1]->idle, "65");
        $this->assertEquals($cores[1]->io_wait, "7");
        $this->assertEquals($cores[1]->hardware_interrupt, "0.8");
        $this->assertEquals($cores[1]->software_interrupt, "2.9");
        $this->assertEquals($cores[1]->steal, "1.3");

        $memories = DB::table("memory_metrics")->get();
        $this->assertEquals(2, $memories->count());

        $this->assertNotNull($memories[0]->created_at);
        $this->assertNotNull($memories[0]->updated_at);
        $this->assertNull($memories[0]->deleted_at);
        $this->assertEquals($memories[0]->unit, "N/A");
        $this->assertEquals($memories[0]->type, "physical");
        $this->assertEquals($memories[0]->total, "5944.6");
        $this->assertEquals($memories[0]->free, "4776.1");
        $this->assertEquals($memories[0]->used, "320");
        $this->assertEquals($memories[0]->buff, "848.5");
        $this->assertEquals($memories[0]->cache, "345.4");

        $this->assertNotNull($memories[1]->created_at);
        $this->assertNotNull($memories[1]->updated_at);
        $this->assertNull($memories[1]->deleted_at);
        $this->assertEquals($memories[1]->unit, "N/A");
        $this->assertEquals($memories[1]->type, "virtual");
        $this->assertEquals($memories[1]->total, "1536");
        $this->assertEquals($memories[1]->free, "1536");
        $this->assertEquals($memories[1]->used, "0");
        $this->assertEquals($memories[1]->buff, null);
        $this->assertEquals($memories[1]->cache, null);
    }
}
