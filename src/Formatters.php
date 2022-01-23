<?php

namespace Differ\Formatters;

function format(array $dict, string $format)
{
    switch ($format) {
        case 'plain':
            return Plain\format($dict);
            break;
        case 'json':
            return Json\format($dict);
            break;
        default:
            return Stylish\format($dict);
            break;
    }
}
