<?php

namespace Differ\Formatters\Plain;

use const Differ\Diff\ADDED;
use const Differ\Diff\NESTED;
use const Differ\Diff\UNCHANGED;
use const Differ\Diff\REMOVED;
use const Differ\Diff\UPDATED;

function format(array $dict)
{
    return implode("\n", step($dict, ""));
}

function step(array $dict, string $path)
{
    return array_reduce($dict, function ($acc, $node) use ($path) {
        if ($node["status"] === REMOVED) {
            array_push($acc, "Property '" . $path . $node['key'] . "' was removed");
        }
        if ($node["status"] === ADDED) {
            array_push($acc, "Property '" . $path . $node['key'] . "' was added with value: " . toString($node["after"]));
        }
        if ($node["status"] === UPDATED) {
            array_push($acc, "Property '" . $path . $node['key'] . "' was updated. From " .
                toString($node["before"]) . " to " . toString($node["after"]));
        }

        if ($node["status"] === NESTED) {
            $accInside = step($node["children"], ($path . $node['key'] . "."));
            $acc = [...$acc, ...$accInside];
        }

        return $acc;
    }, []);
}

function toString(mixed $value)
{
    if (is_array($value)) {
        return "[complex value]";
    }

    if (is_bool($value)) {
        return ($value) ? "true" : "false";
    }

    if (is_null($value)) {
        return "null";
    }

    if (is_string($value)) {
        return "'{$value}'";
    }

    return (string)$value;
}
