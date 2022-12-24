<?php

namespace Domain\TopCheck\Containers;

use Domain\TopCheck\Hardware\AverageLoad;
use Domain\TopCheck\Hardware\CPUCore;
use Domain\TopCheck\Hardware\Memory;
/**
 * An object that contains the current performance information for this system including per core CPU and memory data
 *
 * @todo
 * make it so this class doesn't accept raw data so it can be used for database stuff OR raw processor stuff. maybe
 * it should accept each data type as a discrete constructor and the data types get made elsewhere
 */
class SystemPerformanceInfo
{
    /**
     * The raw data from the TOP command
     * @var null|array
     */
    protected $rawData = null;

    /**
     * A list of the cores in this system
     * @var array<CPUCore>
     */
    protected $cores = [];

    /**
     * The average load of the past few minutes
     * @var AverageLoad
     */
    protected $averageLoad = null;

    /**
     * The object representing memory in this system
     * @var Memory
     */
    protected $physicalMemory = null;

    /**
     * The object representing virtual memory in this system
     * @var Memory
     */
    protected $virtualMemory = null;

    /**
     * @param array $rawData an array of data that came from the TopCommand class
     */
    public function __construct(array $rawData)
    {
        $this->rawData = $rawData;
        $this->processRawData($rawData);
    }

    /**
     * Returns the raw data passed into this function
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Returns the list of CPU cores
     * @return CPUCore[]
     */
    public function getCPUCores(): array
    {
        return $this->cores;
    }

    /**
     * Returns the AverageLoad object in this class
     * @return AverageLoad
     */
    public function getAverageLoad(): AverageLoad
    {
        return $this->averageLoad;
    }

    /**
     * Returns an object representing the physical memory of this system
     * @return PhysicalMemory
     */
    public function getPhysicalMemory(): Memory
    {
        return $this->physicalMemory;
    }

    /**
     * Returns an object representing the virtual memory of this system
     * @return Memory
     */
    public function getVirtualMemory(): Memory
    {
        return $this->virtualMemory;
    }

    public function toArray()
    {
        $cores = [];
        foreach($this->getCPUCores() as $core) {
            array_push($cores, $core->toArray());
        }

        return [
            "load" => $this->getAverageLoad()->toArray(),
            "cores" => $cores,
            "memory" => [
                "physical" => $this->getPhysicalMemory()->toArray(),
                "virtual" => $this->getVirtualMemory()->toArray(),
            ]
        ];
    }

    protected function processRawData($rawData)
    {
        foreach($rawData as $key => $val) {
            if(str_contains($key, "cpu")) {
                $this->addCPUCore($key, $val);
            }

            else if($key === "top") {
                $this->addAverageLoad($val);
            }

            else if($key === "mem") {
                $this->addPhysicalMemory($val);
            }

            else if($key === "swap") {
                $this->addVirtualMemory($val);
            }
        }
    }

    /**
     * Adds a CPU core to the internal list
     * @param $name the keyname of the array that comes from the top func
     * @param $cpuData the CPU data from the top function
     * @return void
     */
    protected function addCPUCore($name, $cpuData): void
    {
        // CPU name is part of the key that comes in from the shell command. example: cpu4
        $name = str_replace("cpu", "", $name);
        array_push($this->cores, new CPUCore($name, $cpuData));
    }

    /**
     * Adds average load data from top function
     * @param $load
     */
    protected function addAverageLoad($load): void
    {
        $this->averageLoad = new AverageLoad(($load));
    }

    /**
     * Adds physical memory info from top function
     */
    protected function addPhysicalMemory(array $memory): void
    {
        $this->physicalMemory = new Memory($memory, "physical");
    }

    /**
     * Adds physical memory info from top function
     */
    protected function addVirtualMemory(array $virtual): void
    {
        $this->virtualMemory = new Memory($virtual, "virtual");
    }
}
