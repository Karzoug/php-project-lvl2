<?php

namespace Differ\Diff;

const ADDED = 'added';
const REMOVED = 'removed';
const UPDATED = 'updated';
const UNCHANGED = 'unchanged';
const NESTED = 'nested';

function getDiff(array $dict1, array $dict2)
{
    $dictKeys = array_unique(array_merge(array_keys($dict1), array_keys($dict2)));
    $sortedDictKeys = collect($dictKeys)->sort()->all();

    $result = array_reduce($sortedDictKeys, function ($acc, $key) use ($dict1, $dict2) {
        if (!array_key_exists($key, $dict1)) {
            $acc->push([
                "key" => $key,
                "before" => null,
                "after" => $dict2[$key],
                "children" => null,
                "status" => ADDED
            ]);
            return $acc;
        }
        if (!array_key_exists($key, $dict2)) {
            $acc->push([
                "key" => $key,
                "before" => $dict1[$key],
                "after" => null,
                "children" => null,
                "status" => REMOVED
            ]);
            return $acc;
        }

        if (is_array($dict1[$key]) ^ is_array($dict2[$key])) {
            $acc->push([
                "key" => $key,
                "before" => $dict1[$key],
                "after" => $dict2[$key],
                "children" => null,
                "status" => UPDATED
            ]);
            return $acc;
        }

        if (is_array($dict1[$key]) && is_array($dict2[$key])) {
            $acc->push([
                "key" => $key,
                "before" => $dict1[$key],
                "after" => $dict2[$key],
                "children" => getDiff($dict1[$key], $dict2[$key]),
                "status" => NESTED
            ]);
            return $acc;
        }

        if ($dict1[$key] === $dict2[$key]) {
            $acc->push([
                "key" => $key,
                "before" => $dict1[$key],
                "after" => $dict2[$key],
                "children" => null,
                "status" => UNCHANGED
            ]);
        } else {
            $acc->push([
                "key" => $key,
                "before" => $dict1[$key],
                "after" => $dict2[$key],
                "children" => null,
                "status" => UPDATED
            ]);
        }
        return $acc;
    }, collect([]));

    return $result->all();
}
