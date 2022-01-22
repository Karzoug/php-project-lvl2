<?php

namespace Differ\Formatters\Plain;

const ADDED = 'added';
const REMOVED = 'removed';
const UNCHANGED = 'unchanged';
const UPDATED = 'updated';
const NESTED = 'nested';

function format($dict)
{
    return implode("\n", step($dict, ""));
}

function step($dict, $path)
{
    return array_reduce($dict, function ($acc, $node) use ($path) {
        if ($node["status"] === REMOVED) {
            $acc[] = "Property '" . $path . $node['key'] . "' was removed";
        }
        if ($node["status"] === ADDED) {
            $acc[] = "Property '" . $path . $node['key'] . "' was added with value: " . toString($node["after"]);
        }
        if ($node["status"] === UPDATED) {
            $acc[] = "Property '" . $path . $node['key'] . "' was updated. From " .
                toString($node["before"]) . " to " . toString($node["after"]);
        }

        if ($node["status"] === NESTED) {
            $accInside = step($node["children"], ($path . $node['key'] . "."));
            $acc = [...$acc, ...$accInside];
        }

        return $acc;
    }, []);
}

function toString($value)
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
