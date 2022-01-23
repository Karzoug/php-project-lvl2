<?php

namespace Differ\Formatters\Json;

function format(array $dict)
{
    return json_encode($dict, JSON_PRETTY_PRINT);
}
