<?php

namespace Potatoquality\TopCheck\Commands;

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
        return new SystemPerformanceInfoRepository();
    }
}
