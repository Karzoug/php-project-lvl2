<?php

namespace Gendiff\Diff;

function getDiff($data1, $data2)
{
    $jsonDict1 = json_decode($data1, true);
    $jsonDict2 = json_decode($data2, true);

    $mergedJsonDict = array_merge($jsonDict1, $jsonDict2);
    ksort($mergedJsonDict);

    $result = [];

    foreach ($mergedJsonDict as $key => $value) {
        if (!array_key_exists($key, $jsonDict1)) {
            $result[] = "+ {$key}: " . toString($value);
            continue;
        }
        if (!array_key_exists($key, $jsonDict2)) {
            $result[] = "- {$key}: " . toString($value);
            continue;
        }

        if ($jsonDict1[$key] === $jsonDict2[$key]) {
            $result[] = "  {$key}: " . toString($value);
        } else {
            $result[] = "- {$key}: " . toString($jsonDict1[$key]);
            $result[] = "+ {$key}: " . toString($jsonDict2[$key]);
        }
    }

    return "{\n" . implode("\n", $result) . "\n}";
}

function toString($value)
{
    if (is_bool($value)) {
        return ($value) ? "true" : "false";
    }

    return (string)$value;
}
