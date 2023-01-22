<?php

namespace Potatoquality\TopCheck\ShellCommands;

use Potatoquality\TopCheck\Containers\SystemPerformanceInfo;
use Potatoquality\TopCheck\Interfaces\TopCommandInterface;

/**
 * A script that uses the linux top command to pull the current performance info for this server.
 * The result of the top cmd is ran through a series of pipes to extract the CPU and Ram data
 */
class LinuxTopCommand implements TopCommandInterface
{
    public function run(): SystemPerformanceInfo
    {
        return new SystemPerformanceInfo($this->raw());
    }

    /**
     * Returns raw performance data as an array
     * @return array
     */
    public function raw(): array
    {
        $retval = [];

        $topCMD = 'top -bn1 -1 | head -n 6 | sed \'s/used\./used,/g\' | sed \'s/-/:/g\' | sed \'s/%//g\'  | awk -F\'[/:?,?/]\' \'{ if ($1 ~ /Cpu[0-9]/ ) print $1 "@" $2 "@" $3 "@" $4 "@" $5 "@" $6 "@" $7 "@" $8 "@" $9 "###" } { if ($1 ~ /MiB.*/ ) print $1 "@" $2 "@" $3 "@" $4 "@" $5 "###" } { if ($1 ~ /top.*/ ) print $1 "@" $9 "@" $10 "@" $11 "###" } \'';
        $shellResult = str_replace(PHP_EOL, "", shell_exec($topCMD));
        $output = explode("###", $shellResult);

        foreach($output as $str) {
            $line = [];
            // Each line item is separated by an ampersand
            $items = explode("@", $str);

            // The first item is the name of the metric. example Cpu0, Cpu1, MiB Mem, MiB Swap.
            // We want to remove the MiB part if it exists
            $name = trim(strtolower($items[0]));
            $name = str_replace("mib ", "", $name);

            // The rest of the items are the values for that particular metric followed by the name of the value.
            // This snippet makes an array where the name of the value is the array key
            // Example 4555 free becomes [ "free" => 4555 ]
            for($i = 1; $i < sizeof($items); $i++) {
                $val = trim($items[$i]);

                $expVal = explode(" ", $val);

                $key = null;
                if(array_key_exists(1, $expVal)) {
                    $key = $expVal[1];
                }

                $val = $expVal[0];

                if($key && $key !== "") {
                    $line[$key] = $val;
                }
                else {
                    array_push($line, trim($items[$i]));
                }
            }

            if($name && $name !== "") {
                $retval[$name] = $line;
            }
        }

        return $retval;
    }
}
