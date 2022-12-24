<?php

namespace Potatoquality\TopCheck\Hardware;

use Potatoquality\TopCheck\Exceptions\AverageLoadException;

/**
 * Represents the "Average Load" of the system
 */
class AverageLoad
{
    protected $data = [
        "short" => null,
        "med" => null,
        "long" => null,
    ];

    public function __construct(array $data)
    {
        if(empty($data)) {
            throw AverageLoadException::forEmptyArray();
        }

        if (array_key_exists(0, $data)) {
            if ($data[0] !== "") {
                $this->data["short"] = floatval($data[0]);
            }
        }

        if (array_key_exists(1, $data)) {
            if ($data[1] !== "") {
                $this->data["med"] = floatval($data[1]);
            }
        }

        if (array_key_exists(2, $data)) {
            if ($data[2] !== "") {
                $this->data["long"] = floatval($data[2]);
            }
        }
    }

    /**
     * Returns the average load of the short period. Typically the last minute
     * @return float|null
     */
    public function getShortAvg()
    {
        return $this->data["short"];
    }

    /**
     * Returns the average load of the medium period. Typically the last 5 minutes
     * @return float|null
     */
    public function getMedAvg()
    {
        return $this->data["med"];
    }

    /**
     * Returns the average load of the long period. Typically the last 15 minutes
     * @return float|null
     */
    public function getLongAvg()
    {
        return $this->data["long"];
    }

    /**
     * Returns the data as an array
     * @return null[]
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
