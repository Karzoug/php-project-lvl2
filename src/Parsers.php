<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $data, string $format = "json")
{
    if ($format === "yaml") {
        return parseYaml($data);
    } else {
        return parseJson($data);
    }
}

function parseJson(string $data)
{
    return json_decode($data, true);
}

function parseYaml(string $data)
{
    return Yaml::parse($data) ?? [];
}
