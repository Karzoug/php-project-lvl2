<?php

namespace Gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($data, $format = "json")
{
    if ($format === "yaml") {
        return parseYaml($data);
    } else {
        return parseJson($data);
    }
}

function parseJson($data)
{
    return json_decode($data, true);
}

function parseYaml($data)
{
    return Yaml::parse($data) ?? [];
}
