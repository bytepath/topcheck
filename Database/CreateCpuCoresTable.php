<?php

namespace Domain\TopCheck\Database;

use Domain\TopCheck\AbstractClasses\CreateDatabaseTable;
use Illuminate\Database\Schema\Blueprint;

class CreateCpuCoresTable extends CreateDatabaseTable
{
    public $table = "cpu_core_metrics";

    protected function create(Blueprint $table)
    {
        $table->id();
        $table->timestamps();
        $table->softDeletes();

        // The name of the core as pulled from the system
        $table->string("name")->nullable();

        // Current load on this core
        $table->float("total")->nullable();

        // Time spent processing user space
        $table->float("user")->nullable();

        // Time spent processing kernel space
        $table->float("kernel")->nullable();

        // Time spent processing low priority stuff
        $table->float("nice")->nullable();

        // Time spent sitting idle as a percent
        $table->float("idle")->nullable();

        // Time spent waiting for IO
        $table->float("io_wait")->nullable();

        // Time spent processing hardware interrupts
        $table->float("hardware_interrupt")->nullable();

        // Time spent processing software interrupts
        $table->float("software_interrupt")->nullable();

        // Time spent waiting for hypervisors
        $table->float("steal")->nullable();
    }
}
