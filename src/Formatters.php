<?php

namespace Gendiff\Formatters;

function format($dict, $format)
{
    if ($format === "plain") {
        return Plain\format($dict);
    } else {
        return Stylish\format($dict);
    }

    return "";
}
