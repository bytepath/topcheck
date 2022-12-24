<?php

namespace Domain\TopCheck\Commands;

use Domain\TopCheck\Repositories\SystemPerformanceInfoRepository;
use Domain\TopCheck\TopCheck;
use Illuminate\Console\Command;

class RunTopCheck extends Command
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
    protected $description = 'Fetches current performance info for your system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = (new TopCheck(new SystemPerformanceInfoRepository))->run();
        $this->info(print_r($data));
    }
}
