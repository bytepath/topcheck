<?php

namespace Potatoquality\TopCheck\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CPUCoreRepository
{
    public function getAllDataFromLastHours($hours = 24)
    {
        $retval = [];
        $data = DB::table("cpu_core_metrics")
            ->select("name", "total")
            ->where("created_at", ">=", Carbon::now()->subHours($hours))
            ->get()
            ->each(function ($row) use (&$retval) {
                if (!array_key_exists($row->name, $retval)) {
                    $retval[$row->name] = [];
                }

                array_push($retval[$row->name], $row);
            });

        return $retval;
    }
}
