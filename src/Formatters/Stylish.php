<?php

namespace Differ\Formatters\Stylish;

use const Differ\Diff\ADDED;
use const Differ\Diff\NESTED;
use const Differ\Diff\UNCHANGED;
use const Differ\Diff\REMOVED;
use const Differ\Diff\UPDATED;

function format(array $dict)
{
    return "{\n" . implode("\n", step($dict, 0)) . "\n}";
}

function step(array $dict, int $level)
{
    $result = array_reduce($dict, function ($acc, $node) use ($level) {
        if ($node["status"] === UPDATED || $node["status"] === REMOVED || $node["status"] === UNCHANGED) {
            $line = ($node["status"] === UNCHANGED) ? getIndent($level + 1, UNCHANGED) . $node["key"] . ": "
                : getIndent($level + 1, REMOVED)   . $node["key"] . ": ";

            if (is_array($node["before"])) {
                $acc->push($line . "{");

                $accInside = getChildrenTree($node["before"], $level + 1);
                $acc = $acc->merge($accInside); /** @phpstan-ignore-line */

                $acc->push(getIndent($level + 1) . "}");
            } else {
                $acc->push($line . toString($node["before"]));
            }
        }

        if ($node["status"] === UPDATED || $node["status"] === ADDED) {
            $line = getIndent($level + 1, ADDED) . $node["key"] . ": ";
            if (is_array($node["after"])) {
                $acc->push($line . "{");

                $accInside = getChildrenTree($node["after"], $level + 1);
                $acc = $acc->merge($accInside); /** @phpstan-ignore-line */

                $acc->push(getIndent($level + 1) . "}");
            } else {
                $acc->push($line . toString($node["after"]));
            }
        }

        if ($node["status"] === NESTED) {
            $line = getIndent($level + 1, NESTED) . $node["key"] . ": ";

            $acc->push($line . "{");
            $accInside = step($node["children"], $level + 1);
            $acc = $acc->merge($accInside); /** @phpstan-ignore-line */

            $acc->push(getIndent($level + 1) . "}");
        }

        return $acc;
    }, collect([]));

    return $result->all();
}

function getChildrenTree(array $tree, int $level)
{
    $result = collect($tree)->reduce(function ($acc, $value, $key) use ($level) {
        $line = getIndent($level + 1) . $key . ": ";

        if (is_array($value)) {
            $acc->push($line . "{");
            $accInside = getChildrenTree($value, $level + 1);
            $acc = $acc->merge($accInside); /** @phpstan-ignore-line */
            $acc->push(getIndent($level + 1) . "}");
        } else {
            $acc->push($line . toString($value));
        }
        return $acc;
    }, collect([]));

    return $result->all();
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
