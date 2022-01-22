<?php

namespace Gendiff\Diff;

const ADDED = 'added';
const REMOVED = 'removed';
const UNCHANGED = 'unchanged';
const NESTED = 'nested';

function getDiff($dict1, $dict2)
{
    $dictKeys = array_unique(array_merge(array_keys($dict1), array_keys($dict2)));
    sort($dictKeys);

    $result = [];

    foreach ($dictKeys as $key) {
        if (!array_key_exists($key, $dict1)) {
            $result[] = ["key" => $key, "node" => $dict2[$key], "status" => ADDED];
            continue;
        }
        if (!array_key_exists($key, $dict2)) {
            $result[] = ["key" => $key, "node" => $dict1[$key], "status" => REMOVED];
            continue;
        }

        if (is_array($dict1[$key]) ^ is_array($dict2[$key])) {
            $result[] = ["key" => $key, "node" => $dict1[$key], "status" => REMOVED];
            $result[] = ["key" => $key, "node" => $dict2[$key], "status" => ADDED];
            continue;
        }

        if (is_array($dict1[$key]) && is_array($dict2[$key])) {
            $result[] = ["key" => $key, "node" => getDiff($dict1[$key], $dict2[$key]), "status" => NESTED];
            continue;
        }

        if ($dict1[$key] === $dict2[$key]) {
            $result[] = ["key" => $key, "node" => $dict1[$key], "status" => UNCHANGED];
        } else {
            $result[] = ["key" => $key, "node" => $dict1[$key], "status" => REMOVED];
            $result[] = ["key" => $key, "node" => $dict2[$key], "status" => ADDED];
        }
    }

    return $result;
}
