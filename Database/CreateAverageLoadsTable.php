<?php

namespace Potatoquality\TopCheck\Database;

use Potatoquality\TopCheck\AbstractClasses\CreateDatabaseTable;
use Illuminate\Database\Schema\Blueprint;

class CreateAverageLoadsTable extends CreateDatabaseTable
{
    public $table = "avg_load_metrics";

    protected function create(Blueprint $table)
    {
        $table->id();
        $table->timestamps();
        $table->softDeletes();

        // Short load (typically around a minute)
        $table->float("short")->nullable();

        // med load (typically around 5 minutes)
        $table->float("med")->nullable();

        // long load (typically around 15 minutes)
        $table->float("long")->nullable();
    }
}
