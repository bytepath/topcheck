<?php

namespace Potatoquality\TopCheck\Repositories;

use Carbon\Carbon;
use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Illuminate\Support\Facades\DB;

class LocalSystemPerformanceInfoRepository
{
    public function save(SystemPerformanceInfo $info): bool
    {
        $timestamps = function($arr) {
            $retval = [
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];

            foreach ($arr as $key => $val) {
                $retval[$key] = $val;
            }

            return $retval;
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
