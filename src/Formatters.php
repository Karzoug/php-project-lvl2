<?php

namespace Gendiff\Formatters;

function format($dict, $format)
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

    return "";
}
