<?php

namespace Differ\Formatters\Json;

function format($dict)
{
    return json_encode($dict, JSON_PRETTY_PRINT) . PHP_EOL;
}
