<?php

namespace Potatoquality\TopCheck\Commands;

use Potatoquality\TopCheck\Factories\PersistPerformanceInfoFactory;
use Potatoquality\TopCheck\Repositories\CloudSysPerfInfoRepository;
use Potatoquality\TopCheck\Repositories\SystemPerformanceInfoRepository;

class SaveTopCheck extends RunTopCheck
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topcheck:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches current performance info for your system and saves to database';

    /**
     * The repository used to save data to the database
     * @return SystemPerformanceInfoRepository
     */
    public function getRepo()
    {
        $config = config("topcheck");
        $client = $config["topcheck_client"];
        $secret = $config["topcheck_secret"];
        $driver = $config["topcheck_driver"];
        $url = $config["topcheck_url"];

        return PersistPerformanceInfoFactory::forDriver($driver, $client, $secret, $url);
    }
}
