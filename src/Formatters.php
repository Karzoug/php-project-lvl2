<?php

namespace Differ\Formatters;

function format(array $dict, string $format)
{
    switch ($format) {
        case 'plain':
            return Plain\format($dict);
        case 'json':
            return Json\format($dict);
        default:
            return Stylish\format($dict);
    }
}
