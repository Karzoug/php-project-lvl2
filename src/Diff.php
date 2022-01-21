<?php

namespace Gendiff\Diff;

function getDiff($dict1, $dict2)
{
    $mergedJsonDict = array_merge($dict1, $dict2);
    ksort($mergedJsonDict);

    $result = [];

    foreach ($mergedJsonDict as $key => $value) {
        if (!array_key_exists($key, $dict1)) {
            $result[] = "  + {$key}: " . toString($value);
            continue;
        }
        if (!array_key_exists($key, $dict2)) {
            $result[] = "  - {$key}: " . toString($value);
            continue;
        }

        if ($dict1[$key] === $dict2[$key]) {
            $result[] = "    {$key}: " . toString($value);
        } else {
            $result[] = "  - {$key}: " . toString($dict1[$key]);
            $result[] = "  + {$key}: " . toString($dict2[$key]);
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
