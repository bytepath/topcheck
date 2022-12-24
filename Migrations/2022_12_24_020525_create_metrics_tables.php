<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Domain\TopCheck\Database\CreateAverageLoadsTable;
use Domain\TopCheck\Database\CreateCpuCoresTable;
use Domain\TopCheck\Database\CreateMemoryTable;

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
