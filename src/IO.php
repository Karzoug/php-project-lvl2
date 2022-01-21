<?php

namespace Gendiff\IO;

function getDataFromFile($fileName)
{
    if (!file_exists($fileName)) {
        return false;
    }

    $data = file_get_contents($fileName);

    if ($data === false) {
        return false;
    }

    return $data;
}
