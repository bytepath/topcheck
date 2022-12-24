<?php

namespace Domain\TopCheck\Database;

use Domain\TopCheck\AbstractClasses\CreateDatabaseTable;
use Illuminate\Database\Schema\Blueprint;

class CreateMemoryTable extends CreateDatabaseTable
{
    public $table = "memory_metrics";

    protected function create(Blueprint $table)
    {
        $table->id();
        $table->timestamps();
        $table->softDeletes();

        // The unit of the data (kb, mb, gb, etc)
        $table->string("unit")->nullable();

        // The type of data (physical, virtual, etc)
        $table->string("type")->nullable();

        // Total memory installed in the system
        $table->float("total")->nullable();

        // Free memory in the system
        $table->float("free")->nullable();

        // Used memory in the system
        $table->float("used")->nullable();

        // Buffered memory in the system
        $table->float("buff")->nullable();

        // Cached memory in the system
        $table->float("cache")->nullable();
    }
}
