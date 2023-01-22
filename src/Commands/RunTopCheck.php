<?php

namespace Potatoquality\TopCheck\Commands;

use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\Factories\CommandFactory;
use Potatoquality\TopCheck\Interfaces\TopCommandInterface;
use Potatoquality\TopCheck\Repositories\SystemPerformanceInfoRepository;
use Potatoquality\TopCheck\ShellCommands\FakeTopCommand;
use Potatoquality\TopCheck\ShellCommands\LinuxTopCommand;
use Potatoquality\TopCheck\TopCheck;
use Illuminate\Console\Command;

class RunTopCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topcheck:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays current performance info for your system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repo = $this->getRepo();
        $command = $this->getCommand();
        $this->displayData((new TopCheck($repo, $command))->run());

        return 1;
    }

    /**
     * Returns the repository used to save data
     * @return null
     */
    protected function getRepo()
    {
        return null;
    }

    /**
     * Fetches the Top command for your current operating system
     * @param string $currentOS the result of php_uname('s')
     * @return TopCommandInterface
     */
    public function getCommand(): TopCommandInterface
    {
        return CommandFactory::forOperatingSystem(php_uname('s'));
    }

    protected function displayData(SystemPerformanceInfo $data)
    {
        // Display the average load
        $load = $data->getAverageLoad();
        $this->line("Average Load");
        $this->table(["Period", "Avg Load"], [
            ["short", $load->getShortAvg()],
            ["med", $load->getMedAvg()],
            ["long", $load->getLongAvg()]
        ]);

        // Display CPU info
        $table = [];
        foreach($data->getCPUCores() as $core) {
            array_push($table, [$core->getName(), $core->getTotalUsage()]);
        }
        $this->line("CPU Cores");
        $this->table(["Core", "Load %"], $table);

        // Display Physical Memory
        $table = [];
        $memory = $data->getPhysicalMemory();
        foreach($memory->toArray() as $key => $val) {
            array_push($table, [$key, $val]);
        }
        $this->line("Physical Memory");
        $this->table(["", $memory->getUnit()], $table);

        // Display Virtual Memory
        $table = [];
        $memory = $data->getVirtualMemory();
        foreach($memory->toArray() as $key => $val) {
            array_push($table, [$key, $val]);
        }
        $this->line("Virtual Memory");
        $this->table(["", $memory->getUnit()], $table);
    }
}
