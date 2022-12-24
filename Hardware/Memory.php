<?php

namespace Potatoquality\TopCheck\Hardware;

/**
 * Represents the memory of the system
 */
class Memory
{
    /**
     * The type of memory (physical, virtual, etc)
     * @var string
     */
    protected $type = null;

    /**
     * The raw data from where TopCommandInterface
     * @var null
     */
    protected $data = null;

    /**
     * The unit of this data
     */
    protected $unit = null;

    public function __construct(array $data, string $type = "physical", $unit = null)
    {
        $retval = [];
        foreach (["total", "free", "used", "buff", "cache"] as $key) {
            $retval[$key] = null;
            if (array_key_exists($key, $data)) {
                if ($data[$key] !== "") {
                    $retval[$key] = floatval($data[$key]);
                }
            }
        }

        $this->data = $retval;
        $this->type = $type;
        $this->unit = $unit ?? "N/A";
    }

    /**
     * Returns the units of this data (kb, mb, gb, etc)
     * Currently returns "N/A" as I haven't figured out how to do this yet
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Returns the type of memory (physical, virtual, etc)
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the total installed memory in this system
     */
    public function getTotalMemory()
    {
        return $this->data["total"];
    }

    /**
     * Returns the amount available memory
     */
    public function getFreeMemory()
    {
        return $this->data["free"];
    }

    /**
     * Returns the amount consumed memory
     */
    public function getUsedMemory()
    {
        return $this->data["used"];
    }

    /**
     * Returns the amount buffered memory to be written
     */
    public function getBuffedMemory()
    {
        return $this->data["buff"];
    }

    /**
     * Returns the amount of cached memory
     */
    public function getCacheMemory()
    {
        return $this->data["cache"];
    }

    /**
     * Returns this object as an array
     * @return array
     */
    public function toArray(): array
    {
        return [
            "unit" => $this->getUnit(),
            "type" => $this->getType(),
            ...$this->data,
        ];
    }
}
