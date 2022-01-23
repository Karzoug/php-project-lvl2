<?php

namespace Differ\Formatters\Stylish;

const ADDED = 'added';
const REMOVED = 'removed';
const UNCHANGED = 'unchanged';
const UPDATED = 'updated';
const NESTED = 'nested';

function format(array $dict)
{
    return "{\n" . implode("\n", step($dict, 0)) . "\n}";
}

function step(array $dict, int $level)
{
    return array_reduce($dict, function ($acc, $node) use ($level) {
        if ($node["status"] === UPDATED || $node["status"] === REMOVED || $node["status"] === UNCHANGED) {
            $line = ($node["status"] === UNCHANGED) ? getIndent($level + 1, UNCHANGED) . $node["key"] . ": "
                : getIndent($level + 1, REMOVED)   . $node["key"] . ": ";

            if (is_array($node["before"])) {
                $acc[] = $line . "{";

                $accInside = getChildrenTree($node["before"], $level + 1);
                $acc = [...$acc, ...$accInside];

                $acc[] = getIndent($level + 1) . "}";
            } else {
                $acc[] = $line . toString($node["before"]);
            }
        }

        if ($node["status"] === UPDATED || $node["status"] === ADDED) {
            $line = getIndent($level + 1, ADDED) . $node["key"] . ": ";
            if (is_array($node["after"])) {
                $acc[] = $line . "{";

                $accInside = getChildrenTree($node["after"], $level + 1);
                $acc = [...$acc, ...$accInside];

                $acc[] = getIndent($level + 1) . "}";
            } else {
                $acc[] = $line . toString($node["after"]);
            }
        }

        if ($node["status"] === NESTED) {
            $line = getIndent($level + 1, NESTED) . $node["key"] . ": ";

            $acc[] = $line . "{";
            $accInside = step($node["children"], $level + 1);
            $acc = [...$acc, ...$accInside];

            $acc[] = getIndent($level + 1) . "}";
        }

        return $acc;
    }, []);
}

function getChildrenTree(array $tree, int $level)
{
    $acc = [];
    foreach ($tree as $key => $value) {
        $line = getIndent($level + 1) . $key . ": ";

        if (is_array($value)) {
            $acc[] = $line . "{";
            $accInside = getChildrenTree($value, $level + 1);
            $acc = [...$acc, ...$accInside];
            $acc[] = getIndent($level + 1) . "}";
        } else {
            $acc[] = $line . toString($value);
        }
    }

    return $acc;
}

function getIndent(int $level, string $status = UNCHANGED)
{
    if ($level === 0) {
        return "";
    }

    switch ($status) {
        case ADDED:
            return str_repeat(" ", ($level * 4) - 2) . "+ ";
        case REMOVED:
            return str_repeat(" ", ($level * 4) - 2) . "- ";
        default:
            return str_repeat(" ", $level * 4);
    }
}

function toString(mixed $value)
{
    if (is_bool($value)) {
        return ($value) ? "true" : "false";
    }

    if (is_null($value)) {
        return "null";
    }

    return (string)$value;
}
