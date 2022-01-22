<?php

namespace Gendiff\Format;

const ADDED = 'added';
const REMOVED = 'removed';
const UNCHANGED = 'unchanged';
const NESTED = 'nested';

function format($dict, $format)
{
    if ($format === "stylish") {
        return stylishFormat($dict);
    }

    return "";
}

function stylishFormat($dict)
{
    return "{\n" . implode("\n", stylishFormatStep($dict, 0)) . "\n}\n";
}

function stylishFormatStep($dict, $level)
{
    return array_reduce($dict, function ($acc, $node) use ($level) {
        $line = getIndent($level + 1, $node["status"]) . $node["key"] . ": ";

        if (is_array($node["node"])) {
            $acc[] = $line . "{";

            $accInside = [];
            if ($node["status"] === NESTED) {
                $accInside = stylishFormatStep($node["node"], $level + 1);
            } else {
                $accInside = getStylishChildrenTree($node["node"], $level + 1);
            }
            $acc = [...$acc, ...$accInside];

            $acc[] = getIndent($level + 1) . "}";
        } else {
            $acc[] = $line . toString($node["node"]);
        }

        return $acc;
    }, []);
}

function getStylishChildrenTree($tree, $level)
{
    $acc = [];
    foreach ($tree as $key => $value) {
        $line = getIndent($level + 1) . $key . ": ";

        if (is_array($value)) {
            $acc[] = $line . "{";
            $accInside = getStylishChildrenTree($value, $level + 1);
            $acc = [...$acc, ...$accInside];
            $acc[] = getIndent($level + 1) . "}";
        } else {
            $acc[] = $line . toString($value);
        }
    }

    return $acc;
}

function getIndent($level, $status = UNCHANGED)
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

function toString($value)
{
    if (is_bool($value)) {
        return ($value) ? "true" : "false";
    }

    if (is_null($value)) {
        return "null";
    }

    return (string)$value;
}
