<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Potatoquality\TopCheck\Database\CreateAverageLoadsTable;
use Potatoquality\TopCheck\Database\CreateCpuCoresTable;
use Potatoquality\TopCheck\Database\CreateMemoryTable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = Schema::getFacadeRoot();
        (new CreateAverageLoadsTable($schema))->up();
        (new CreateMemoryTable($schema))->up();
        (new CreateCpuCoresTable($schema))->up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema = Schema::getFacadeRoot();
        (new CreateCpuCoresTable($schema))->down();
        (new CreateMemoryTable($schema))->down();
        (new CreateAverageLoadsTable($schema))->down();
    }
};
