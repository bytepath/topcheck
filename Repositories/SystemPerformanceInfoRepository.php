<?php

namespace Potatoquality\TopCheck\Repositories;

use Carbon\Carbon;
use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Illuminate\Support\Facades\DB;

class SystemPerformanceInfoRepository
{
    public function save(SystemPerformanceInfo $info): bool
    {
        $timestamps = function($arr) {
            return [
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                ...$arr,
            ];
        };

        $arr = $info->toArray();

        DB::table("avg_load_metrics")->insert($timestamps($arr["load"]));

        foreach($arr["cores"] as $core) {
            DB::table("cpu_core_metrics")->insert($timestamps($core));
        }

        foreach($arr["memory"] as $memory) {
            DB::table("memory_metrics")->insert($timestamps($memory));
        }

        return true;
    }
}
