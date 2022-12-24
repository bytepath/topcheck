<?php

namespace Potatoquality\TopCheck\Hardware;

/**
 * Represents a CPU core
 *
 * @todo
 * This class originally converted the top units to something more readable by accepting the array from the top
 * command in the constructor. Originally I was gong to save them in the DB like this as well but after making the
 * toArray function that seems like a bad idea as the top abbreviations are very difficult to understand. Instead
 * I make nice names for the data from the top func and now this class should be modified to accept the nice
 * names as well somehow. Easiest would be to accept the data in the constructor directly as discrete args
 * but ill have to think about it
 */
class CPUCore
{
    /**
     * The name of this CPU core
     * @var string
     */
    protected $name = null;

    /**
     * The CPU data from top function
     */
    protected $data = null;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $this->processRawData($data);
    }

    /**
     * Returns the name of the CPU core
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the total load on the CPU
     * @return float
     */
    public function getTotalUsage()
    {
        return 100.0 - $this->getIdleUsage();
    }

    /**
     * Returns the amount of time the CPU spent processing things in user space
     * @return int|mixed
     */
    public function getUserUsage()
    {
        return $this->data["us"];
    }

    /**
     * Returns the amount of time the CPU spent processing things in kernel space
     * @return int|mixed
     */
    public function getKernelUsage()
    {
        return $this->data["sy"];
    }

    /**
     * Returns percent of core that is currently being used for low priority applications
     * @return int|mixed
     */
    public function getNiceUsage()
    {
        return $this->data["ni"];
    }

    /**
     * Returns percent of the core that is currently idle
     */
    public function getIdleUsage()
    {
        // id - idle cpu time (or) % CPU time spent idle
        return $this->data["id"];
    }

    /**
     * Returns % of core currently waiting on I/O such as disk
     */
    public function getWaitUsage()
    {
        // wa - io wait cpu time (or) % CPU time spent in wait (on disk)
        return $this->data["wa"];
    }

    /**
     * Returns percent of the core currently spent on hardware interrupts
     */
    public function getHardwareInterruptUsage()
    {
        // hi - hardware irq (or) % CPU time spent servicing/handling hardware interrupts
        return $this->data["hi"];
    }

    /**
     * Returns percent of the core currently spent on software interrupts
     */
    public function getSoftwareInterruptUsage()
    {
        return $this->data["si"];
    }

    /**
     * Returns percent of the core spent waiting on hypervisor
     */
    public function getStealTimeUsage()
    {
        // si - software irq (or) % CPU time spent servicing/handling software interrupts
        return $this->data["st"];
    }

    public function toArray()
    {
        $idle = $this->getIdleUsage();

        return [
            "name" => $this->getName(),
            "total" => $this->getTotalUsage(),
            "user" => $this->getUserUsage(),
            "kernel" => $this->getKernelUsage(),
            "nice" => $this->getNiceUsage(),
            "idle" => $idle,
            "io_wait" => $this->getWaitUsage(),
            "hardware_interrupt" => $this->getHardwareInterruptUsage(),
            "software_interrupt" => $this->getSoftwareInterruptUsage(),
            "steal" => $this->getStealTimeUsage(),
        ];
    }

    /**
     * Process the raw data from the top command into something more understandable/usable
     * @param $data
     * @return void
     */
    protected function processRawData($data)
    {
        $retval = [];

        // us - user cpu time (or) % CPU time spent in user space
        $retval["us"] = $this->convertToFloat($data, "us");

        // sy - system cpu time (or) % CPU time spent in kernel space
        $retval["sy"] = $this->convertToFloat($data, "sy");

        // ni - user nice cpu time (or) % CPU time spent on low priority processes
        $retval["ni"] = $this->convertToFloat($data, "ni");

        // id - idle cpu time (or) % CPU time spent idle
        $retval["id"] = $this->convertToFloat($data, "id");

        // wa - io wait cpu time (or) % CPU time spent in wait (on disk)
        $retval["wa"] = $this->convertToFloat($data, "wa");

        // hi - hardware irq (or) % CPU time spent servicing/handling hardware interrupts
        $retval["hi"] = $this->convertToFloat($data, "hi");

        // si - software irq (or) % CPU time spent servicing/handling software interrupts
        $retval["si"] = $this->convertToFloat($data, "si");

        // st - steal time % CPU time in involuntary wait by virtual cpu while hypervisor
        //      is servicing another processor (or) % CPU time stolen from a virtual machine
        $retval["st"] = $this->convertToFloat($data, "st");

        return $retval;
    }

    /**
     * Converts value into a float if it exists and sets to 0 if it doesn't
     * @param string $dataKey the name of a key that might exist in the array
     * @param array $data the array of data
     */
    protected function convertToFloat($data, $key): float
    {
        if(array_key_exists($key, $data)) {
            return floatval($data[$key]);
        }

        return 0.0;
    }
}
